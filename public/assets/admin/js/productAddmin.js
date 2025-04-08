
function openDetailProductModal(productId) {
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Product_Admin/detailProductId?product_id=${productId}`,
        success: function (data) {
            var html = `
                <img id="productImage" src="../public/assets/clients/img/${data.data.product_image}" alt="Product Image" style="max-width: 150px; ">
                <h5 id="productName">Product Name: ${data.data.product_name}</h5>
                
                <div class="col-12"><p><strong>Description:</strong> <span id="description">${data.data.product_description}</span></p></div>
                <div class= "row mt-3">
                    <div class="col-4"><p><strong>Category Name:</strong> <span id="categoryName">${data.data.category_name}</span></p></div>
                    <div class="col-4"><p><strong>RAM:</strong> <span id="ram">${data.data.product_ram}</span></p></div>
                    <div class="col-4"><p><strong>Price:</strong> <span id="price">${data.data.product_price}</span></p></div>
                </div>
                <div class= "row mt-3">
                    <div class="col-4"><p><strong>ROM:</strong> <span id="rom">${data.data.product_rom}</span></p></div>
                    <div class="col-4"><p><strong>Battery:</strong> <span id="battery">${data.data.product_battery}</span></p></div>
                    <div class="col-4"><p><strong>Screen:</strong> <span id="screen">${data.data.product_screen}</span></p></div>
                </div>
                <div class= "row mt-3">
                    <div class="col-4"><p><strong>Quantity:</strong> <span id="quantity">${data.data.quantity}</span></p></div>
                    <div class="col-4"><p><strong>Made In:</strong> <span id="madeIn">${data.data.product_made_in}</span></p></div>
                    <div class="col-4"><p><strong>Year Produce:</strong> <span id="yearProduce">${data.data.product_year_produce}</span></p></div>
                </div>
                <div class= "row mt-3">
                    <div class="col"><p><strong>Time Insurance:</strong> <span id="timeInsurance">${data.data.product_time_insurance}</span> months</p></div>
                </div>
            `;
            $('#productId').val(productId);
            $('#productDetails').html(html);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function updateProduct() {
    var beforeProductImage = $('#BeforeproductImage').val();
    var productImage = $('#productImage').prop('files')[0];
    var fileName = productImage ? productImage.name : beforeProductImage;
    var productId = $('#productId').val();
    var productName = $('#productNameUpdate').val();
    var productDescription = $('#productDescriptionUpdate').val();
    var productRam = $('#ramUpdate').val();
    var productRom = $('#romUpdate').val();
    var productBattery = $('#batteryUpdate').val();
    var productScreen = $('#screenUpdate').val();
    var madeIn = $('#madeInUpdate').val();
    var yearProduce = $('#yearProduceUpdate').val();
    var timeInsurance = $('#timeInsuranceUpdate').val();
    var price = $('#priceUpdate').val();

    var numberRegex = /^\d+$/;
    var textRegex = /^[a-zA-Z]+$/;

    // Validation
    if (productName === "") {
        alert("Product name cannot be empty");
        return;
    }
    if (!numberRegex.test(productRam)) {
        alert("RAM should be a number");
        return;
    }
    if (!numberRegex.test(productRom)) {
        alert("ROM should be a number");
        return;
    }
    if (!numberRegex.test(productBattery)) {
        alert("Battery should be a number");
        return;
    }
    if (!numberRegex.test(yearProduce)) {
        alert("Year produce should be a number");
        return;
    }


    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Product_Admin/updateProduct`,
        data: {
            product_image: fileName,
            product_id: productId,
            product_name: productName,
            product_description: productDescription,
            product_ram: productRam,
            product_rom: productRom,
            product_battery: productBattery,
            product_screen: productScreen,
            product_made_in: madeIn,
            product_year_produce: yearProduce,
            product_time_insurance: timeInsurance,
            product_price: price
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert("Successfully");
                location.reload();

            }
            else {
                alert(data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }

    });
}


