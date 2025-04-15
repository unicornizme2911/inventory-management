$(document).ready(function() {
    fetchWarehouses();
});
$(document).ready(function() {
    $('#WarehouseForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '/admin/warehouse',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#addWarehouseModal').modal('hide');
                $('#WarehouseForm')[0].reset();
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
function fetchWarehouses() {
    $.ajax({
        url: '/admin/warehouse/all',
        type: 'GET',
        success: function(response) {
            let tableBody = '';
            response.data.forEach((warehouse, index) => {
                tableBody += `
                    <tr class="warehouse-row" data-id="${warehouse.id}">
                        <td class="text-center">${index + 1}</td>
                        <td>${warehouse.name}</td>
                        <td>${warehouse.location}</td>
                        <td>${dayjs(warehouse.created_at).format('DD/MM/YYYY')}</td>
                        <td>${dayjs(warehouse.updated_at).format('DD/MM/YYYY')}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary edit-warehouse" data-id="${warehouse.id}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-warehouse" data-id="${warehouse.id}">
                                <i class="bi bi-trash2"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info toggle-products" data-id="${warehouse.id}">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="product-list-row" data-id="${warehouse.id}" style="display: none;">
                        <td colspan="7">
                            <div class="product-list">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Import Price</th>
                                            <th>Retail Price</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${Array.isArray(warehouse.products) && warehouse.products.length > 0
                                            ? warehouse.products.map((product, i) => `
                                                <tr>
                                                    <td>${product.id}</td>
                                                    <td>${product.name}</td>
                                                    <td>${product.category}</td>
                                                    <td>${parseFloat(product.import_price).toLocaleString()} VND</td>
                                                    <td>${parseFloat(product.retail_price).toLocaleString()} VND</td>
                                                    <td>${product.quantity}</td>
                                                </tr>
                                            `).join('')
                                            : `<tr><td colspan="6" class="text-center">Không có sản phẩm</td></tr>`
                                        }
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                `;
            });
            $('table tbody').html(tableBody);

            $('.toggle-products').click(function() {
                let warehouseId = $(this).data('id');
                let row = $(`.product-list-row[data-id="${warehouseId}"]`);
                let icon = $(this).find('i');
                $('.product-list-row').not(row).hide();
                $('.toggle-products i').not(icon).removeClass('bi-chevron-up').addClass('bi-chevron-down');

                if(row.is(':visible')) {
                    row.hide()
                    icon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
                }else{
                    row.show()
                    icon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
                }
            });
            $('.edit-warehouse').click(handleEditWarehouse);
            // $('.delete-warehouse').click(handleDeleteCategory);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
// Edit Category
function handleEditWarehouse() {
    let warehouseId = $(this).data('id');
    $.ajax({
        url: `/admin/warehouse/${warehouseId}`,
        type: 'GET',
        success: function(response) {
            $('#name').val(response.data.name);
            $('#location').val(response.data.location);
            $('#addWarehouseModal').modal('show');
            $('#WarehouseForm').off('submit').on('submit', function(e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: `/admin/warehouse/${warehouseId}`,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#addWarehouseModal').modal('hide');
                        $('#WarehouseForm')[0].reset();
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

