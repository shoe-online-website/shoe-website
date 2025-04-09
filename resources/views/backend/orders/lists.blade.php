@extends('layouts.backend')
@section('content')
@if(session('msg'))
<div class="alert alert-success text-center">
    {{ session('msg') }}
</div>
@endif
<div class="row mb-4">
    <div class="col">
        <input type="search" class="form-control" name="search" id="keyword" placeholder="Nhập từ cần tìm ..."
            onblur="search(this.value)">
    </div>
</div>
<hr>
<table class="table table-bordered" id="orders_table">
    <thead class="text-center">
        <tr>
            <th>STT</th>
            <th>
                Ngày thanh toán
            </th>
            <th>
                Trạng thái
            </th>
            <th>Giảm giá</th>
            <th>Tổng tiền</th>
            <th>Thông tin người nhận</th>
            <th>Địa chỉ</th>
            <th>Chi tiết</th>

        </tr>
    </thead>
    <tbody>
        @if (!empty($orders))
        @php $index = 1 @endphp
        @foreach ($orders as $order)
        <tr>
            <td class="text-center">{{ $index++ }}</td>
            <td class="text-center">{{ $order->payment_complete_date->format('d/m/Y') }}</td>
            <td class="text-center">
                <span class="badge bg-{{ $order->ordersStatus->color }}" style="color: white">{{ $order->ordersStatus->name }}</span><br>
                <i class="fa fa-edit mt-2" onclick="editStatus({{$order->id}})"></i>
            </td>
            <td class="text-center">{{ ($order->discount > 0 ) ? "-".money($order->discount)."đ" : "Không" }}</td>
            <td class="text-center">{{ money($order->total) }}đ</td>
            <td>{{ $order->name }}</br>{{ $order->phone }}</br>{{ $order->email }}</td>
            <td>{{ $order->address }}</br>{{ $order->ward }}, {{ $order->district }}, {{ $order->province }}</td>
            <td>
                <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8" class="text-center">Không có dữ liệu</td>
        </tr>
        @endif

    </tbody>
</table>
<script>
    const editStatus = async (orderId) => {
        Swal.fire({
            title: "Cập nhật trạng thái đơn hàng",
            input: 'radio',
            inputOptions: {
                '3': 'Hủy đơn hàng',
                '2': 'Đã được giao'
            },
            inputValidator: (value) => {
                if (!value) {
                    return 'Vui lòng chọn trạng thái!'
                }
            },
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy',
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                return value;
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await fetch(`/admin/orders/orderDetail/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        orderId: orderId,
                        orderStatusId: result.value
                    })
                });
                const {
                    success,
                    message,
                    data
                } = await response.json();
                // console.log(data);
                if (success) {
                    Swal.fire({
                        title: "Thành công",
                        text: message,
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            }

        });
    };

    const formatMoney = (amount) => {
        let monney = new Intl.NumberFormat('vi-VN').format(amount);
        monney = monney.replace(/\./g, ',');
        return monney;
    }
    const search = async (keyword) => {
        try {
            const response = await fetch(`/admin/orders/search`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ keyword: keyword })
            });
            
            const { success, data } = await response.json();
            if (success) {
                const tbody = document.querySelector('#orders_table tbody');
                tbody.innerHTML = '';
                if (data && data.length > 0) {
                    let index = 1;
                    data.forEach(order => {
                        const row = `
                            <tr>
                                <td class="text-center">${index++}</td>
                                <td class="text-center">${new Date(order.payment_complete_date).toLocaleDateString('vi-VN')}</td>
                                <td class="text-center">
                                    <span class="badge bg-${order.orders_status.color}" style="color: white">${order.orders_status.name}</span><br>
                                    <i class="fa fa-edit mt-2" onclick="editStatus(${order.id})"></i>
                                </td>
                                <td class="text-center">${order.discount > 0 ? '-' + formatMoney(order.discount) + 'đ' : 'Không'}</td>
                                <td class="text-center">${formatMoney(order.total)}đ</td>
                                <td>${order.name}<br>${order.phone}<br>${order.email}</td>
                                <td>${order.address}<br>${order.ward}, ${order.district}, ${order.province}</td>
                                <td>
                                    <a href="/admin/orders/orderDetail/${order.id}" class="btn btn-primary btn-sm">Chi tiết</a>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không tìm thấy kết quả</td></tr>';
                }
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }
</script>
@endsection