@extends('layouts.backend')
@section('content')
    @if(session('msg'))
    <div class="alert alert-success text-center">
        {{ session('msg') }}
    </div>
    @endif
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{route('admin.users.index')}}" class="btn-cus-success">Quay lại</a>
        </div>

    </div>
    <form action="" method="post">
        @csrf
        <table class="table table-bordered" id="users_table">
            <thead class="text-center">
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Mật khẩu</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td><input type="text" name="name" placeholder="Họ và tên ..." value="{{$user->name}}" required></td>
                    <td><input type="email" name="email" placeholder="Email ..." value="{{$user->email}}" required></td>
                    <td><input type="text" name="phone" minlength="10" maxlength="10" placeholder="Số điện thoại ..." value="{{$user->phone}}" required></td>
                    <td><input type="password" name="password" minlength="6" placeholder="Nhập nếu muốn đổi ..."></td>
                </tr>
            </tbody>
        </table>
        <div class="row py-4">
            <div class="col-4">
                <button type="submit" class="btn-cus-primary">Lưu lại</button>
            </div>
        </div>
    </form>
    <style>
        .ms-auto {
            margin-left: auto !important;
        }
    </style>     
@endsection