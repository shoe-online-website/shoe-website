<div class="field field-show-floating-label field-required field-third">
    <div class="field-input-wrapper field-input-wrapper-select">
        <label class="field-label" for="billing_shipping_province">Tỉnh/Thành</label>
        <select class="field-input" id="billing_shipping_province" name="billing_shipping_province" required
            onchange="searchDistricts('#billing_shipping_province','#billing_shipping_district','#billing_shipping_ward')">
            <option value="">Chọn Tỉnh/Thành</option>
            @if ($provinces)
                @foreach ($provinces as $province)
                    <option value="{{$province->code}}" {{(isset($client['province']) && ($client['province'] == $province->code)) ? 'selected' : ''}} data-code="{{$province->code}}">{{$province->name}}</option>
                @endforeach
            @endif
        </select>
        <label id="billing_shipping_province-error" class="error d-none" for="billing_shipping_province"></label>
    </div>
</div>
<div class="field field-show-floating-label field-required field-third">
    <div class="field-input-wrapper field-input-wrapper-select">
        <label class="field-label" for="billing_shipping_district">Quận/Huyện</label>
        <select class="field-input" id="billing_shipping_district" name="billing_shipping_district" required
            onchange="searchWards('#billing_shipping_district','#billing_shipping_ward');">
            <option value="">Chọn Quận/Huyện</option>
            @if(count($districts) > 0)
                @foreach ($districts as $district)
                <option value="{{$district->code}}" {{$client['district'] == $district->code ? 'selected' : ''}} data-code="{{$district->code}}">{{$district->name}}</option>
                @endforeach
            @endif
        </select>
        <label id="billing_shipping_district-error" class="error d-none" for="billing_shipping_district"></label>
    </div>
</div>
<div class="field field-show-floating-label field-required field-third">
    <div class="field-input-wrapper field-input-wrapper-select">
        <label class="field-label" for="billing_shipping_ward">Phường/Xã</label>
        <select class="field-input" id="billing_shipping_ward" name="billing_shipping_ward" required>
            <option value="">Chọn Phường/Xã</option>
            @if(count($wards) > 0)
            @foreach ($wards as $ward)
                <option value="{{$ward->code}}" {{$client['ward'] == $ward->code ? 'selected' : ''}} data-code="{{$ward->code}}">{{$ward->name}}</option>
            @endforeach
        @endif
        </select>
        <label id="billing_shipping_ward-error" class="error d-none" for="billing_shipping_ward"></label>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#billing_shipping_province').select2();
        $('#billing_shipping_district').select2();
        $('#billing_shipping_ward').select2();
    });
</script>