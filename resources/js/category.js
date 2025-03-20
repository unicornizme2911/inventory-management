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
