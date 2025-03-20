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
                                            <label for="productName">Product Name</label>
                                            <input
                                                    id="productName"
                                                    name="productName"
                                                    type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="Enter product name"
                                            />
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="category">Category: </label>
                                            <select class="form-select" id="category">
                                                <option value="">Select Category Name</option>
                                                @foreach($category as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="warehouse">Warehouse: </label>
                                            <select class="form-select" id="warehouse">
                                                <option value="">Select Warehouse Name</option>
                                                @foreach($warehouse as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Product description -->
                                        <div class="mt-2 d-flex justify-content-between product-figure" style="gap: 1.6rem">
                                            <div class="item-figure">
                                                <label class="sr-only font-14" for="importPrice">Import Price:</label>
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
                                            </div>
                                            <div class="item-figure">
                                                <label class="sr-only font-14" for="retailPrice">Retail Price:</label
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
                                            </div>
                                            <div class="">
                                                <label class="sr-only font-14" for="quantity">Quantity:</label>
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
{{-- Create Modal Category --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="CategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form> <!--end::Form-->
            </div>
        </div>
    </div>
</div>
{{-- Confirm Modal --}}
<div id="confirmAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-success">
                <h4 class="modal-title" id="standard-modalLabel">Confirm Add Product</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to add this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary button-confirm">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Category --}}
<div class="flashMassage alert alert-success" style="display: none;"></div>
@endsection

@push('scripts')
    @vite('resources/js/add-product.js')
@endpush
