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
                    <td><input type="text" name="row_1_col_0" placeholder="Họ và tên ..." required></td>
                    <td><input type="email" name="row_1_col_1" placeholder="Email ..." required></td>
                    <td><input type="text" name="row_1_col_2" minlength="10" maxlength="10" placeholder="Số điện thoại ..." required></td>
                    <td><input type="password" name="row_1_col_3" minlength="6" placeholder="Mật khẩu" required></td>
                </tr>
            </tbody>
        </table>
        <div class="row py-4">
            <div class="col-4">
                <button type="submit" class="btn-cus-primary">Lưu lại</button>
            </div>
            <div class="col-2 ms-auto">
                <a href="#" class="btn-cus-warning more_row">Thêm hàng</a>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const moreRow = document.querySelector('.more_row');
            const moreRowEvent = () => {
                moreRow.addEventListener('click', (e) => {
                    const usersTable = document.querySelector('#users_table');
                    const rowCount = usersTable.rows.length; // Số lượng hàng hiện tại
                    const currentRow = usersTable.insertRow(rowCount); // Tạo một hàng mới

                    for (let col = 0; col < 4; col++) {
                        const cell = currentRow.insertCell();
                        const input = document.createElement('input');
                        switch (col) {
                            case 0:
                                input.type = 'text';
                                input.name = `row_${rowCount}_col_${col}`;
                                input.required = true;
                                input.placeholder = 'Họ và tên ...';
                                break;
                            case 1:
                                input.type = 'email';
                                input.name = `row_${rowCount}_col_${col}`;
                                input.required = true;
                                input.placeholder = 'Email ...';
                                break;
                            case 2:
                                input.type = 'text';
                                input.name = `row_${rowCount}_col_${col}`;
                                input.required = true;
                                input.placeholder = 'Số điện thoại ...';
                                input.minLength = 10;
                                input.maxLength = 10;
                                break;
                            case 3:
                                input.type = 'password';
                                input.name = `row_${rowCount}_col_${col}`;
                                input.required = true;
                                input.placeholder = 'Mật khẩu ...';
                                input.minLength = 6;
                                break;
                        }
                        cell.appendChild(input);
                        console.log(cell);
                        
                    }
                });

            };
            
            moreRowEvent();
        });
    </script>
    <style>
        .ms-auto {
            margin-left: auto !important;
        }
    </style>     
@endsection