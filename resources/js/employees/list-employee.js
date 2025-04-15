$(document).ready(function() {
    fetchEmployees();
});

function fetchEmployees(){
    $.ajax({
        url: '/admin/employee/all',
        type: 'GET',
        success: function(response) {
            let tableBody = '';
            response.data.forEach((employee, index) => {
                console.log(employee);
                let role = employee.user_type == 1 ? 'Admin' : 'Employee';
                tableBody += `
                    <tr class="employee-row" data-id="${employee.id}" style="cursor: pointer;">
                        <td>${employee.id}</td>
                        <td>${employee.name}</td>
                        <td>${role}</td>
                        <td>${employee.email}</td>
                        <td>${employee.phone}</td>
                        <td>${dayjs(employee.created_at).format('DD/MM/YYYY')}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary edit-employee" data-id="${employee.id}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-employee" data-id="${employee.id}">
                                <i class="bi bi-trash2"></i>
                            </button>
                        </td>
                        @endif
                    </tr>
                `;
            });
            $('table tbody').html(tableBody);
            $(".employee-row").click(function() {
                let id = $(this).data('id');
                window.location.href = `/admin/employee/${id}`;
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