function openUpdateProductModal(productId) {
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Product_Admin/updateProductId?product_id=${productId}`,
        success: function (data) {
            toastr.success('Nhập thông tin khách hàng thành công');
            var html = `
            <input id="BeforeproductImage" value="${data.data.product_image}" hidden>
            <button class='btn btn-primary me-1 mb-3 w-100 mt-3' id="deleteImageButton" onclick='deleteImage()'>Delete Image</button>
            <div class="row">
                <div class="mb-3" style="display: flex; align-items: center;">
                    <label for="productImage" class="form-label">Product Image:</label>
                    <input type="file" class="form-control" id="productImage" value="${data.data.product_image}"/>
                    <img id="previewUpdate" src="../public/assets/clients/img/${data.data.product_image}" alt="Image preview" style="max-width: 150px; margin-left: 10px;">
                </div>
            </div>
        
                <div class="row">
                    <div class="mb-3">
                        <label for="productNameUpdate" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" id="productNameUpdate" value="${data.data.product_name}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="priceUpdate" class="form-label">Price:</label>
                        <input type="text" class="form-control" id="priceUpdate" value="${data.data.product_price}"  disabled>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="categoryNameUpdate" class="form-label">Category Name:</label>
                        <input type="text" class="form-control" id="categoryNameUpdate" value="${data.data.category_name}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="productDescriptionUpdate" class="form-label">Description:</label>
                        <input type="text" class="form-control" id="productDescriptionUpdate" value="${data.data.product_description}" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="ramUpdate" class="form-label">RAM (Gb):</label>
                        <input type="number" class="form-control" id="ramUpdate" value="${data.data.product_ram}"  required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="romUpdate" class="form-label">ROM (Gb):</label>
                        <input type="number" class="form-control" id="romUpdate" value="${data.data.product_rom}"  required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="batteryUpdate" class="form-label">Battery (Mh):</label>
                        <input type="number" class="form-control" id="batteryUpdate" value="${data.data.product_battery}"  required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="screeUpdate" class="form-label">Screen:</label>
                        <input type="number" class="form-control" id="screenUpdate" value="${data.data.product_screen}"  required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="madeInUpdate" class="form-label">Made In:</label>
                        <input type="text" class="form-control" id="madeInUpdate" value="${data.data.product_made_in}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="yearProduceUpdate" class="form-label">Year Produce:</label>
                        <input type="number" class="form-control" id="yearProduceUpdate" value="${data.data.product_year_produce}"  required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="timeInsuranceUpdate" class="form-label">Time Insurance (months):</label>
                        <input type="number" class="form-control" id="timeInsuranceUpdate" value="${data.data.product_time_insurance}"  disabled>
                    </div>
                </div>

                `;
            $('#productUpdates').html(html);
            $('#productId').val(productId);

            $('#productImage').on('change', function (e) {
                if (this.files.length) {
                    var file = this.files[0]; // Lấy file từ input
                    $('#previewUpdate').attr('src', URL.createObjectURL(file)); // Hiển thị hình ảnh preview
            
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        var imageUrl = event.target.result;
                        $('#previewUpdate').attr('src', imageUrl); // Hiển thị hình ảnh
                    };
                    reader.readAsDataURL(file); // Chuyển đổi file thành URL dạng data
                }
            });
            
            

        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    })
}
function deleteImage() {
    const defaultImage = 'img_default.png';
    $('#productImage').val('');
    $('#previewUpdate').attr('src', `../public/assets/clients/img/${defaultImage}`);
    $('#BeforeproductImage').val(defaultImage);  // Cập nhật giá trị cho input ẩn
}


let currentPageProduct = 1;
let total_pageProduct = 0;

$(function () {
    load_dataProduct(currentPageProduct);
});

function load_next_page() {
    currentPageProduct++;
    if (currentPageProduct > total_pageProduct) {
        currentPageProduct = total_pageProduct;
    }
    if (isSoftPagination()) {
        loadDataSoft(currentPageProduct); // Chỉ cần truyền trang
    } else if ($('#search-product-input').val() !== '') {
        loadDataSearch(currentPageProduct); // Truyền trang cho tìm kiếm
    } else {
        load_dataProduct(currentPageProduct);
    }
}

function load_prev_page() {
    currentPageProduct--;
    if (currentPageProduct < 1) {
        currentPageProduct = 1;
    }
    if (isSoftPagination()) {
        loadDataSoft(currentPageProduct); // Chỉ cần truyền trang
    } else if ($('#search-product-input').val() !== '') {
        loadDataSearch(currentPageProduct); // Truyền trang cho tìm kiếm
    } else {
        load_dataProduct(currentPageProduct);
    }
}

function isSoftPagination() {
    return Object.keys(sortOrder).length > 0;
}



function load_dataProduct(page) {
    $.ajax({
        url: `http://localhost/shop/Product_Admin/loadDataProduct?page=${page}`, // Sửa pageSize thành số phần tử bạn muốn hiển thị trên mỗi trang
        method: "GET",
        success: function (data) {
            create_table(data.data);
            total_pageProduct = data.total_page;
            updatePagination();
        }
    });
}


