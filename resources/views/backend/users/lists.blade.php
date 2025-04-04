@extends('layouts.backend')
@section('content')
    @if(session('msg'))
    <div class="alert alert-success text-center">
        {{ session('msg') }}
    </div>
    @endif
    <div class="row mb-4">
        <div class="col">
            <input type="search" class="form-control" name="search" id="keyword" placeholder="Nhập từ cần tìm ...">
        </div>
    </div>
    <hr>
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{route('admin.users.create')}}" class="btn-cus-primary">Thêm mới</a>
        </div>
    </div>
    <table class="table table-bordered" id="users_table">
        <thead class="text-center">
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Ngày tạo</th>
                <th>Sửa</th>
                <th>Xóa</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @if (!empty($users))
                @php $index = 1 @endphp
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'Không' }}</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{route('admin.users.edit', $user->id)}}" class="btn-cus-warning edit-btn"><i class="fa fa-edit"></i></a>
                        </td>
                        <td> 
                            <a href="#" class="btn-cus-danger delete-btn" data-id="{{$user->id}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
                const deleteRow = () => {
                    document.querySelectorAll('.delete-btn').forEach(element => {
                        element.addEventListener('click', (e) => {
                            const id = e.target.dataset.id;
                            e.preventDefault();
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
                                    if(deleteUser(id).then((response) => {
                                        if(response) {
                                            alert(response.message);
                                            element.closest('tr').remove()
                                        }
                                    }));
                                    
                                }
                            });
                        });
                    }); 
                }
                document.querySelector('#keyword').addEventListener('input', (e) => {
                    searchUsers(e.target.value);
                    
                    
                });
                const deleteUser = async (id) => {
                    const response = await fetch(`/admin/users/delete/${id}`, {
                        method : "DELETE",
                        headers : {
                            "X-CSRF-TOKEN" : token,
                            Accept: "application/json",
                        },
                    });
                    if (!response.ok) {
                        const data = await response.json();
                        alert(data.message || 'Lỗi hệ thống!');
                        return null;
                    }
                    return await response.json();
                } 

                const searchUsers = async (keyword) => {
                    const response = await fetch(`/admin/users/search`, {
                        method : "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json",
                            Accept: "application/json"
                        },
                        body: JSON.stringify({ 'keyword': keyword }),
                    });
                    const data = await response.json();
                    if(data.users) {
                        let rows = "";
                        let index = 1;
                        const table = document.querySelector('#users_table');
                        data.users.forEach((item) => {
                            const rawDate = new Date(item.created_at);
                            const created_at = rawDate.toLocaleDateString('vi-VN');
                            rows += 
                                `<tr>
                                    <td>${index++}</td>
                                    <td>${item.name}</td>
                                    <td>${item.email}</td>
                                    <td>${item.phone}</td>
                                    <td>${created_at}</td>
                                    <td>
                                        <a href="/admin/users/edit/${item.id}" class="btn-cus-warning edit-btn">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="btn-cus-danger delete-btn" data-id="${item.id}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>`;
                        });
                        table.querySelector('tbody').innerHTML = rows;
                    }
                    deleteRow();
                }
                deleteRow();
        });
    </script>
@endsection