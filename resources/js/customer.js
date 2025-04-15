$(document).ready(function() {
    fetchCustomer();
});

function fetchCustomer() {
    $.ajax({
        url: '/admin/customer/all',
        type: 'GET',
        success: function(response) {
            let tableBody = '';
            response.data.forEach((customer, index) => {
                console.log(customer);
                tableBody += `
                    <tr class="customer-row" data-id="${customer.id}">
                        <td>${customer.name}</td>
                        <td>${customer.address}</td>
                        <td>${customer.phone}</td>
                        <td>${customer.loyal_points}</td>
                        <td>${dayjs(customer.created_at).format('DD/MM/YYYY')}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info toggle-products" data-id="${customer.id}">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('table tbody').html(tableBody);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
