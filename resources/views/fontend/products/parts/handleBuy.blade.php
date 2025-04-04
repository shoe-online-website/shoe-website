<div class="size-color mt-3">
    <div class="product-form product-size">
        <div class="row">
            <label class="font-weight-bold text-uppercase h6 mb-2 d-block col-12">Chọn Size Giày</label>
            <div class="col-12">
                <div class="list-attribute-in">
                    <ul class="wapper_cb size d-flex flex-lg-wrap">
                        @foreach ($sizes as $size)
                            <li class="cb">
                                <label for="radio{{$size->id}}{{$size->size_number}}">
                                <input type="radio" data-id="{{$size->size_number}}" value="{{$size->size_number}}" 
                                id="radio{{$size->id}}{{$size->size_number}}" name="radio{{$size->id}}" class="radio">
                                <div class="rd_in">{{$size->size_number}}</div>
                                </label>
                            </li>
                            <div class="clear"></div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="addToCart" method="post" accept-charset="UTF-8" 
    class="ProductForm mt-2 mt-lg-3 mb-4" enctype="multipart/form-data" onsubmit=" return false;">
    <input type="hidden" name="productId" id="productId" value="{{$product->id}}">
    <div class="row align-items-center g-1">
        <div id="message-box" class="col-12"></div>
        <div class="col-12 col-md-auto col-auto mb-2 mb-md-0">
            <div class="product-form product-qty">
                <div class="product-form-group">
                    <div class="number_price d-flex justify-content-center">
                        <div class="custom">
                            <button class="reduced items-count sub" type="button">-</button>
                            <input type="text" class="input-text qty" title="Qty" min="1" maxlength="12" id="qty" 
                                name="quantity" value="1" readonly="">
                            <button class="increase items-count add" type="button">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-auto">
            <button class="ps-btn d-block m-0 w-100 mb-10 text-center btn-pro-detail" data-action="addCart">
            <i class="fa-solid fa-cart-circle-plus"></i> Thêm vào giỏ</button>
        </div>
        <div class="col-6 col-md-auto">
            <button class="ps-btn btn-buy-now d-block m-0 w-100 mb-10 text-center btn-pro-detail" data-action="buyNow">
                Mua ngay <i class="fa-solid fa-arrow-right-to-line"></i>
            </button>
        </div>
    </div>
</form>
<div class="girdPro"></div>

