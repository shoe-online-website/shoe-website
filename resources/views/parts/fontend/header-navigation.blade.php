<div class="header--sidebar">
  <ul class="main-menu menu">
    @include('parts.fontend.header-navigation-item', [
    'name' => 'introduce',
    'title' => 'Trang chủ',
    'url' => '/',
    ])
    @include('parts.fontend.header-navigation-item', [
    'name' => 'nike',
    'title' => 'Nike',
    'url' => '/san-pham/nike',
    ])
    @include('parts.fontend.header-navigation-item', [
    'name' => 'adidas',
    'title' => 'ADIDAS',
    'url' => '/san-pham/adidas',
    ])
    @include('parts.fontend.header-navigation-item', [
    'name' => 'jordan',
    'title' => 'Jordan',
    'url' => '/san-pham/jordan',
    ])
    @include('parts.fontend.header-navigation-item', [
    'name' => 'yeezy',
    'title' => 'Yeezy',
    'url' => '/san-pham/yeezy',
    ])
  </ul>
</div>
<header class="header navigation--sticky" itemscope="" itemtype="http://schema.org/WPHeader" style="margin-top: 0px;">
  <div class="header__top">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-end">
          <p class="hotline-top d-inline">
            <i class="fa-solid fa-phone-volume fa-fw"></i>
            <span class="d-none d-lg-inline-block">Hotline:</span>
            <a href="tel:0123456789">0123456789</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <nav class="navigation">
    <div class="container-fluid">
      <div class="navigation__column left">
      </div>

      <div class="navigation__column center d-none d-xl-block">
        <ul class="main-menu menu">
          @include('parts.fontend.header-navigation-item', [
          'name' => 'introduce',
          'title' => 'Trang chủ',
          'url' => '/',
          ])
          @include('parts.fontend.header-navigation-item', [
          'name' => 'nike',
          'title' => 'Nike',
          'url' => '/san-pham/nike',
          ])
          @include('parts.fontend.header-navigation-item', [
          'name' => 'adidas',
          'title' => 'ADIDAS',
          'url' => '/san-pham/adidas',
          ])
          @include('parts.fontend.header-navigation-item', [
          'name' => 'jordan',
          'title' => 'Jordan',
          'url' => '/san-pham/jordan',
          ])
          @include('parts.fontend.header-navigation-item', [
          'name' => 'yeezy',
          'title' => 'Yeezy',
          'url' => '/san-pham/yeezy',
          ])
        </ul>
      </div>

      <div class="navigation__column right">
        <form class="ps-search--header searchform" id="searchform" method="GET" action="/tim-kiem">
          <input class="form-control inputString" autocomplete="off" name="keyword" id="inputString"
            placeholder="Nhập từ cần tìm">
          <button type="submit"><i class="ps-icon-search"></i></button>
          <button id="btnsearch" type="button"><i class="ps-icon-search"></i></button>
          <div class="suggestions" id="suggestions" style="display: none;">

          </div>
        </form>
        <div class="ps-cart" id="reloaddiv">
          <a class="ps-cart__toggle" rel="noindex nofollow" href="/gio-hang">
            <span><i class="numberSumProduct">{{session('cartPro.totalQuantity') ?? 0}}</i></span><i
              class="ps-icon-shopping-cart"></i>
          </a>

          <div class="ps-cart__listing">
            <div class="ps-cart__content {{(count((array) session('cart')) > 0) ? '' : 'd-none'}}">
              @if (count((array) session('cart')) > 0)
              @foreach ((array) session('cart') as $product)
              <div class="ps-cart-item tr{{$product['cartId']}}">
                <a href="#" class="ps-cart-item__close"
                  onclick="return deleteCart({{$product['cartId']}}, '{{$product['name']}}')"></a>
                <div class="ps-cart-item__thumbnail">
                  <a href="/san-pham/chi-tiet/{{$product['slug']}}"></a>
                  <img src="{{$product['image']}}" alt="{{$product['name']}}">
                </div>
                <div class="ps-cart-item__content">
                  <a class="ps-cart-item__title" href="/san-pham/chi-tiet/{{$product['slug']}}">{{$product['name']}}</a>
                  <div class="attribute_pro"><span class="badge bg-primary me-2">Size Giày:
                      <b>{{$product['size_number']}}</b></span></div>
                  <p>
                    <span>Số lượng:<i class="qtypro{{$product['cartId']}}">{{$product['quantity']}}</i></span>
                    <span>Thành tiền:<i class="sumprice{{$product['cartId']}}">{{money($product['price'])}} đ</i></span>
                  </p>
                </div>
              </div>
              @endforeach
              <div class="ps-cart__total">
                <p>Số sản phẩm:<span class="numberSumProduct">{{session('cartPro.totalQuantity') ?? 0}}</span></p>
                @php
                $sumPrice = session('cartPro.sumPrice') ?? 0;
                @endphp
                <p>Tổng:<span class="sumPrice">{{money($sumPrice)}} đ</span></p>
              </div>
              <div class="ps-cart__footer">
                <a class="ps-btn" href="/gio-hang">Giỏ hàng<i class="ps-icon-arrow-left"></i></a>
              </div>
              @endif
            </div>
          </div>

          <div class="menu-toggle"><span></span></div>
        </div>
      </div>
  </nav>
</header>