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
                            <div class="row">
                                <div class="col-lg-5">
                                    <!-- Product image -->
                                    <a href="javascript:void(0);" class="text-center d-block mb-4">
                                        <img src="{{ asset('uploads/products/' . $product->image) ?? asset('default-image.jpg') }}"
                                             class="img-fluid"
                                             style="max-width: 280px"
                                             alt="Product-img">
                                    </a>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-7">
                                    <form class="pl-lg-4">
                                        <!-- Product title -->
                                        <h3 class="mt-0">
                                            {{ $product->name ?? '' }}
                                            @if(isset($product))
                                                <a href="{{ url('/admin/edit-product/' . $product->id) }}" class="text-muted">
                                                    <i class="mdi mdi-square-edit-outline ml-2"></i>
                                                </a>
                                            @endif
                                        </h3>
                                        <p class="mb-1">
                                            Added Date: {{ isset($product) ? \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') : '' }}
                                        </p>

                                        <!-- Product stock -->
                                        <div class="mt-3">
                                            <h4>
                                                <span class="badge badge-success-lighten">In stock</span>
                                            </h4>
                                        </div>

                                        <!-- Product pricing and quantity -->
                                        <div class="mt-4 d-flex" style="gap: 1.6rem">
                                            <div>
                                                <h6 class="font-14">Import Price:</h6>
                                                <h3>
                                                    {{ isset($product) ? number_format($product->import_price, 0, ',', '.') . ' VND' : '' }}
                                                </h3>
                                            </div>
                                            <div>
                                                <h6 class="font-14">Retail Price:</h6>
                                                <h3>
                                                    {{ isset($product) ? number_format($product->retail_price, 0, ',', '.') . ' VND' : '' }}
                                                </h3>
                                            </div>
                                            <div>
                                                <h6 class="font-14">Quantity</h6>
                                                <div class="d-flex">
                                                    <input type="number" min="1"
                                                           value="{{ isset($product) ? (int) $product->warehouses[0]->pivot->quantity : '' }}"
                                                           class="form-control"
                                                           placeholder="Qty"
                                                           style="width: 90px"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Product description -->
                                        <div class="mt-4">
                                            <h6 class="font-14">Description:</h6>
                                            @if(isset($product) && !empty($product->description))
                                                @foreach(explode("\n", $product->description) as $line)
                                                    <p>{{ $line }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </form>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row-->
                        </div>
                        <!-- end card-body-->
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col-->
            </div>
        </div>
    </div>
</main>
@endsection
