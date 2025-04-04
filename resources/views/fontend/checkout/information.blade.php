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
                                                <a href="{{$item['image']}}" target="_blank">
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
                                                <a href="https://kingshoes.vn/nike-journey-run-racer-hq4218-100-gia-tot-den-king-shoes.html"
                                                    target="_blank">
                                                    <span
                                                        class="product-description-name order-summary-emphasis">{{$item['name']}}</span></a>
                                                <div class="attribute_pro"><span class="badge bg-primary me-2">Size Giày:
                                                        <b>{{$item['size_number']}}</b></span></div>
                                            </td>
                                            <td class="product-quantity visually-hidden">{{$item['quantity']}}</td>
                                            <td class="product-price">
                                                <span class="order-summary-emphasis">{{money($item['price'])}} đ</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="order-summary-section order-summary-section-discount">
                            <form id="form_discount_add" action="" accept-charset="UTF-8" method="post"
                                novalidate="novalidate">
                                @csrf
                                <div class="fieldset">
                                    <div class="field">
                                        <div class="field-input-btn-wrapper input-group">
                                            <div class="field-input-wrapper">
                                                <label class="field-label" for="discount_code">Mã giảm giá</label>
                                                <input placeholder="Mã giảm giá" class="field-input text-center"
                                                    size="30" type="text" id="discount_code" name="discount_code"
                                                    value="{{ !$cartPro['code'] ? '' : $cartPro['code'] }}"
                                                    autocomplete="off" required="" {{ !$cartPro['code'] ? '' : 'disabled' }}
                                                    style="{{ !$cartPro['code'] ? '' : 'background-color: green; color: white;' }}">
                                            </div>
                                            <button type="button" id="button-reset"
                                                class="field-input-btn btn btn-default {{ !$cartPro['code'] ? 'd-none' : '' }}">
                                                <span class="btn-content">Hủy</span>
                                            </button>
                                            <button type="submit"
                                                class="field-input-btn btn btn-default {{ !$cartPro['code'] ? '' : 'd-none' }}"
                                                id="btn-usage">
                                                <span class="btn-content">Sử dụng</span>
                                            </button>
                                            <style>
                                                #button-reset {
                                                    background-color: red;
                                                    /* Màu xanh nhạt cho nền */
                                                    color: white;
                                                    /* Màu đen cho chữ */
                                                }
                                            </style>
                                        </div>
                                        <span class="text-danger error" style="color: red"></span>

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
                                            <span
                                                class="order-summary-emphasis price_total">{{money($cartPro['sumPrice'])}}
                                                đ</span>
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
                                                {{($cartPro['coupon_value'] > 0) ? money($cartPro['coupon_value']) . ' đ' : 'Chưa bao gồm'}}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="total-line total-line-promotion">

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
                        'active' => false,
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
                    <div class="step-sections" step="1">
                        <input type="hidden">
                        <div class="section">
                            <div class="section-header mb-3">
                                <h2 class="section-title">Thông tin giao hàng</h2>
                            </div>

                            <div class="section-content section-customer-information no-mb">
                                <div class="fieldset">

                                    <div class="field field-required field-two-thirds">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_address_full_name">Họ và tên</label>
                                            <input type="text" class="field-input" name="billing_address_full_name" value="{{$client['full_name'] ?? ''}}"
                                                placeholder="Họ và tên">
                                            <label id="billing_address_full_name-error" class="error d-none" for="billing_address_full_name"></label>
                                        </div>
                                    </div>

                                    <div class="field field-required field-third">
                                        <div class="field-input-wrapper">
                                            <label class="field-label">Số điện thoại</label>
                                            <input type="tel" pattern="\d*" placeholder="Số điện thoại" class="field-input" 
                                                id="billing_address_phone" name="billing_address_phone" value="{{$client['phone'] ?? ''}}" maxlength="12" minlength="10" rangelength="[10,12]" 
                                                data-rule-number="true" data-rule-checkphonevn="true" 
                                                onkeypress="inputNumberInt(this);" onkeyup="inputNumberInt(this);" onblur="inputNumberInt(this);" required>
                                            <label id="billing_address_phone-error" class="error d-none" for="billing_address_phone"></label>
                                        </div>
                                    </div>
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_address_address">Địa chỉ</label>
                                            <input type="text" class="field-input" name="billing_address_address" value="{{$client['address'] ?? ''}}"
                                                placeholder="Địa chỉ">
                                            <label id="billing_address_address-error" class="error d-none" for="billing_address_address"></label>
                                        </div>
                                    </div>
                                    @include('fontend.checkout.parts.address_detail')
                                    <div class="field">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_email">Email</label>
                                            <input type="email" placeholder="example@gmail.com" name="billing_email" value="{{$client['email'] ?? ''}}"
                                                class="field-input" required>
                                            <label id="billing_email-error" class="error d-none" for="billing_email"></label>
                                        </div>
                                        
                                    </div>
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="billing_note">Nội dung</label>
                                            <textarea class="field-input" name="billing_note" value=""placeholder="Nội dung">{{$client['note'] ?? ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-footer">
                        <button type="submit" class="step-footer-continue-btn btn" id="finished">
                            <span class="btn-content">Tiếp tục đến phương thức thanh toán</span>
                            <i class="btn-spinner icon icon-button-spinner"></i>
                        </button>
                        <a class="step-footer-previous-link" href="/gio-hang"><svg
                                class="previous-link-icon icon-chevron icon" xmlns="http://www.w3.org/2000/svg"
                                width="6.7" height="11.3" viewBox="0 0 6.7 11.3">
                                <path d="M6.7 1.1l-1-1.1-4.6 4.6-1.1 1.1 1.1 1 4.6 4.6 1-1-4.6-4.6z"></path>
                            </svg>Giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
(function() {
    // Thêm state mới vào history
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
        window.location.href = '/gio-hang';
    };
    // Kiểm tra khi load trang
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.href = '/gio-hang';
        }
    });
})();
</script>
@endsection