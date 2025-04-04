@extends('layouts.backend')
@section('content')
    @if(session('msg'))
    <div class="alert alert-success text-center">
        {{ session('msg') }}
    </div>
    @endif
    <div class="row mb-3">
        <div class="col-2">
            <a href="" class="btn-cus-primary add-btn">Thêm mới</a>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th style="width: 5%">No.</th>
                <th>Tên</th>
                <th>Link</th>
                <th style="width: 10%">Cập nhật</th>
                <th style="width: 10%">Xóa</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @if(count($categories) > 0)
                @php $no = 1; @endphp
                @foreach ($categories as $category)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        <a href="#" class="btn-cus-primary view-btn " data-id="{{$category->id}}">Xem</a>
                    </td>
                    <td>
                        <a href="#" class="btn-cus-warning edit-btn" data-id="{{$category->id}}"><i class="fa fa-edit"></i></a>
                    </td>
                    <td> 
                        <a href="#" class="btn-cus-danger delete-btn" data-id="{{$category->id}}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script>
        window.addEventListener('DOMContentLoaded', () => {

            const addButton = document.querySelector('.add-btn');
            const editButton = document.querySelectorAll('.edit-btn');
            const deleteButton = document.querySelectorAll('.delete-btn');

            deleteButton.forEach((element) => {
                element.addEventListener('click', (e) => {
                    Swal.fire({
                        title: "Bạn có chắc muốn xóa?",
                        text: '',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Đồng ý",
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteCategory(e.target.dataset.id);
                        }
                    });
                });
            })
            

            addButton.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.querySelector('#modal'));
                const title =  "Thêm danh mục";
                const body = 
                    `<input type="text" class="form-control mb-2" name="name" id="name" placeholder="Nhập tên danh mục ...">
                    <input type="text" class="form-control" name="slug" id="slug">`;
                const footer = 
                    `<button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary save-btn" href="">Lưu</a>`
                openModal(title, body, footer);
                const nameInput = document.querySelector('#name');
                const slugInput = document.querySelector('#slug');
                nameInput.addEventListener('input', (e) => {
                    e.preventDefault();
                    slugInput.value = getSlug(e.target.value);
                });
                const saveButton = document.querySelector('.save-btn');
                saveButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    if(nameInput.value && slugInput.value) {
                        createCategory(nameInput.value, slugInput.value);
                    }else{
                        alert('Vui lòng nhập dữ liệu!');
                    }
                });

            });
            editButton.forEach((element) => {
                element.addEventListener('click', (e) => {
                    const categoryId = element.dataset.id;
                    fetch(`/admin/categories/edit/${categoryId}`).then((response) => response.json()).then((result) => {
                        const title =  "Cập nhật danh mục";
                        const body = 
                            `<input type="text" class="form-control mb-2" name="name" id="name" value="${result.data.name}" placeholder="Nhập tên danh mục ...">
                            <input type="text" class="form-control" value="${result.data.slug}" name="slug" id="slug">`;
                        const footer = 
                            `<button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                            <a class="btn btn-primary save-btn" href="">Lưu</a>`
                        openModal(title, body, footer);
                        const nameInput = document.querySelector('#name');
                        const slugInput = document.querySelector('#slug');
                        nameInput.addEventListener('input', (e) => {
                            e.preventDefault();
                            slugInput.value = getSlug(e.target.value);
                        });
                        const saveButton = document.querySelector('.save-btn');
                        saveButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            if(nameInput.value && slugInput.value) {
                                updateCategory(categoryId, nameInput.value, slugInput.value);
                            }else{
                                alert('Vui lòng nhập dữ liệu!');
                            }
                        });           
                    });
                    
                });
                
            });
            const deleteCategory = async (id) => {
                const response = await fetch(`/admin/categories/delete/${id}`, {
                    method : "DELETE",
                    headers : {
                        "X-CSRF-TOKEN" : token,
                        Accept: "application/json",
                    },
                });
                const result = await response.json();
                if(result.stt === 1) {
                    if(confirm(result.message)) {
                        window.location.href = '/admin/categories';
                    }
                    window.location.href = '/admin/categories';
                }else{
                    alert(result.message);
                }
                
            }
            const createCategory = async (name, slug) => {
                const filters = {
                    'name': name,
                    'slug' : slug
                };
                const response = await fetch(`/admin/categories/create`, {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(filters),
                });
                const result = await response.json();
                if(result.stt === 1) {
                    if(confirm(result.message)) {
                        window.location.href = '/admin/categories';
                    }
                    window.location.href = '/admin/categories';
                }
            }
            const updateCategory = async (id, name, slug) => {
                const filters = {
                    'id' : id,
                    'name': name,
                    'slug' : slug
                };
                const response = await fetch(`/admin/categories/edit/${id}`, {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(filters),
                });
                const result = await response.json();
                if(result.stt === 1) {
                    if(confirm(result.message)) {
                        window.location.href = '/admin/categories';
                    }
                    window.location.href = '/admin/categories';
                }else{
                    alert(result.message);
                }
            }
        });
        
    </script>
@endsection