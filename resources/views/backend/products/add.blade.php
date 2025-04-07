@extends('layouts.backend')
@section('content')
<div class="row mb-3">
    <div class="col-2">
        <a href="{{route('admin.products.index')}}" class="btn-cus-success">Quay lại</a>
    </div>
</div>
@if(session('msg'))
<div class="alert alert-success text-center">
    {{ session('msg') }}
</div>
@endif
<form action="" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mt-2">
            <label for="">Tên sản phẩm</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" 
            placeholder="Nhập tên sản phẩm ..." required>
        </div>
        <div class="col-6 mt-2">
            <label for="">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug"
                value="{{ old('slug') }}" placeholder="" required>
        </div>
        <div class="col-4 mt-2">
            <label for="">Giá</label>
            <input type="text" class="form-control" name="price" id="price"
                value="{{ old('price') }}" placeholder="Nhập giá ..." required>
        </div>
        <div class="col-4 mt-2">
            <label for="">Giảm (%)</label>
            <input type="text" class="form-control" name="discount" id="discount"
                value="{{ old('discount') }}" placeholder="">
        </div>
        <div class="col-4 mt-2">
            <label for="">Giá bán</label>
            <input type="text" class="form-control" name="sale_price" id="sale_price"
                value="{{ old('sale_price') }}" placeholder="" required>
        </div>
        <div class="col-4 mt-2">
            <label for="">Mã sản phẩm</label>
            <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}"
                placeholder="Nhập mã sản phẩm (6 số) ..." minlength="6" maxlength="6" onblur="handleCheckCode(this.value)" required>
            <label for="" class="error-code d-none" style="color: red;">error</label>
        </div>
        <div class="col-4 mt-2">
            <label for="">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Chọn</option>
                @if(!empty($categories))
                @foreach ($categories as $category)
                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{$category->name}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-4 mt-2">
            <label for="">Trạng thái</label>
            <select name="status" id="status" class="form-control">
                <option value="0">Chưa ra mắt</option>
                <option value="1">Đã ra mắt</option>
            </select>
        </div>
        <div class="col-12 mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <label for="" style="font-weight: 700">Ảnh 1</label>
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_1"
                                    value="">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_1" data-input="gallery_1"
                                    data-preview="holder_1">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_1">
                                    <img src="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <label for="" style="font-weight: 700">Ảnh 2</label>
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_2"
                                    value="">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_2" data-input="gallery_2"
                                    data-preview="holder_2">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_2">
                                    <img src="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <label for="" style="font-weight: 700">Ảnh 3</label>
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_3"
                                    value="">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_3" data-input="gallery_3"
                                    data-preview="holder_3">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_3">
                                    <img src="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            @if (!empty($sizes))
            <div class="row">
                @php
                $columnCount = 5; // Chia thành 4 cột
                $sortedSizes = $sizes->sortBy('size_number')->values(); // Sắp xếp size theo số
                $sizePerColumn = ceil($sortedSizes->count() / $columnCount); // Số size mỗi cột
                $chunks = array_chunk($sortedSizes->toArray(), $sizePerColumn); // Chia size thành các nhóm
                $index = 0;
                @endphp

                @foreach ($chunks as $chunk)
                <div class="col-md-2"> <!-- Mỗi cột chiếm 2/12 -->
                    @foreach ($chunk as $size)
                    <div class="form-check form-check-large d-flex align-items-center mb-2 size-quantity-item">
                        <!-- Checkbox Size -->
                        <input type="checkbox"
                            class="form-check-input me-2"
                            name="sizes[{{$index}}]"
                            value="{{ $size['id'] }}"
                            id="size-{{ $size['size_number'] }}">
                        <label class="form-check-label"
                            for="size-{{ $size['size_number'] }}">
                            Size: {{ $size['size_number'] }}
                        </label>

                        <!-- Input Quantity -->
                        <input type="text"
                            class="form-control form-control-sm quantity-input" style="margin-left: 25%;"
                            name="quantity[{{$index}}]"
                            placeholder="Số lượng">
                    </div>
                    @php $index++ @endphp
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-12 group-control">
            <label for="" style="font-weight: 700; font-size: 18px;">Mô tả sản phẩm</label>
            <textarea class="form-control ckeditor" name="description"></textarea>
        </div>

        <style>
            .form-check-large .form-check-input {
                width: 1.5rem;
                /* Tăng kích thước checkbox */
                height: 1.5rem;
            }

            .form-check-large .form-check-label {
                font-size: 15px;
                /* Tăng kích thước chữ */
                margin-left: 0.5rem;
                /* Khoảng cách giữa checkbox và chữ */
            }
        </style>
    </div>
    <div class="row py-4">
        <div class="col-4">
            <button type="submit" class="btn-cus-primary">Lưu lại</button>
        </div>
    </div>
</form>
<script>
    const codeError = document.querySelector('.error-code');
    const handleCheckCode = async (code) => {
        codeError.classList.add('d-none');
        try {
            const response = await fetch('/admin/products/check-code', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify({ code: code }),
            });
            const { success, message } = await response.json();
            if (!success) {
                throw new Error(message);
            }
        } catch (error) {
            codeError.classList.remove('d-none');
            codeError.textContent = error.message;
        }

    };
    window.addEventListener('DOMContentLoaded', () => {
        const priceInput = document.querySelector('#price');
        const discountInput = document.querySelector('#discount');
        const salePriceInput = document.querySelector('#sale_price');


        // Hàm tính giá bán sau giảm giá
        const calculateSalePrice = () => {
            const price = parseFloat(priceInput.value.replace(/[^0-9.]/g, '')) || 0; // Loại bỏ ký tự không phải số
            const discount = parseFloat(discountInput.value.replace(/[^0-9.]/g, '')) || 0; // Loại bỏ ký tự không phải số
            const salePrice = price - (price * (discount / 100));
            salePriceInput.value = formatNumber(salePrice) || 0; // Định dạng giá và gán vào ô nhập liệu
        };

        // Hàm kiểm tra và chỉ cho phép nhập số
        const allowNumericInput = (input) => {
            input.addEventListener('input', (e) => {
                let value = e.target.value;
                // Loại bỏ tất cả ký tự không phải là số và dấu chấm
                value = value.replace(/[^0-9.]/g, '');
                e.target.value = formatNumber(value); // Định dạng số khi nhập
            });
        };

        // Hàm định dạng số với dấu phân cách hàng nghìn
        const formatNumber = (number) => {
            if (number === 0 || number === '') return '';
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Định dạng số thành dạng '1,000,000'
        };

        // Lắng nghe sự kiện input trên giá trị Price và Discount
        priceInput.addEventListener('input', calculateSalePrice);
        discountInput.addEventListener('input', calculateSalePrice);

        // Áp dụng kiểm tra cho các ô nhập liệu
        allowNumericInput(priceInput);
        allowNumericInput(discountInput);
    });
</script>
@endsection