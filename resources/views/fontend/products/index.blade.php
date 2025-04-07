@extends('layouts.fontend')

@section('content')
@include('parts.fontend.search')
@include('parts.fontend.breadcrumbs', ['breadcrumbs' => [
    $category->name => '/san-pham/'.$category->slug                                   
    ]])
<section class="ps-blog-grid pt-30 pb-30" style="transform: none;">
    <div class="container" style="transform: none;">
        <div class="row" style="transform: none;">
            <div class="col-lg-9 col-md-9 col-12">
                <div class="row g-3">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            {{-- begin-item-product --}}
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6 itemPro">
                                <div class="ps-shoe">
                                <div class="ps-shoe__thumbnail">
                                    <div class="product-label-group">
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
                                    <a class="ps-shoe__overlay" 
                                    href="{{route('client.products.detail', $product->slug)}}"></a>
                                </div>
                                <div class="ps-shoe__content">
                                    <div class="ps-shoe__detail">
                                    <a class="ps-shoe__name" 
                                        href="{{route('client.products.detail', $product->slug)}}">
                                        {{$product->name}}
                                    </a>
                                    <div class="br-wrapper br-theme-fontawesome-stars">
                                        <select class="ps-rating ps-shoe__rating" style="display: none;">
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
                            {{-- end-item-product --}}   
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                Không có sản phẩm nào. Vui lòng quay lại sau.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" data-sticky="" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                @include('parts.fontend.new_products')
            </div>
        </div>
    </div>
</section>
@endsection
