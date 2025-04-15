$(document).ready(function() {
    fetchProducts();
});

function fetchProducts() {
    $.ajax({
        url: '/admin/product/all',
        method: 'GET',
        success: function(products) {
            console.log(products.data);
            let tableData = '';
            products.data.forEach((product, index) => {
                tableData += `
                    <tr>
                        <td>
                            <a href="/admin/product/${product.id}" class="text-body text-truncate d-inline-block">${product.name}</a>
                        </td>
                        <td>${product.category.name}</td>
                        <td>${product.warehouses[0].name}</td>
                        <td>${product.warehouses[0].quantity}</td>
                        <td>${product.import_price} VNĐ</td>
                        <td>${product.retail_price} VNĐ</td>
                        <td>${dayjs(product.created_at)}</td>
                        <td>
                            <a class="btn btn-primary" href="/admin/product/edit/${product.id}">Edit</a>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('table tbody').html(tableData);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
