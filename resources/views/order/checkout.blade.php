@extends('layouts.dashboard')
@section('content')
    @push('head')
        @vite('resources/css/checkout.css')
    @endpush
    <main class="app-main">
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Checkout</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Checkout
                            </li>
                        </ol>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div>
        <div class="app-content"> <!--begin::Container-->
            <div class="container-fluid my-3">
                <div class="row m-0 p-0" id="checkout-container">
                    <div class="col-lg-8 col-12" id="invoice-products">
                        <div class="product-list-header">
                            <div class="search-product-container" style="position: relative;">
                                <form id="search" class="d-flex align-items-center my-1">
                                    <div class="input-group me-3">
                                        <span class="input-group-text" id="keyword">
                                            <i class='bx bx-barcode' style="font-size: 1.6rem;"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Enter barcode" aria-label="keyword"
                                               aria-describedby="keyword" name="keyword" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center px-4"
                                            id="search-btn">
                                        <i class='bx bx-barcode' style="font-size: 1.6rem;"></i>
                                    </button>
                                </form>
                                <div class="product-search-result d-none"
                                     style="position: absolute;
                                            top: calc(100% + 2px); left: 0;
                                            width: 100%;
                                            max-height: 300px;
                                            background: #ffffff;
                                            z-index: 9999999;
                                            overflow-y: auto;"
                                ></div>
                            </div>

                            <h3 class="mt-3">Product List</h3>
                            <div class="invoice-item">
                                <div class="">ID</div>
                                <div class="d-flex align-items-center">Product Name</div>
                                <div class="">Quantity</div>
                                <div class="">Unit Price</div>
                                <div class="">Total</div>
                                <div class="">Action</div>
                            </div>
                        </div>

                        <!-- product list -->
                        <div id="product-list"></div>
                        <!-- end product list -->

                    </div>
                    <div class="col-lg-4" id="invoice-checkout" style="background-color: #f1f3fa">
                        <div class="">
                            <div class="invoice-customer">
                                <div class="customer-search" style="position: relative">
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        placeholder="enter phone number"
                                    />
                                    <span id="add-customer">
							            <i class="uil-user-plus"></i>
							        </span>

                                    <!-- search result -->
                                    <div class="customer-search-result p-2 d-none"
                                         style="position: absolute; top: 100%; left: 0; width: 100%; background: #0acf97; z-index: 9999999;">
                                    </div>
                                    <!-- end search result -->
                                </div>

                                <div class="customer-info" data-id="">
                                    <h6>Customer Information</h6>
                                    <form>
                                        <div class="mb-1 row">
                                            <label for="name" class="col-sm-3 col-form-label col-form-label-sm">Full
                                                name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="name">
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="phone" class="col-sm-3 col-form-label col-form-label-sm">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="phone">
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="address"
                                                   class="col-sm-3 col-form-label col-form-label-sm">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="address">
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <label for="loyal_points"
                                                   class="col-sm-3 col-form-label col-form-label-sm">Loyal Points</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control form-control-sm" id="loyal_points" placeholder="0">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="invoice-money">
                                <h6>Payment</h6>
                                <div class="total d-flex justify-content-between align-items-center">
                                    <h6>Total</h6>
                                    <div class="d-flex align-items-center">
                                        <p id="total-value" class="m-0 p-0"></p>
                                        <span class="">đ</span>
                                    </div>
                                </div>
                                <div class="given-money d-flex justify-content-between align-items-center">
                                    <h6>Given money</h6>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="" id="given-money-value"
                                               pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency"
                                               data-money=""
                                               placeholder="100,000" style="text-align: right">
                                        <span class="">đ</span>
                                    </div>
                                </div>
                                <div class="change d-flex justify-content-between align-items-center">
                                    <h6>Change</h6>
                                    <div class="d-flex align-items-center">
                                        <p id="change-value" class="m-0 p-0"> đ</p>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary d-flex align-items-center justify-content-center w-100 px-2"
                                    id="checkout-btn">
                                <span class="pe-5">Checkout</span>
                                <span>
                            <span class="checkout-money-value"></span>
                            <span>
                                <i class='bx bxs-chevrons-right'></i>
                            </span>
                        </span>
                            </button>
                        </div>

                    </div>
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
    @push('scripts')
        @vite('resources/js/orders/checkout.js')
    @endpush
@endsection
