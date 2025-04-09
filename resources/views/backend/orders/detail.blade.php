@extends('layouts.backend')
@section('content')
@if(session('msg'))
<div class="alert alert-success text-center">
    {{ session('msg') }}
</div>
@endif
<div class="row mb-3">
    <div class="col-2">
        <a href="{{route('admin.orders.index')}}" class="btn-cus-success">Quay lại</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="orders_table">
        <thead class="text-center">
            <tr hidden>
                <th>STT</th>
                <th>Thông tin sản phẩm</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>

            @if (count($orderDetails) > 0)
            @if($orderDetails[0]->order->discount > 0)
                <tr>
                    <td colspan="2" class="text-left"> Mã giảm giá:
                        <span class="badge bg-success" style="color: white">{{ $orderDetails[0]->order->coupon_code }}</span>
                    </td>
                    <td class="text-center">-{{ money($orderDetails[0]->order->discount) }}đ</td>
                </tr>
            @endif
            @php $index = 1; $total = 0; @endphp
            @foreach ($orderDetails as $order)
            <tr>
                <td class="text-center">{{ $index++ }}</td>
                <td>
                    <img src="{{ asset($order->product->image) }}" alt="" style="width: 100px; height: 100px;">
                    <p>{{ $order->product->name }}</p>
                    <p>Size: {{ $order->size_number }}</p>
                    <p>Số lượng: {{ $order->quantity }}</p>
                </td>
                <td class="text-center">{{ money($order->price) }}đ</td>
                @php $total += $order->price; @endphp
            </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-right">Tổng tiền</td>
                <td class="text-center">{{ money($orderDetails[0]->order->total) }}đ</td>
            </tr>
            @else
            <tr>
                <td colspan="8" class="text-center">Không có dữ liệu</td>
             </tr>
            @endif

        </tbody>
    </table>
</div>
@endsection