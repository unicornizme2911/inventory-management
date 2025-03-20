@extends('layouts.dashboard')
@section('content')
<main class="app-main"> 
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Category</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Category
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
                            <h4 class="card-title">Category List</h4>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-end">
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        Add Category
                                    </a>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
<!-- Add Category Modal -->
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
                </form>
            </div>
        </div>
    </div>
</div>
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
    $(document).ready(function() {
        $('#CategoryForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '/admin/category',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addCategoryModal').modal('hide');
                    $('#CategoryForm')[0].reset();
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
        });
    })
    function fetchCategories() {
        $.ajax({
            url: '/admin/category/all',
            type: 'GET',
            success: function(response) {
                let tableBody = '';
                response.data.forEach((category, index) => {
                    tableBody += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${category.name}</td>
                            <td>${dayjs(category.created_at).format('DD/MM/YYYY')}</td>
                            <td>${dayjs(category.updated_at).format('DD/MM/YYYY')}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary edit-category" data-id="${category.id}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-category" data-id="${category.id}">
                                    <i class="bi bi-trash2"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('table tbody').html(tableBody);
                $('.edit-category').click(handleEditCategory);
                $('.delete-category').click(handleDeleteCategory);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    // Edit Category
    function handleEditCategory() {
        let categoryId = $(this).data('id');
        $.ajax({
            url: `/admin/category/${categoryId}`,
            type: 'GET',
            success: function(response) {
                $('#name').val(response.data.name);
                $('#addCategoryModal').modal('show');
                $('#CategoryForm').off('submit').on('submit', function(e){
                    e.preventDefault();
                    let formData = $(this).serialize();
                    $.ajax({
                        url: `/admin/category/${categoryId}`,
                        type: 'PUT',
                        data: formData,
                        success: function(response) {
                            $('#addCategoryModal').modal('hide');
                            $('#CategoryForm')[0].reset();
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
    // Delete Category
    function handleDeleteCategory() {
        let categoryId = $(this).data('id');
        $.ajax({
            url: `/admin/category/${categoryId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
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

