$(document).ready(function() {
    handleUploadImage();
    $("#button-add-category").on("click", function () {
        $("#addCategoryModal").modal("show"); // Hiển thị modal
    });
    addCategory();
    addProduct();
});
function handleUploadImage(){
    const imagePreview = $(".image-preview");
    const imageUpload = $(".image-upload");
    const imageInput = $(imageUpload).find("#input-file");
    // Image preview
    imageInput.on("change", function (e) {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    });
}

function addCategory() {
    const CategoryForm = $("#CategoryForm");
    const addCategoryModal = $("#addCategoryModal");
    CategoryForm.submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '/admin/category',
            type: 'POST',
            data: formData,
            success: function(response) {
                addCategoryModal.modal('hide');
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
}

function addProduct(){
    const addButton = $('#button-add-product');
    const confirmAddModal = $('#confirmAddModal');
    const confirmButton = $('.button-confirm');
    const categorySelect = $("#category");
    const warehouseSelect = $("#warehouse");
    const imageInput = $(".image-upload").find("#input-file");
    addButton.on("click", function (e) {
        e.preventDefault();
        confirmAddModal.modal("show");
        let formData = new FormData();
        const fields = {
            name: $("#productName").val(),
            image: imageInput[0].files[0],
            import_price: $("#importPrice").val(),
            retail_price: $("#retailPrice").val(),
            description: $("#description").val(),
            category_id: categorySelect.val(),
            quantity: $("#quantity").val(),
            warehouse_id: warehouseSelect.val()
        }
        if (Object.values(fields).some(field => !field)) {
            $(confirmAddModal).find(".modal-header")
                                .removeClass()
                                .addClass("modal-header modal-colored-header bg-danger");
            $(confirmAddModal).find(".modal-body").text("Vui lòng nhập đầy đủ thông tin");
            confirmButton.css('display', 'none');
            return;
        } else {
            $(confirmAddModal).find(".modal-header")
                                .removeClass('bg-danger')
                                .addClass("bg-primary");
            $(confirmAddModal).find(".modal-body").text("Bạn có chắc muốn thêm sản phẩm này không?");
            confirmButton.css('display', 'block');
        }
        Object.entries(fields).forEach(([key, value]) => {
            formData.append(key, value);
        });
        confirmButton.off("click").on("click", function (e) {
            console.log(fields.image);
            e.preventDefault();
            $.ajax({
                url: '/admin/product',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    confirmAddModal.modal('hide');
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
    });
}


