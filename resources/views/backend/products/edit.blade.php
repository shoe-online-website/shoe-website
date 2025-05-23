@extends('layouts.backend')
@section('content')
<div class="row mb-3">
    <div class="col-2">
        <a href="{{route('admin.products.index')}}" class="btn-cus-success">Quay lại</a>
    </div>
</div>
<form action="" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mt-2">
            <label for="">Tên sản phẩm</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" placeholder="Nhập tên sản phẩm ...">
        </div>
        <div class="col-6 mt-2">
            <label for="">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{$product->slug}}" placeholder="">
        </div>
        <div class="col-4 mt-2">
            <label for="">Giá</label>
            <input type="text" class="form-control" name="price" id="price" value="{{money($product->price)}}" placeholder="Nhập giá ...">
        </div>
        <div class="col-4 mt-2">
            <label for="">Giảm (%)</label>
            <input type="text" class="form-control" name="discount" id="discount" value="{{money($product->discount)}}" placeholder="">
        </div>
        <div class="col-4 mt-2">
            <label for="">Tổng</label>
            <input type="text" class="form-control" name="sale_price" id="sale_price" value="{{money($product->sale_price)}}" placeholder="">
        </div>
        <div class="col-4 mt-2">
            <label for="">Mã sản phẩm</label>
            <input type="text" class="form-control" name="code" id="code" value="{{$product->code}}" placeholder="Nhập mã sản phẩm (6 số) ..." minlength="6" maxlength="6">
        </div>
        <div class="col-4 mt-2">
            <label for="">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Chọn</option>  
                @if(!empty($categories))
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : false}}>{{$category->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-4 mt-2">
            <label for="">Trạng thái</label>
            <select name="status" id="status" class="form-control">
                <option value="0" {{$product->category_id == 0 ? 'selected' : false}}>Chưa ra mắt</option>
                <option value="1" {{$product->category_id == 1 ? 'selected' : false}}>Đã ra mắt</option>
            </select>
        </div>
        <div class="col-12 mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <label for="" style="font-weight: 700">Ảnh 1</label>
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_1" value="{{ json_decode($product->gallery)[0]}}">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_1" data-input="gallery_1" data-preview="holder_1">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_1">
                                    <img src="{{ json_decode($product->gallery)[0]}}"/>
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
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_2" value="{{ json_decode($product->gallery)[1]}}">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_2" data-input="gallery_2" data-preview="holder_2">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_2">
                                    <img src="{{ json_decode($product->gallery)[1]}}" />
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
                                <input type="text" name="gallery[]" class="form-control" placeholder="Đường dẫn ảnh ..." id="gallery_3" value="{{ json_decode($product->gallery)[2]}}">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="button" class="btn btn-primary" id="lfm-image_3" data-input="gallery_3" data-preview="holder_3">Chọn</button>
                            </div>
                            <div class="col-3 mt-3">
                                <div id="holder_3">
                                    <img src="{{ json_decode($product->gallery)[2]}}" />
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
                        $columnCount = 5; // Chia thành 5 cột
                        $sizePerColumn = ceil(count($sizes) / $columnCount); // Số size mỗi cột
                        $chunks = array_chunk($sizes->toArray(), $sizePerColumn); // Chia size thành các nhóm
                        $index = 0;
                        $sizeIds = $product->sizes()->pluck('sizes.id')->toArray();
                        
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
                                           id="size-{{ $size['size_number'] }}"
                                           {{ in_array($size['id'], $sizeIds) ? 'checked' : '' }}>
                                    <label class="form-check-label" 
                                           for="size-{{ $size['size_number'] }}">
                                        Size: {{ $size['size_number'] }}
                                    </label>
        
                                    <!-- Input Quantity -->
                                    <input type="text" 
                                           class="form-control form-control-sm quantity-input" style="margin-left: 25%;"
                                           name="quantity[{{$index}}]" value="{{ $product->sizes->where('id', $size['id'])->first()->pivot->quantity ?? '' }}"
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
            <textarea class="form-control ckeditor" name="description">{{$product->description}}</textarea>
        </div>
        
        <style>
            .form-check-large .form-check-input {
                width: 1.5rem; /* Tăng kích thước checkbox */
                height: 1.5rem;
            }

            .form-check-large .form-check-label {
                font-size: 15px; /* Tăng kích thước chữ */
                margin-left: 0.5rem; /* Khoảng cách giữa checkbox và chữ */
            }
            img {
                max-width: 100px;
                height: 100px;
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