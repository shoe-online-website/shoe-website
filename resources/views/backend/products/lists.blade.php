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
            <a href="{{route('admin.products.create')}}" class="btn-cus-primary">Thêm mới</a>
        </div>
    </div>
    <table class="table table-bordered" id="products_table">
        <thead class="text-center">
            <tr>
                <th>No.</th>
                <th style="width: 10%">
                    Danh mục
                    <select id="categories">
                        <option value="">Tất cả</option>
                        @if (!empty($categories))
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </th>
                <th>Tên</th>
                <th>Mã</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Giảm giá</th>
                <th>Tổng</th>
                <th>Size</th>
                <th>
                    Trạng thái
                    <select id="status">
                        <option value="">Tất cả</option>
                        <option value="0">Sắp ra mắt</option>
                        <option value="1">Đã ra mắt</option>
                    </select>
                </th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @if(count($products) > 0)
                @php $no = 1; @endphp
                @foreach ($products as $product)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->code}}</td>
                        <td><img src="{{$product->image}}" alt="" style="width: 100px; height: 100px"></td>
                        <td>{{money($product->price)}}đ</td>
                        <td>-{{money($product->discount)}}%</td>
                        <td>{{money($product->sale_price)}}đ</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm size-view" data-id="{{$product->id}}">xem</a>
                        </td>
                        <td>
                            @if ($product->status == 0)
                                <span class="badge bg-warning" style="color: white">Sắp ra mắt</span>
                            @else
                                <span class="badge bg-success" style="color: white">Đã ra mắt</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.products.edit', $product->id)}}" class="btn-cus-warning edit-btn"><i class="fa fa-edit"></i></a><br>
                            <a href="#" class="btn-cus-danger delete-btn mt-2" data-id="{{$product->id}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <style>
        /* Container tổng */
        .size-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px; /* Khoảng cách giữa các size */
        }
    
        /* Hộp size */
        .size-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa; /* Màu nền nhạt */
            border: 1px solid #ddd; /* Viền mỏng */
            border-radius: 5px; /* Góc bo tròn */
            padding: 5px; /* Khoảng cách bên trong */
            width: 100px; /* Chiều rộng hộp nhỏ */
            height: 50px; /* Chiều cao cố định */
            text-align: center;
            font-size: 15px; /* Cỡ chữ nhỏ hơn */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Hiệu ứng nổi nhẹ */
            transition: transform 0.2s;
        }
    
        /* Hiệu ứng hover cho hộp size */
        .size-box:hover {
            background-color: #ffd700; /* Màu vàng */
            transform: scale(1.05); /* Phóng to nhẹ */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Đổ bóng đậm hơn */
            cursor: pointer; /* Tay chỉ khi hover */
        }
    
        /* Nhãn size */
        .size-label {
            font-weight: bold;
            color: #333; /* Màu chữ size */
            margin-bottom: 3px;
        }
    
        /* Số lượng */
        .size-quantity {
            color: #555; /* Màu chữ số lượng */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productTable = document.querySelector('#products_table');
            const searchInput = document.querySelector('#keyword');
            const categoriesSelect = document.querySelector('#categories');
            const statusSelect = document.querySelector('#status');
            searchInput.addEventListener('blur', (e) => searchProduct());
            categoriesSelect.addEventListener('change', (e) => searchProduct());
            statusSelect.addEventListener('change', (e) => searchProduct());
            const searchProduct = async () => {
                const filters = {
                    'keyword': searchInput.value,
                    'category_id': categoriesSelect.value,
                    'status': statusSelect.value
                };
                const response = await fetch(`/admin/products/search`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(filters),
                });
                if (!response.ok) {
                    alert('Lỗi hệ thống!');
                    return;
                }
                const data = await response.json();
                var productHTML = "";
                let index = 1;
                data.products.forEach((item) => {
                    productHTML += "<tr>";
                    productHTML += "<td>" + index++ + "</td>"
                    productHTML += "<td>" + item.category.name + "</td>";
                    productHTML += "<td>" + item.name + "</td>";
                    productHTML += "<td>" + item.code + "</td>";
                    productHTML += "<td><img src='" + item.image + "' alt='' style='width: 100px; height: 100px'></td>";
                    productHTML += "<td>" + Number(item.price).toLocaleString('en-US') + "đ</td>";
                    productHTML += "<td>-" + item.discount + "%</td>";
                    productHTML += "<td>" + Number(item.sale_price).toLocaleString('en-US') + "đ</td>";
                    productHTML += "<td><a href='#' class='btn btn-primary btn-sm size-view' data-id='" + item.id + "'>xem</a></td>";
                    productHTML += item.status
                                ? "<td><span class='badge bg-success' style='color: white'>Đã ra mắt</span></td>" 
                                : "<td><span class='badge bg-warning' style='color: white'>Sắp ra mắt</span></td>";
                    productHTML += "<td><a href='/admin/products/edit/" + item.id + "' class='btn-cus-warning edit-btn'><i class='fa fa-edit'></i></a></br><a href='' class='btn-cus-danger delete-btn mt-2' data-id='" + item.id + "'><i class='fa fa-trash'></i></a></td>";
                    productHTML += "</tr>";
                });
                productTable.querySelector('tbody').innerHTML = productHTML;
                sizeView();
                deleteProductButton();
            }
            const sizeView = () => {
                document.querySelectorAll('.size-view').forEach((element) => {
                    element.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log(element);
                        
                        const id = e.target.dataset.id;
                        productSizesModal(id);     
                    })
                });
            };
            const deleteProductButton = () => {
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
                                if(deleteProduct(id).then((response) => {
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
            const deleteProduct = async (id) => {
                const response = await fetch(`/admin/products/delete/${id}`, {
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
            const productSizesModal = async (id) => {
                const response = await fetch(`/admin/products/productSizes`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Content-Type": "application/json",
                        Accept: "application/json"
                    },
                    body: JSON.stringify({ id }),
                });

                if (!response.ok) {
                    const data = await response.json();
                    alert(data.message || 'Lỗi hệ thống!');
                    return;
                }

                const data = await response.json();
                const sizeBox = data.sizes.length > 0
                    ? data.sizes
                        .map(item => `
                            <div class="size-box">
                                <span class="size-label">${item.size_number}</span>
                                <span class="size-quantity"><strong>SL:</strong> ${item.pivot.quantity}</span>
                            </div>`)
                        .join("")
                    : "<span>Không có size nào!</span>";

                const title = "Số lượng size giày hiện có";
                const body = `<div class="size-container">${sizeBox}</div>`;
                const footer = `<a class="btn btn-primary" href="/admin/products/edit/${id}">Điều chỉnh</a>`;
                openModal(title, body, footer);
                return;
            };
            sizeView();
            deleteProductButton();
        });
    </script>
@endsection
