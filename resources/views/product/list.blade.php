@extends('layouts.dashboard')
@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <a href="/admin/product/add" class="btn btn-danger mb-2">
                                        <i class="mdi mdi-plus-circle mr-2"></i> Add Products</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table table-centered w-100 dt-responsive nowrap"
                                    id="products-datatable"
                                >
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="all">Product</th>
                                        <th>Category</th>
                                        <th>Warehouse</th>
                                        <th>Quantity</th>
                                        <th>Import Price</th>
                                        <th>Retail Price</th>
                                        <th>Added Date</th>
                                        <th style="width: 85px">Action</th>
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
            <!-- end row -->
        </div>
    </div>
</main>
<div
    id="confirmDeleteModal"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="danger-header-modalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="danger-header-modalLabel">Confirm delete product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-confirm">Confirm</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Flash Message -->
<div class="flashMassage alert alert-success" style="display: none;"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- dayjs -->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
<!-- product js -->
@push('scripts')
    @vite('resources/js/products/list-product.js')
@endpush
@endsection

