@extends('layouts.fontend')
@section('content')
  <section class="ps-content pt-30 pb-30">
      <div class="container" id="tabledivbox_contact">
        <div class="ps-cart-listing">
          @if(count((array) session('cart')) > 0)
            <div class="cartPage">
              <div class="ps-post__header">
                <h1 class="ps-post__title">Giỏ hàng</h1>
              </div>
              @foreach ((array) session('cart') as $product)
                <div class="itemCart tr{{$product['cartId']}}">
                  <div class="inforCart">
                    <div class="image">
                      <a href="/san-pham/chi-tiet/{{$product['slug']}}">
                        <img src="{{$product['image']}}" alt="{{$product['name']}}">
                      </a>
                    </div>
                    <div class="numberPrice">
                      <div class="title">
                        <a href="https://kingshoes.vn/jordan-1-low-unc-ao9944-441.html">
                          <h3>{{$product['name']}}</h3>
                        </a>
                      </div>
                      <div class="attribute_pro">
                        <span class="badge bg-primary me-2">Size Giày: <b>{{$product['size_number']}}</b></span>
                      </div>
                      <p class="ps-product__category">Mã SP: <strong>{{$product['code']}}</strong></p>
                      <div class="number">
                        <div class="form-group--number">
                          <button class="minus" onclick="return updateQuantity({{$product['cartId']}}, {{$product['priceDefalt']}} ,-1)" type="button">
                            <span>-</span>
                          </button>
                          <input type="text" name="tqty[{{$product['cartId']}}]" class="form-control" id="qty{{$product['cartId']}}" value="{{$product['quantity']}}">
                          <button class="plus" onclick="return updateQuantity({{$product['cartId']}}, {{$product['priceDefalt']}}, 1)" type="button">
                            <span>+</span>
                          </button>
                        </div>
                        <i class="fa fa-times"></i> 
                        <span class="textPrice">{{money($product['priceDefalt'])}} đ</span>
                      </div>
                      <div class="total_price">
                        Thành tiền: <span class="textPrice sumprice{{$product['cartId']}}">{{money($product['price'])}} đ</span>
                      </div>
                      <div class="btnCart">
                        <button class="btnClick btnDel" onclick="return deleteCart({{$product['cartId']}}, '{{$product['name']}}')">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              @endforeach
              <div class="itemCart sumItemCart row justify-content-end">
                <div class="col-auto co-12">
                  <div class="inforSum">
                    <b>Tổng tiền:</b> 
                    @php 
                      $sumPrice = session('cartPro.sumPrice') ?? 0;
                    @endphp
                    <span class="textPrice sumPrice">{{money($sumPrice)}} đ</span>
                  </div>
                </div>
                <div class="col-auto col-12 d-flex justify-content-end">
                  <div class="buyNext mr-4">
                    <a class="ps-btn" href="/">Mua tiếp<i class="ps-icon-next"></i></a>
                  </div>
                  <div class="buyNext">
                    <a class="ps-btn" href="/thong-tin-don-hang">Đặt hàng <i class="ps-icon-next"></i></a>
                  </div>
                </div>
              </div>
            </div>
          @else
                <div class="cartNull">
                    <div class="null_cart text-center">
                        <h1 class="coll-title cart-title text-uppercase">Giỏ hàng</h1>
                        <p class="text-null">Không có sản phẩm nào trong giỏ hàng</p>
                        <a href="." class="back-home">Về trang chủ</a>
                        <div class="callship text-center">
                            Khi cần trợ giúp vui lòng gọi 
                            <a class="callNow" href="tel:">0123456789</a>
                        </div>
                    </div>
                </div>
          @endif
        </div>
      </div>
  </section>
@endsection