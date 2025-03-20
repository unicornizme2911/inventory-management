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
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Product List</h4>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-end">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        Add Product
                                    </a>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="categoryTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Added Date</th>
                                        <th>Imported Price</th>
                                        <th>Retail Price</th>
                                        <th>Quantity</th>
                                        <th class="text-center" style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
</main>
<!-- Flash Message -->
<div class="flashMassage alert alert-success" style="display: none;"></div>


<!-- jquery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<!-- dayjs -->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
<!-- category js -->
<script type="text/javascript">
    $(document).ready(function() {
        fetchCategories();
    });
    function fetchCategories() {
        $.ajax({
            url: '/admin/product/all',
            type: 'GET',
            success: function(response) {
                let tableBody = '';
                response.forEach((product, index) => {
                    tableBody += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>
                                <img src="${product.image}" alt="${product.name}" class="rounded" height="50">
                            </td>
                            <td>${product.name}</td>
                            <td>${product.type}</td>
                            <td>${dayjs(product.added_date).format('DD MMM, YYYY')}</td>
                            <td>${product.imported_price}</td>
                            <td>${product.retail_price}</td>
                            <td>${product.quantity}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary edit-product" data-id="${product.id}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-product" data-id="${product.id}">
                                    <i class="bi bi-trash2"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('table tbody').html(tableBody);
                $('.edit-product').click(handleEditProduct);
                $('.delete-product').click(handleDeleteProduct);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    // Edit product
    function handleEditProduct() {
        let productId = $(this).data('id');
        $.ajax({
            url: `/admin/product/${productId}`,
            type: 'GET',
            success: function(response) {
                $('#name').val(response.name);
                $('#addProductModal').modal('show');
                $('#ProductForm').off('submit').on('submit', function(e){
                    e.preventDefault();
                    let formData = $(this).serialize();
                    $.ajax({
                        url: `/admin/product/edit/${productId}`,
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            $('#addProductModal').modal('hide');
                            $('#ProductForm')[0].reset();
                            $('.flashMassage')
                                .text(response.message)
                                .fadeIn()
                                .delay(3000)
                                .fadeOut();
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    // Delete product
    function handleDeleteCategory() {
        let categoryId = $(this).data('id');
        $.ajax({
            url: `/admin/category/delete/${categoryId}`,
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('.flashMassage')
                    .text(response.message)
                    .fadeIn()
                    .delay(3000)
                    .fadeOut();
                setTimeout(() => {
                    location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endsection

