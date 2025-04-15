@extends('layouts.dashboard')
@section('content')
    <style>
        .employee-row:hover {
            font-weight: bold;
            background-color: #9e9d9d; /* Màu nền nhẹ khi hover */
        }
    </style>
    <main class="app-main">
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        class="mb-0 table table-centered dt-responsive nowrap w-100"
                                        id="accounts-datatable"
                                    >
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Create Date</th>
                                            @if(Auth::user()->isAdmin())
                                                <th class="text-center">Actions</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- dayjs -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <!-- product js -->
    @push('scripts')
        @vite('resources/js/employees/list-employee.js')
    @endpush
@endsection
