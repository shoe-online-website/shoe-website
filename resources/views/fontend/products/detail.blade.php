@extends('layouts.fontend')

@section('content')
@include('parts.fontend.search')
@include('parts.fontend.breadcrumbs', ['breadcrumbs' => [
    $product->category->name => '/san-pham/'.$product->category->slug,
    $product->name => $product->slug                                   
    ]])
<section class="ps-product--detail pt-2 pt-lg-5">
    <div class="container">
        <div class="row justify-content-center">
            {{-- begin-image --}}
            @include('fontend.products.parts.gallery', ['gallery' => json_decode($product->gallery)])
            {{-- end-image --}}
            {{-- begin-productDetail --}}
            <div class="col-12 col-lg-6 col-xl-5 mt-3 mt-lg-0">
                <div class="ps-product__info">
                  <div class="ps-product__rating_code d-flex flex-wrap justify-content-between">
                    <div class="ps-product__rating">
                      <div class="br-wrapper br-theme-fontawesome-stars">
                        <div class="br-widget">
                          <a href="#" data-rating-value="1" data-rating-text="1" class="br-selected"></a>
                          <a href="#" data-rating-value="2" data-rating-text="2" class="br-selected"></a>
                          <a href="#" data-rating-value="3" data-rating-text="3" class="br-selected"></a>
                          <a href="#" data-rating-value="4" data-rating-text="4" class="br-selected"></a>
                          <a href="#" data-rating-value="5" data-rating-text="5" class="br-selected br-current"></a>
                          <div class="br-current-rating">5</div>
                        </div>
                      </div>
                    </div>
                  </div>
              
                  <div id="alertsuccess" class="alert alert-success" style="display:none;"></div>
              
                    <div class="name-price">
                        <h1>{{$product->name}}</h1>
                        <p class="ps-product__category">Mã SP: <strong>{{$product->code}}</strong></p>
                        <div class="infor-price">
                            <div class="ps-product__price">
                                @if ($product->discount > 0)
                                    <b class="new-price">{{money($product->sale_price)}} đ</b> 
                                    <del class="old-price">{{money($product->price)}} đ</del>
                                @else
                                    <b class="new-price">{{money($product->price)}} đ</b>
                                @endif

                            </div>
                        </div>
                    </div>
                    @if ($product->status == 1 && count($sizes) > 0)
                        @include('fontend.products.parts.handleBuy', ['sizes' => $sizes, 'product' => $product])
                    @else 
                        <div class="ps-product__block ps-product__quickview">
                            <span style="color:#e74c3c;">
                                <strong>Hiện đã hết hàng<br>Mong quý khách thông cảm !</strong>
                            </span>
                        </div>
                    @endif
                  <div class="block_phone">
                    <span class="text">Liên hệ: </span>
                    <a title="Tư vấn &amp; đặt hàng: 0909300746" href="tel:0909300746">0909300746</a>
                    ( Tư vấn Miễn phí )
                  </div>
                </div>
            </div>
            {{-- end-productDetail --}}
              
        </div>
    </div>
</section>
@include('parts.fontend.related', 
['product_related' => getRelatedProducts($product->id, $product->category->id)]
)
@endsection
