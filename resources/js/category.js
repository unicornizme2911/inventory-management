$(document).ready(function() {
    fetchCategories();
});
$(document).ready(function() {
    $('#addCategoryForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '/admin/category/add',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#addCategoryModal').modal('hide');
                $('#addCategoryForm')[0].reset();
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
            response.forEach((category, index) => {
                tableBody += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${category.name}</td>
                        <td>${dayjs(category.created_at).format('DD/MM/YYYY')}</td>
                        <td>${dayjs(category.updated_at).format('DD/MM/YYYY')}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash2"></i>
                            </a>
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
            console.log(response);
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
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}