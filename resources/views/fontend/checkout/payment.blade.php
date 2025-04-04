@extends('layouts.checkout')
@section('content')
<div class="content">
    <div class="wrap">
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="order-summary order-summary-is-collapsed">
                    <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                    <div class="order-summary-sections">
                        <div class="order-summary-section order-summary-section-product-list">
                            <table class="product-table">
                                <thead>
                                    <tr>
                                        <th scope="col"><span class="visually-hidden">Hình ảnh</span></th>
                                        <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                        <th scope="col"><span class="visually-hidden"></span></th>
                                        <th scope="col"><span class="visually-hidden">Giá</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $item)
                                    <tr class="product" data-product-id="{{$item['cartId']}}">
                                        <td class="product-image">
                                            <a href="/chi-tiet/{{$item['slug']}}"
                                                target="_blank">
                                                <div class="product-thumbnail">
                                                    <div class="product-thumbnail-wrapper">
                                                        <img class="product-thumbnail-image" alt="saffron-salam"
                                                            src="{{$item['image']}}">
                                                    </div>
                                                    <span class="product-thumbnail-quantity unprintable"
                                                        aria-hidden="true">{{$item['quantity']}}</span>

                                                </div>
                                            </a>
                                        </td>
                                        <td class="product-description">
                                            <a href="/chi-tiet/{{$item['slug']}}"
                                                target="_blank"><span
                                                    class="product-description-name order-summary-emphasis">{{$item['name']}}</span></a>
                                            <div class="attribute_pro"><span class="badge bg-primary me-2">Size Giày:
                                                    <b>{{$item['size_number']}}</b></span></div>
                                        </td>
                                        <td class="product-quantity visually-hidden">{{$item['quantity']}}</td>
                                        <td class="product-price">
                                            <span class="order-summary-emphasis">{{money($item['price'])}}đ</span>
                                        </td>
                                    </tr> 
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <div class="order-summary-section order-summary-section-discount">
                            <form id="form_discount" action="" accept-charset="UTF-8" method="post"
                                novalidate="novalidate">
                                <div class="fieldset">
                                    <div class="field">
                                        <div class="field-input-btn-wrapper">
                                            <div class="field-input-wrapper">
                                                <label class="field-label" for="discount_code">Mã giảm giá</label>
                                                <input placeholder="Mã giảm giá" class="field-input text-center" size="30"
                                                    type="text" id="discount_code" name="discount_code" value="{{ !$cartPro['code'] ? '' : $cartPro['code'] }}"
                                                    autocomplete="off" disabled="" required=""
                                                    style="{{ !$cartPro['code'] ? '' : 'background-color: green; color: white;' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="promotions_infor"></div>
                        </div>
                        <div class="order-summary-section order-summary-section-total-lines payment-lines"
                            data-order-summary-section="payment-lines">
                            <table class="total-line-table">
                                <thead>
                                    <tr>
                                        <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                        <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-line total-line-subtotal">
                                        <td class="total-line-name">Tạm tính</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis price_total">{{money($cartPro['sumPrice'])}} đ</span>
                                        </td>
                                    </tr>
                                    <tr class="total-line total-line-shipping">
                                        <td class="total-line-name">Phí giao hàng</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis price_ship">Chưa bao gồm</span>
                                        </td>
                                    </tr>

                                    <tr class="total-line total-line-discount">
                                        <td class="total-line-name">Áp dụng mã giảm giá</td>
                                        <td class="total-line-price">
                                            <span class="order-summary-emphasis price_discount">
                                                {{($cartPro['coupon_value'] > 0) ? '-' . money($cartPro['coupon_value']) . ' đ' : 'Chưa bao gồm'}}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="total-line-table-footer">
                                    <tr class="total-line">
                                        <td class="total-line-name payment-due-label">
                                            <span class="payment-due-label-total">Tổng cộng</span>
                                        </td>
                                        <td class="total-line-name payment-due">
                                            @php $priceEnd = $cartPro['sumPrice'] - $cartPro['coupon_value']  @endphp
                                            <span class="payment-due-price price_total_end">
                                                {{money($priceEnd)}} đ
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="order-summary-section order-summary-section-infor-lines infor-lines" data-order-summary-section="infor-lines">
                            <label for=""><b>Thông tin người nhận</b> : {{$client['full_name']}}, {{$client['phone']}}, {{$client['email']}}</label>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            @include('fontend.checkout.parts.breadcrumbs', [
    'breadcrumbs' => [
        [
            'name' => 'Giỏ hàng',
            'url' => '/gio-hang',
            'active' => true,
        ],
        [
            'name' => 'Thông tin đơn hàng',
            'url' => '/thong-tin-don-hang',
            'active' => true,
        ],
        [
            'name' => 'Phương thức thanh toán',
            'url' => '/phuong-thuc-thanh-toan',
            'active' => false,
        ],

    ]
])
            <div class="main-content">
                <div class="step">
                    <div class="main-content">
                        <div class="step">
                            <div class="section" step="2">
                                <div id="section-shipping-rate" class="section section-method">
                                    <div class="section-header">
                                        <h2 class="section-title mt-5">Phương thức vận chuyển</h2>
                                    </div>
                                    <div class="section-content">
                                        <div class="content-box">

                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label" for="ship_method_3534">

                                                    <div class="radio-content-input">
                                                        <img class="main-img"
                                                            src="{{asset('storage/photos/thumbs/ship.png')}}">
                                                        <div class="content-wrapper">
                                                            <span class="radio-label-primary">Giao hàng tại nhà</span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="section-payment-method" class="section">
                                    <div class="section-header">
                                        <h2 class="section-title">Phương thức thanh toán</h2>
                                    </div>
                                    <div class="section-content">
                                        <div class="content-box">

                                            <div class="radio-wrapper content-box-row">
                                                <label class="radio-label" for="payment_method_3528">
                                                    <div class="radio-content-input">
                                                        <img class="main-img"
                                                            src="{{asset('storage/photos/thumbs/other.png')}}">
                                                        <div class="content-wrapper">
                                                            <span class="radio-label-primary">Chuyển khoản ngân
                                                                hàng</span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="radio-wrapper content-box-row content-box-row-secondary"
                                                for="payment_method_3528">
                                                <div class="blank-slate">
                                                    @php $priceEnd = $cartPro['sumPrice'] - $cartPro['coupon_value']  @endphp
                                                    <p>
                                                        <img alt="Lazaten thanh toán" height="374"
                                                            src="https://img.vietqr.io/image/acb-4319141-compact2.jpg?amount={{ $priceEnd }}&addInfo=thanh+toan+don+hang Lazaten"
                                                            srcset="Lazaten thanh toán" width="615">
                                                    </p>

                                                    <p><strong>Mua hàng trên website Lazaten:</strong></p>

                                                    <p><strong>*Giao - Nhận:</strong></p>

                                                    <p>Lazaten ship hàng toàn quốc COD - Kiểm tra hàng trực tiếp khi nhận hàng.</p>
                                                    <p><strong>Chúng tôi biết bạn có nhiều sự lựa chọn. Cảm ơn bạn đã
                                                            chọn Lazaten.</strong></p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-footer">
                        <button type="submit" class="step-footer-continue-btn btn" id="finished-checkout">
                            <span class="btn-content">Xác nhận đã chuyển khoản đơn hàng</span>
                            
                        </button>
                        <a class="step-footer-previous-link" href="/thong-tin-don-hang"><svg
                                class="previous-link-icon icon-chevron icon" xmlns="http://www.w3.org/2000/svg"
                                width="6.7" height="11.3" viewBox="0 0 6.7 11.3">
                                <path d="M6.7 1.1l-1-1.1-4.6 4.6-1.1 1.1 1.1 1 4.6 4.6 1-1-4.6-4.6z"></path>
                            </svg>Quay lại thông tin giao hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection