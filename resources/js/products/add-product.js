$(document).ready(function() {
    handleUploadImage();
    $("#button-add-category").on("click", function () {
        $("#addCategoryModal").modal("show"); // Hiển thị modal
    });
    addCategory();
    handleProductAction('add');
    handleProductAction('edit');
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
function handleProductAction(action){
    const actionButton = action === 'add' ? $('#button-add-product') : $('#button-update-product');
    const confirmAddModal = $('#confirmAddModal');
    const confirmButton = $('.button-confirm');
    const categorySelect = $("#category");
    const warehouseSelect = $("#warehouse");
    const imageInput = $(".image-upload").find("#input-file");
    actionButton.on("click", function (e) {
        e.preventDefault();
        confirmAddModal.modal("show");
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
            $(confirmAddModal).find(".modal-body")
                                .text(`Bạn có chắc muốn ${action === 'add' ? 'thêm' : 'chỉnh sửa'} sản phẩm này không?`);
            confirmButton.css('display', 'block');
        }
        let formData = new FormData();
        Object.entries(fields).forEach(([key, value]) => {
            if (value !== undefined && value !== null) {
                if(["import_price", "retail_price", "quantity"].includes(key)) {
                    value = parseFloat(value);
                }
                formData.append(key, value);
            }
        });
        if(action === 'edit') {
            formData.append('_method', 'PUT');
        }
        const productId = $(this).attr("data-id");
        confirmButton.off("click").on("click", function (e) {
            e.preventDefault();
            $.ajax({
                url: action === 'add' ? '/admin/product' : `/admin/product/${productId}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    confirmAddModal.modal('hide');
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
        });
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
