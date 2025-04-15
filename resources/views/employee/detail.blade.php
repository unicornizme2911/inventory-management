@extends('layouts.dashboard')
@section('content')
    <main class="app-main">
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Employee</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Employee
                            </li>
                        </ol>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div>
        <div class="app-content"> <!--begin::Container-->
            <div class="container-fluid my-3">
                <div class="row">
                    <div class="col-12">
                        <h2>Thông tin người dùng</h2>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>ID:</strong> {{ $employee->id }}</p>
                                <p><strong>Name:</strong> {{ $employee->name }}</p>
                                <p><strong>Role:</strong> {{ $employee->getUser_Type() }}</p>
                                <p><strong>Email:</strong> {{ $employee->email }}</p>
                                <p><strong>Phone:</strong> {{ $employee->phone }}</p>
                                <p><strong>Address:</strong> {{ $employee->address }}</p>
                                <p><strong>Total Income:</strong> {{ $totalIncome }} VNĐ</p>
                                <p><strong>Created Date:</strong> {{ $employee->created_at->format('d/m/Y') }}</p>
                                <p><strong>Updated Date:</strong> {{ $employee->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <h3 class="mt-4">Danh sách đơn hàng</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employee->orders as $order)
                                <tr class="order-row" data-id="{{ $order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @else
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-order" data-id="{{ $order->id }}">
                                            Xem chi tiết
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".order-row").forEach(row => {
                row.addEventListener("click", function() {
                    let orderId = this.dataset.id;
                    window.location.href = `/orders/${orderId}`;
                });
            });

            document.querySelectorAll(".view-order").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.stopPropagation(); // Ngăn không cho hàng bị click
                    let orderId = this.dataset.id;
                    window.location.href = `/orders/${orderId}`;
                });
            });
        });
    </script>
@endsection
