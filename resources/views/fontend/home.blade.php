@extends('layouts.fontend')
@section('content')
@include('parts.fontend.banner')
@include('parts.fontend.features')
<section class="ps-section--features-product ps-section pt-40 pb-40">
    <div class="container">
        <div class="ps-section__header mb-50 clearfix">
            <h3 class="ps-section__title" data-mask="Product"><a href="/san-pham">- Sản phẩm mới</a></h3>
        </div>
        <div class="ps-products" data-mh="product-listing">
            <div class="row g-3">
                @foreach ( $products as $product )
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 itemPro">
                    <div class="ps-shoe">
                        <div class="ps-shoe__thumbnail">
                            <div class="product-label-group">
                                <div class="product-label"><span>New</span></div>
                                @if ($product->discount > 0)
                                    <div class="product-label ps-badge ps-badge--sale ps-badge--2nd">
                                        <span>-{{money($product->discount)}}%</span>
                                    </div>
                                @endif
                            </div>
                            <img class="lazy"
                                src="{{$product->image}}"
                                data-src="{{$product->image}}"
                                alt="{{$product->name}}">
                            <a class="ps-shoe__overlay" href="/san-pham/chi-tiet/{{$product->slug}}"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__detail">
                                <a class="ps-shoe__name" href="/san-pham/chi-tiet/{{$product->slug}}">{{$product->name}}</a>
                                <div class="br-wrapper br-theme-fontawesome-stars"><select
                                        class="ps-rating ps-shoe__rating" style="display: none;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5" selected="">5</option>
                                    </select>
                                </div>
                                <span class="ps-shoe__price">
                                    @if ($product->discount > 0)
                                        {{money($product->sale_price)}} đ <del class="old-price">{{money($product->price)}} đ</del>
                                    @else
                                        {{money($product->price)}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@include('parts.fontend.best_selling_products')
@include('parts.fontend.promotion_products')
@endsection