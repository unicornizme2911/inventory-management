@extends('layouts.dashboard')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between my-2">
                    <h4 class="page-title">Add Product</h4>

                    <div>
                        <button
                                type="button"
                                class="btn btn-outline-primary waves-effect waves-light mx-3"
                                id="button-add-category"
                                data-toggle="modal"
                                data-target="#addCategoryModal"
                        >
                            <i class="mdi mdi-plus mr-1"></i>New Category
                        </button>
                        <button
                                type="button"
                                class="btn btn-success waves-effect waves-light"
                                id="button-add-product"
                        >
                            <i class="mdi mdi-plus mr-1"></i> Add New Product
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5 image-container">
                                    <!-- Product image -->
                                    <a
                                            href="javascript: void(0);"
                                            class="text-center d-block mb-2"
                                            style="border: 2px dashed #ddd"
                                    >
                                        <img
                                                src="/images/no-image-available.png"
                                                class="img-fluid image-preview py-1"
                                                style="max-width: 280px"
                                                alt="Product-img"
                                        />
                                    </a>
                                    <!-- upload image btn -->
                                    <div class="image-upload">
                                        <button type="button" class="btn btn-primary btn-sm upload-btn">
                                            <label for="input-file" class="m-0">
                                                <i class="mdi mdi-cloud-upload"></i> Upload Image
                                            </label>
                                        </button>
                                        <div class="mt-2">
                                            <input id="input-file" type="file"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-7">
                                    <form class="pl-lg-4">
                                        <div class="form-group">
                                            <label for="productname">Product Name</label>
                                            <input
                                                    id="productname"
                                                    name="productname"
                                                    type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="Enter product name"
                                            />
                                        </div>

                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="custom-select" id="category"></select>
                                        </div>

                                        <!-- Product description -->
                                        <div class="mt-2 d-flex product-figure" style="gap: 1.6rem">
                                            <div class="item-figure">
                                                <h6 class="font-14">Import Price:</h6>
                                                <label class="sr-only" for="importPrice"
                                                >Import price</label
                                                >
                                                <div class="input-group mb-2">
                                                    <input
                                                            type="number"
                                                            class="form-control"
                                                            id="importPrice"
                                                            min="1"
                                                            value="1"
                                                    />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">&nbsp;₫</div>
                                                    </div>
                                                </div>
                                                <span class="font-weight-bold text-primary">1 đ</span>
                                            </div>
                                            <div class="item-figure">
                                                <h6 class="font-14">Retail Price:</h6>
                                                <label class="sr-only" for="retailPrice"
                                                >Retail Price</label
                                                >
                                                <div class="input-group mb-2">
                                                    <input
                                                            type="number"
                                                            class="form-control"
                                                            id="retailPrice"
                                                            min="1"
                                                            value="1"
                                                    />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">&nbsp;₫</div>
                                                    </div>
                                                </div>
                                                <span class="font-weight-bold text-primary">1 đ</span>
                                            </div>
                                            <div class="">
                                                <h6 class="font-14">Quantity:</h6>
                                                <label class="sr-only" for="quantity">Quantity</label>
                                                <div class="input-group mb-2">
                                                    <input
                                                            type="number"
                                                            class="form-control"
                                                            id="quantity"
                                                            min="1"
                                                            value="1"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Product description -->
                                        <div class="mt-2">
                                            <h6 class="font-14">Description:</h6>
                                            <textarea
                                                    class="form-control"
                                                    rows="4"
                                                    id="description"
                                            ></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection