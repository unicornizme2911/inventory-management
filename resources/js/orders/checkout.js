$(document).ready(function () {
    let transactionId = localStorage.getItem("transaction_id");
    if (!transactionId) {
        startTransaction();
    }
    handleCustomerInfo();
    fetchProducts();
    searchBarcode();
    checkout();
});
function startTransaction(){
    $.ajax({
        url: '/admin/transaction',
        type: 'POST',
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function (response) {
            localStorage.setItem("transaction_id", response.data.id);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function handleCustomerInfo(){
    const searchContainer = $('.customer-search');
    const customerInfo = $('.customer-info');
    const addCustomerBtn = $(searchContainer).find('#add-customer');
    const searchInput = $(searchContainer).find('input#phone');
    const searchResult = $(".customer-search-result");
    customerInfo.find("input").prop('disabled', true);

    searchInput.on('input', function (e) {
        e.preventDefault();
        addCustomerBtn.prop('disabled', searchInput.val().length > 0);
        const phone = $(this).val();
        console.log(phone);
        customerInfo.val("");
        $.ajax({
            url: `/admin/customer/search/${phone}`,
            type: 'GET',
            success: function (response) {
                searchResult.removeClass('d-none');
                searchResult.html('');
                let customerHtml = "";
                if(response.data) {
                    response.data.forEach(customer => {
                        const {id, name, address, phone, loyal_points} = customer;
                        customerHtml += `
                            <div class="customer-search-item d-flex align-items-center justify-content-between">
                                <div class="customer-search-item-info">
                                    <div class="customer-search-item-name">${name}</div>
                                    <div class="customer-search-item-phone">${phone}</div>
                                    <div class="customer-search-item-address d-none">${address}</div>
                                    <div class="customer-search-item-loyal-points d-none">${loyal_points}</div>
                                </div>
                                <div class="customer-search-item-action">
                                    <button class="btn btn-primary btn-select btn-sm" data-id="${id}">Select</button>
                                </div>
                            </div>
                        `;
                    });

                    const $customer = $(customerHtml);
                    searchResult.append($customer);

                    $(".btn-select").on("click", function (e) {
                        e.preventDefault();
                        let parent = $(this).closest(".customer-search-item");
                        let id = $(this).data("id");
                        let name = parent.find(".customer-search-item-name").text().trim();
                        let phone = parent.find(".customer-search-item-phone").text().trim();
                        let address = parent.find(".customer-search-item-address").text().trim();
                        let loyal_points = parent.find(".customer-search-item-loyal_points").text().trim();
                        $(customerInfo).data("id", id);
                        $(customerInfo).find("input#name").val(name);
                        $(customerInfo).find("input#phone").val(phone);
                        $(customerInfo).find("input#address").val(address);
                        $(customerInfo).find("input#loyal_points").val(loyal_points);
                        searchResult.addClass("d-none");
                        customerInfo.find("input").prop("disabled", true);
                    });
                } else {
                    searchResult.html(`
                            <div class="d-flex justify-content-center">
                                <p class="text-danger">Cannot found customer with phone: ${phone}</p>
                            </div>
                        `);
                    customerInfo.find("input").prop("disabled", true);
                }
                customerInfo.find("input").prop("disabled", true);
            },
            error: function (error) {
                console.log(error);
            }
        })
    });

    searchInput.on('blur', function (e) {
        console.log("blur")
        e.preventDefault();
        setTimeout(function () {
            searchResult.addClass("d-none");
        }, 1000);
    });

    addCustomerBtn.prop("disabled", !!$(customerInfo).data("id"));
    addCustomerBtn.on('click', function (e) {
        e.preventDefault();
        if ($(customerInfo).data("id")) {
            return;
        }
        searchInput.prop('disabled', true);

        const name = $(customerInfo).find("input#name");
        const phone = $(customerInfo).find("input#phone");
        const address = $(customerInfo).find("input#address");
        const loyal_points = $(customerInfo).find("input#loyal_points");

        if(name.prop("disabled") || phone.prop("disabled") || address.prop("disabled")) {
            customerInfo.find("input").prop("disabled", false);
            return;
        }
        if(!name.val() || !phone.val() || !address.val() || !loyal_points.val()) {
            alert("Please fill all fields");
            return;
        }
    });
}

function formatVND(price) {
    return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(price);
}

function fetchProducts(){
    let transactionId = localStorage.getItem("transaction_id");
    $.ajax({
        url: `/admin/transaction/${transactionId}`,
        type: 'GET',
        success: function (response) {
            const products = response.data.products;
            let productHtml = "";
            products.forEach((product, index) => {
                const {id, name, quantity, unit_price, image} = product;
                console.log(product);
                let currentIndex = index + 1;

                productHtml += `
                    <div class="product-item invoice-item" data-id="${id}">
                        <div class="">${currentIndex}</div>
                        <div class="d-flex align-items-center">
                            <img src="${image}" alt="" height="40px" width="auto"/>
                            <p class="m-0 ms-2">${name}</p>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <button class="btn btn-minus btn-sm" data-product-id="${id}">
                                    <i class='bx bx-minus'></i>
                                </button>
                                <input type="number" class="input-quantity quantity ${id}" value="${quantity}"
                                       min="1"
                                       style="width: 3rem;" data-product-id="${id}">
                                <button class="btn btn-plus btn-sm" data-product-id="${id}">
                                    <i class='bx bx-plus'></i>
                                </button>
                            </div>
                        </div>
                        <div class="retailPrice ${id}"  data-retail="${unit_price}">${formatVND(unit_price)}</div>
                        <div class="total ${id}" data-total="${unit_price * quantity}">
                            ${formatVND(unit_price * quantity)}
                        </div>
                        <div class="action">
                            <button class="btn btn-danger btn-remove ${id} btn-sm" data-product-id="${id}">
                                <i class='bx bx-trash'></i>
                            </button>
                            <button class="btn btn-warning btn-confirm ${id} btn-sm d-none" data-product-id="${id}">
                                <i class='bx bx-check'></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            $("#product-list").html(productHtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function searchBarcode(){
    const searchForm = $("#search");
    const searchInput = searchForm.find("input[name='keyword']");
    const searchBtn = searchForm.find("button[type='submit']");
    const searchResult = $(".product-search-result");
    let barcode;
    searchInput.on('input', function (e) {
        e.preventDefault();
        barcode = $(this).val().trim();
        if (barcode.length === 0) {
            searchResult.html("");
            return;
        }
        $.ajax({
            url: `/admin/product/search/${barcode}`,
            type: 'GET',
            success: function (response) {
                searchResult.removeClass('d-none');
                searchResult.html('');
                console.log(response.data);
                if(response.data) {
                    let productHtml = '<div class="product-search-list bg-success p-2 rounded">';
                    response.data.forEach(product => {
                        const {id, name, retail_price} = product;
                        productHtml += `
                            <div class="product-search-item d-flex align-items-center justify-content-between">
                                <div class="product-search-item-info">
                                    <div class="product-search-item-name">${name}</div>
                                    <div class="product-search-item-price">${retail_price}</div>
                                </div>
                                <div class="product-search-item-action">
                                    <button class="btn btn-primary btn-add btn-sm" data-id="${id}">Add</button>
                                </div>
                            </div>
                        `;
                    });
                    productHtml += '</div>';
                    searchResult.append(productHtml);
                } else {
                    searchResult.html(`
                            <div class="d-flex justify-content-center">
                                <p class="text-danger">Cannot found product with barcode: ${barcode}</p>
                            </div>
                        `).removeClass('d-none');
                }
                $(".btn-add").on("click", function (e) {
                    e.preventDefault();
                    let id = $(this).data("id");
                    let parent = $(this).closest(".product-search-item");
                    let price = parent.find(".product-search-item-price").text().trim();
                    addProductToCart(id,price);
                });
            },
            error: function (error) {
                searchResult.html("").removeClass('d-none');
                console.log(error);
            }
        })
    });
    $(document).on("click", function (e){
        if (!$(e.target).closest(".product-search-result").length && !$(e.target).closest("#search").length) {
            searchResult.addClass("d-none");
        }
    });

    searchInput.on('focus', function (e) {
        e.preventDefault();
        searchResult.removeClass('d-none');
    })
}

function addProductToCart(productId, price){
    let transactionId = localStorage.getItem("transaction_id");
    if (!transactionId) {
        alert("Transaction not started");
        return;
    }

    let formData = new FormData();
    formData.append('transaction_id', transactionId);
    formData.append('product_id', productId);
    formData.append('total_price', price);

    $.ajax({
        url: `/admin/transaction/store`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function (response) {
            console.log(response);
            fetchProducts();
            $('.product-search-result').addClass('d-none');
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function checkout(){
    const checkoutBtn = $("#checkout");
    const transactionId = localStorage.getItem("transaction_id");
    checkoutBtn.on("click", function (e) {
        e.preventDefault();
        let customerId = $(".customer-info").data("id");
        let formData = new FormData();
        formData.append('transaction_id', transactionId);
        formData.append('customer_id', customerId);

        $.ajax({
            url: `/admin/transaction/checkout`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log(response);
                localStorage.removeItem("transaction_id");
                window.location.href = "/admin/transaction";
            },
            error: function (error) {
                console.log(error);
            }
        })
    })
}