function updatePagination() {
    $('#current_page').text(currentPageProduct);
    $('#total_pages').text(total_pageProduct);
    $('#pagination').empty();
    for (let i = 1; i <= total_pageProduct; i++) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="load_dataProduct(${i})">${i}</a></li>`);
    }
}

function create_table(data) {
    $('#contentDataProduct').empty();

    if (Array.isArray(data)) {
        data.forEach(item => {
            $('#contentDataProduct').append(`
                    <tr>
                        <td><img src='../public/assets/clients/img/${item.product_image}' alt='Product Image' style='width:130px; height:auto'></td>
                        <td>${item.category_name}</td>
                        <td>${item.product_name}</td>
                        <td>${item.stock || item.quantity}</td>
                        <td>${item.made_in || item.product_made_in}</td>
                        <td>${item.year_produce || item.product_year_produce}</td>
                        <td>${item.time_insurance || item.product_time_insurance}</td>
                        <td>${item.price || item.product_price}</td>
                        <td>
                        <div>
                            <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formDetailProduct' onclick='openDetailProductModal(${item.id || item.product_id})'>Detail</button>
                            <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formUpdateProduct' onclick='openUpdateProductModal(${item.id || item.product_id})'>Update</button>
                            <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#confirmDeleteProduct' onclick='confirmdeleteProduct(${item.id || item.product_id})'>Delete</button>
                        </div>
                        </td>
                    </tr>
                `);
        });
    } else {
        console.error('Data is not an array');
    }
}
var sortOrder = {};
function clearSortOrder() {
    sortOrder = {};
}

function confirmdeleteProduct(productId) {
    var html = `
            <p>Bạn có chắc chắn muốn xóa Sản Phẩm này không ???</p>
            `;
    $('#content-confirm').html(html);
    $('#productId').val(productId);
}



function deleteProduct_de() {
    var productId = $('#productId').val();
    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Product_Admin/deleteProduct`,
        data: {
            product_id: productId,
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert("Delete Product Successfully");
                location.reload();

            }
            else {
                alert(data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }

    });
}
function softInfo(column, page) {
    if (!sortOrder[column]) {
        sortOrder[column] = 'asc';
    } else {
        sortOrder[column] = sortOrder[column] === 'asc' ? 'desc' : 'asc';
    }

    $.ajax({
        type: 'POST',
        url: 'http://localhost/shop/Product_Admin/softProduct',
        data: { columnProduct: column, sortOrderProduct: sortOrder[column], page: currentPageProduct },
        success: function (response) {
            create_table(response.data);
            updatePaginationSort(response.total_pageProduct); // Corrected function call
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function loadDataSoft(page) {
    // Lấy tên cột và thông tin soft từ biến sortOrder
    var column = Object.keys(sortOrder)[0];
    var sortOrderValue = sortOrder[column];

    $.ajax({
        url: `http://localhost/shop/Product_Admin/softProduct`,
        method: "POST",
        data: { columnProduct: column, sortOrderProduct: sortOrderValue, page: page },
        success: function (data) {
            create_table(data.data);
            updatePaginationSort(data.total_pageProduct); // Truyền số trang cần cập nhật
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function updatePaginationSort(total_ptotal_pageProductage) {
    $('#current_page').text(currentPageProduct);
    $('#total_pages').text(total_pageProduct);
    $('#pagination').empty();
    for (let i = 1; i <= total_pageProduct; i++) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="loadDataSoft(${i})">${i}</a></li>`);
    }
}


function searchProduct() {
    var key = document.getElementById('search-product-input').value;
    if (key.trim() === '') {
        load_dataProduct(currentPageProduct); // Load lại dữ liệu khi input search trống
        updatePagination();
    } else {
        $.ajax({
            type: 'POST',
            url: 'http://localhost/shop/Product_Admin/searchProduct',
            data: { keyword: key, page: currentPageProduct },
            success: function (response) {
                create_table(response.data);
                currentPageProduct = response.currentPageProduct;
                total_pageProduct = response.total_pageProduct;
                updatePaginationSearch(response.currentPageProduct, response.total_pageProduct);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}

function loadDataSearch(page) {
    var key = document.getElementById('search-product-input').value.trim(); // Sử dụng trim để loại bỏ khoảng trắng thừa

    if (key === "") {
        load_dataProduct(currentPageProduct); // Load lại dữ liệu khi input search trống
        updatePagination();
    } else {
        $.ajax({
            url: `http://localhost/shop/Product_Admin/searchProduct`,
            method: "POST",
            data: { keyword: key, page: currentPageProduct },
            success: function (data) {
                if (data != "No products found") {
                    create_table(data.data);
                    updatePaginationSearch(data.currentPageProduct, data.total_pageProduct); // Truyền số trang cần cập nhật
                } else {
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}


function updatePaginationSearch(currentPageProduct, total_pageProduct) {
    $('#current_page').text(currentPageProduct);
    $('#total_pages').text(total_pageProduct);
    $('#pagination').empty();

    if (total_pageProduct > 1) {
        for (let i = 1; i <= total_pageProduct; i++) {
            $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="loadDataSearch(${i})">${i}</a></li>`);
        }
    } else {
        $('#pagination').append(`<li class="page-item active"><a class="page-link">${currentPageProduct}</a></li>`);
    }
}

