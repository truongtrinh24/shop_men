<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>



<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 d-flex">
                    <a class="page-link " href="<?php echo _WEB_ROOT; ?>/ImportController" aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                        </svg>
                    </a>
                    <span class="ms-2">Nhập Hàng</span>
                </div>
                <div class="col-12 mt-4 position-relative">
                    <div class="d-flex align-items-center justify-content-between">
                        <nav class="search w-50">
                            <div class="d-flex" id="id">
                                <input onkeyup="debounceSearchProduct()" id="search" class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" />
                                <button type="button" class="btn btn-primary fs-6" onclick="modalAddProduct()">+</button>
                            </div>

                        </nav>

                        <div class="d-flex">
                            <button type="button" class="btn btn-primary" id="btn_import_info">
                                Nhập hàng
                            </button>

                            <button onclick="showModalExcel()" class="ms-2 btn btn-success">Nhập Excel</button>

                        </div>

                    </div>
                    <!-- search product -->
                    <div id="product_search" class="position-absolute  container bg-secondary-subtle rounded ">

                    </div>
                    <!-- end -->
                </div>
                <div class="mt-2">
                    <table id="load_data" class="table ">
                        <thead>
                            <tr>
                                <td></td>
                                <th>Mã SP </th>
                                <th>Tên Hàng</th>
                                <th>Số Lượng</th>
                                <th>Số seri</th>
                                <th>Đơn Giá</th>
                                <th>Giá Bán</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



</div>
<!-- modal thông tin phiếu nhập -->
<div class="modal fade" id="import_info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông Tin Phiếu Nhập</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <span>Nhân viên:</span>
                    </div>
                    <div class="col-8">

                        <span id="userInfo" data-id="<?php echo $_SESSION['user_session']['user']['username']; ?>" class="ms-2"><?php echo $_SESSION['user_session']['user']['username']; ?></span>

                       

                      

                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <span>Ngày Nhập:</span>
                    </div>
                    <div class="col-8">
                        <input class="w-50 border-0 ms-2 " type="" id="date_good_receipt" value="" min="2018-01-01" disabled max="2030-12-31" />
                    </div>
                </div>
                <div class="row mt-2 align-items-center">
                    <div class="col-3">
                        <label for="product_type">Nhà cung cấp:</label>
                    </div>
                    <div class="col-7 d-flex">
                        <select id="supplierSelect" class="form-select form-select-sm border-0">

                        </select>
                    </div>
                    <div class="col-2"><button onclick="showModalSupplier()" class="btn btn ms-2 fs-6 btn bg-success">+</button></div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <label class="">Tổng tiền:</label>
                    </div>
                    <div class="col-8">
                        <input value="" type="" id="total_good_receipt_input" class="border-0 border-bottom border-danger ms-2 " disabled />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button onclick="saveGoodReceipt()" type="button" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
<!-- modal nhập excel -->
<div class="modal fade" id="modal_excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nhập excel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="mt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="file" id="excelFileInput">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="importExcel()" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!--  modal thêm hàng hóa mới -->
<div class="modal fade" id="add_new_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Hàng Hóa Mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">

                <div class="" id="">
                    <div class="mt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Tên sản phẩm</label>
                                <input value="" type="text" class="form-control" name="name_product_new" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Thời gian bản hành</label>
                                <input value="" type="number" min="1" max="12" class="form-control" name="date_insurance" />
                            </div>
                            <div class=" form-group col-md-6 mt-2">
                                <div>
                                    <label for="inputPassword4">Loại sản phẩm</label>
                                    <select name="" id="category_id" name="category_product_new" class="form-select form-select- mb-3 ">

                                    </select>
                                </div>

                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <button onclick="showModalCateogry()" id="btn_modal_category" style="margin-top: 21px;" class="btn btn-success">+</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Ram</label>
                                <input value="" type="number" class="form-control" name="ram" />
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="inputPassword4">Rom</label>
                                <input value="" type="number" class="form-control" name="rom" />
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="inputPassword4">Thời Lượng pin</label>
                                <input value="" type="number" class="form-control" name="product_battery" />
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="inputPassword4">Màn hình</label>
                                <input value="" type="number" class="form-control" name="screen_product" />
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="inputPassword4">Xuất xứ</label>
                                <input value="" type="text" class="form-control" name="product_made_in" />
                            </div>
                            <div class=" form-group col-md-6">
                                <label for="inputPassword4">Năm sản xuất</label>
                                <input value="" type="number" class="form-control" name="product_year_produce" />
                            </div>
                            <div class="mt-2 form-group col-md-6">
                                <label for="">Ảnh</label>
                                <input value="" type="file" onchange="chooseImage(this)" class="form-control" id="product_image_db" />

                            </div>
                            <div class="mt-4 form-group col-md-6">
                                <img id="img_product" src="" alt="Image preview" class="border border-dark" style="width: 200px; height:200px;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="addNewProduct()" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- modal thêm loại sản phẩm -->
<div class="modal fade" id="modal_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Loại Sản Phẩm</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="mt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Loại sản phẩm</label>
                            <input value="" type="" class="form-control" name="name_category" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="addNewCategory()" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- modal thêm nhà cung cấp mới -->
<div class="modal fade" id="modal_supplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Nhà Cung Cấp Mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="mt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Tên nhà cung cấp</label>
                            <input value="" type="text" class="form-control" name="name_supplier" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Số điện thoại</label>
                            <input value="" type="text" class="form-control" name="phone_supplier" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Email</label>
                            <input value="" type="email" class="form-control" name="email_supplier" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">địa chỉ</label>
                            <input value="" type="text" class="form-control" name="address_supplier" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="addNewSupplier()" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var dd = String(today.getDate()).padStart(2, '0');
    var formattedDate = yyyy + '-' + mm + '-' + dd;
    document.getElementById("date_good_receipt").value = formattedDate;
</script>

<script>
    $(document).ready(function() {
        load_data_category();
        load_data_supplier();

        var preview = document.getElementById('img_product');
        preview.src = "<?php echo _WEB_ROOT; ?>/public/assets/clients/img/img_default.png";

    });

    function chooseImage(input) {
        var preview = document.getElementById('img_product');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            // reader.readAsDataURL(input.files[0]);
            console.log(reader.readAsDataURL(input.files[0]))
        } else {
            preview.src = "<?php echo _WEB_ROOT; ?>/public/assets/clients/img/img_default.png";
        }
    }
    // load nhà cung cấp
    function load_data_supplier() {
        $.ajax({
            url: `http://localhost/shop/ImportController/getAllSupplier`,
            method: "GET",
            success: function(data) {
                var select = document.getElementById('supplierSelect');
                select.innerHTML = ''; // Clear existing options
                select.innerHTML += `<option selected>0-chọn nhà cung cấp</option>`;
                data.data.forEach(function(supplier) {
                    select.innerHTML += `<option value="${supplier.supplier_id }">${supplier.supplier_name}</option>`;
                });

            }
        });
    }
    // load loại sản phẩm
    function load_data_category() {
        $.ajax({
            url: `http://localhost/shop/ImportController/getAllCategory`,
            method: "GET",
            success: function(data) {
                var select = document.getElementById('category_id');
                select.innerHTML = ''; // Clear existing options
                select.innerHTML += `<option selected>0-chọn loại sản phẩm</option>`;
                data.data.forEach(function(category) {
                    select.innerHTML += `<option value="${category.category_id}">${category.category_name}</option>`;
                });

            }
        });
    }

    function debounce(callback, delay) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                callback(...args);
            }, delay);
        }
    }

    function createLoadDataRow(product_id, product_name, product_quantity = 1, product_price = 0, seri_start = "", seri_end = "") {
        return `
        <tr>
            <td>
                <span onclick="delete_good_receipt(this.parentNode.parentNode)" id="btn_delete_good_rece" style="cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                </span>
            </td>
            <td>${product_id}</td>
            <td>${product_name}</td>
            <td>
                <input type="button" onclick="decreaseQuantity(this)" value="-" class="button_quantity button_minus border icon-shape icon-sm mx-1">
                <input onkeyup="updateTotal(this)" type="number" min="1" step="1" value="${product_quantity}" id="quantity" name="quantity" class="quantity border-0 text-center w-50">
                <input type="button" onclick="increaseQuantity(this)" value="+" class="increase-quantity button_quantity button_plus border icon-shape icon-sm">
            </td>
            <td>
                <input type="text" placeholder="seri bắt đầu" value="${seri_start}" name="seri_start" class="seri_start border-0 border-bottom border-danger text-center w-50">
                <input type="text" placeholder="seri kết thúc" value="${seri_end}" name="seri_end" class="seri_end border-0 border-bottom border-danger text-center w-50">
            </td>
            <td>
                <input type="number" "  value="${product_price}" id="price" onkeyup="updateTotal(this)" name="price" class="price border-0 border-bottom border-danger text-center w-100">
            </td>

            <td>
                <input type="number" onkeyup="updateTotal(this)"   value="" name="price_percent" onkeyup=""  class="price border-0 border-bottom border-danger text-center w-100">
            </td>
            <td>
                <input type="number"  value="" id="total" name="total" class="total border-0 border-bottom border-danger text-center w-100" disabled>
            </td>
        </tr>`;
    }

    function load_search_product(data) {
        $('#product_search').empty();
        $('#product_search').append(`
                        <table id="load_data_product" class="table  " >
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng hiện tại</th>
                                    <th>Mã loại</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class=" d-flex  justify-content-end">
                            <button type="button" id="save_product" class="btn btn-success">Áp dụng</button>
                            <button type="button" id="close" class="btn btn-success ms-2">Đóng</button>
                        </div>
                        `)
        if (data) {
            data.data.forEach((item, index) => {
                $('#load_data_product tbody').append(`
                            <tr>
                                <td>
                                  ${index}
                                </td>
                                <td>${item.product_id}</td>
                                <td>${item.product_name}</td>
                                <td>${item.product_count}</td></td>
                                <td>${item.category_id}</td>
                                <td>
                                    <input type="checkbox" class="product_id"  value="${item.product_id}"/>
                                </td>
                            </tr>
                                 `);
            })
        }
        const close = document.getElementById('close');
        close.addEventListener('click', function() {
            $('#product_search').hide();
            $('#search').val('')
        });
        const save_product = document.getElementById('save_product');
        save_product.addEventListener('click', function() {
            const loadDataBody = document.querySelector('#load_data tbody');
            const productIds = document.querySelectorAll('.product_id:checked');
            productIds.forEach((item, index) => {
                const productRow = item.closest('tr');
                const productId = productRow.querySelector('td:nth-child(2)').textContent;
                const productName = productRow.querySelector('td:nth-child(3)').textContent;
                const productCount = productRow.querySelector('td:nth-child(4)').textContent;
                const categoryId = productRow.querySelector('td:nth-child(5)').textContent;

                const existingProductRow = $('#load_data tbody').find(`td:contains(${productId})`).closest('tr');
                if (existingProductRow.length) {
                    const existingQuantity = parseInt(existingProductRow.find('.quantity-field').val());
                    existingProductRow.find('.quantity-field').val(existingQuantity + 1);
                } else {
                    const newRow = createLoadDataRow(productId, productName);
                    $('#load_data tbody').append(newRow);
                }
            });

            $('#product_search').hide();
        });
    }
    // tìm kiếm sản phẩm có trong db
    function searchProduct() {
        $.ajax({
            url: "http://localhost/shop/ImportController/getAllProducts",
            method: 'POST',
            data: {
                searchInput: $('#search').val(),
            },
            success: function(data) {
                load_search_product(data)
                $('#product_search').show();
            }

        })
    }
    const debounceSearchProduct = debounce(searchProduct, 1000);

    // lấy số seri
    function seriProduct(start, end) {
        let result = [];
        let startNum = parseInt(start.substring(8));
        let endNum = parseInt(end.substring(8));
        // console.log(result.slice(0, 5));
        for (let i = startNum; i <= endNum; i++) {
            let productId = start.substring(0, 8) + i
            result.push(productId);
        }
        return result;
    }
    // lưu hóa đơn nhập hàng
    function saveGoodReceipt() {
        const loadDataBody = document.querySelector('#load_data tbody');
        let date_good_receipt = document.getElementById('date_good_receipt').value;
        let supplier_id = document.getElementById("supplierSelect").value;
        let total_good_receipt_input = document.getElementById("total_good_receipt_input").value;


        var userId = document.getElementById('userInfo').getAttribute('data-id');
        console.log("account:"+userId);


        if (supplier_id === '0-chọn nhà cung cấp') {
            alert('vui lòng chọn nhà cung cấp')
            return;
        }
        var tableBody = document.querySelector('#load_data tbody');
        let result = [];
        let price_percent
        // lấy tất cả hàng trong body
        var rows = tableBody.querySelectorAll('tr');
        // chi tiết
        let product_details = []
        rows.forEach(function(row) {
            // lấy dữ liệu theo từng hàng
            var productId = row.querySelector('td:nth-child(2)').innerText;
            var productName = row.querySelector('td:nth-child(3)').innerText;
            var quantity = parseInt(row.querySelector('input[name="quantity"]').value);
            var seriStart = row.querySelector('input[name="seri_start"]').value;
            var seriEnd = row.querySelector('input[name="seri_end"]').value;
            var price = row.querySelector('input[name="price"]').value;
            var total = row.querySelector('input[name="total"]').value;
            price_percent = row.querySelector('input[name="price_percent"]').value

            // giá bán
            // var price_sale
            // price_percent
            // TEST88000001  TEST88000010  
            // TEST98000001  TEST98000010 
            let seris = seriProduct(seriStart, seriEnd)
            let seri_product = seris.slice(0, quantity)

            for (var i = 0; i < quantity; i++) {
                let seris = seriProduct(seriStart, seriEnd)
                product_details.push({
                    "product_id": productId,
                    "product_seri": seri_product[i],
                    "price": price,
                })
            }


            //  end ajax
        });
      
        $.ajax({
            url: "http://localhost/shop/ImportController/insertGoodReceipt",
            method: 'POST',
            data: {
                supplier_id: supplier_id,
                employee_id: userId,
                // employee_id: "NV01",

                price_percent:price_percent,
                date_good_receipt: date_good_receipt,
                total: total_good_receipt_input,
                product_details: product_details
            },
            success: function(data) {
                console.log(data);
                if (data.error) {
                    alert(data.error)
                } else {
                    alert(data.success)
                    $('#import_info').modal('hide');
                    loadDataBody.innerHTML = '';
                    load_data_supplier()
                    // window.location.href = "http://localhost/shop/ImportController";
                }
            }

        })
    }

    function total_good_receipt_input(input) {

    }

    function increaseQuantity(button) {
        let productRow = button.closest('tr');
        let quantityInput = productRow.querySelector('.quantity');
        let quantityValue = parseInt(quantityInput.value);
        quantityValue++;
        quantityInput.value = quantityValue;
        updateTotal(productRow);
    }

    function decreaseQuantity(button) {
        let productRow = button.closest('tr');
        let quantityInput = productRow.querySelector('.quantity');
        let quantityValue = parseInt(quantityInput.value);
        if (quantityValue > 1) {
            quantityValue--;
            quantityInput.value = quantityValue;
            updateTotal(productRow);
        }
    }
    //  tính tiền trong bảng
    function updateTotal(input) {
        const row = input.closest('tr');
        const quantity = parseInt(row.querySelector('.quantity').value);
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const total = quantity * price;
        row.querySelector('.total').value = total;
        updateOverallTotal();
    }
    //  tính tông tiền hóa đơn
    function updateOverallTotal() {
        let overallTotal = 0;
        const totalInputs = document.querySelectorAll('.total');
        totalInputs.forEach(input => {
            overallTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('total_good_receipt_input').value = overallTotal
    }

    var table = document.querySelector("#load_data tbody");
    var btn_import_info = document.getElementById("btn_import_info");

    // click vào modal nhập hàng
    btn_import_info.addEventListener('click', function() {
        var rows = table.rows;
        var isCheck = true;
        if (table.rows.length > 0 && isCheck) {
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var seriStart = row.querySelector('input[name="seri_start"]').value;
                var seriEnd = row.querySelector('input[name="seri_end"]').value;
                var price = row.querySelector('input[name="price"]').value;
                var price_percent = row.querySelector('input[name="price_percent"]').value;
                // console.log(typeof parseInt(price_percent))
                // console.log(typeof price_percent)
                var a = parseInt(price_percent) - parseInt(price)
                // console.log(a)
                if (seriStart === '' || seriEnd === '' || price === '' || price_percent === '') {
                    alert('Vui lòng nhập đầy đủ thông tin trong bảng');
                    isCheck = false;
                    break;
                }
                if (seriStart.length < 9 || seriEnd.length < 9) {
                    alert('Seri phải có ít nhất 9 ký tự');
                    isCheck = false;
                    break;
                }

                if (a <= 200000) {
                    alert('Giá bán phải lớn hơn giá nhập 200 nghàn!')
                    isCheck = false;
                    break;
                }
            }
            if (isCheck) {
                var modal = new bootstrap.Modal(document.getElementById("import_info"));
                modal.show();
            }
        } else {
            alert("Không có sản phẩm để nhập hàng.");
        }
    })
    // thêm sản phẩm mới
    function addNewProduct() {
        var name_product = document.querySelector('input[name="name_product_new"]').value;
        var date_insurance = document.querySelector('input[name="date_insurance"]').value;
        var category_product_new = document.getElementById('category_id').value
        var ram = document.querySelector('input[name="ram"]').value;
        var rom = document.querySelector('input[name="rom"]').value;
        var product_battery = document.querySelector('input[name="product_battery"]').value;
        var screen_product = document.querySelector('input[name="screen_product"]').value;
        var product_made_in = document.querySelector('input[name="product_made_in"]').value;
        var product_year_produce = document.querySelector('input[name="product_year_produce"]').value;


        var product_image_db = document.getElementById('product_image_db').value;
        var fileName = product_image_db.split('\\').pop();

        if (name_product === '' || date_insurance === '' || category_product_new === '0-chọn loại sản phẩm' ||
            ram === '' || rom === '' || product_battery === '' || screen_product === '' || product_made_in === '' || product_year_produce === ''
        ) {
            alert('Vui lòng điền đầy đủ thông tin');
            return;
        }
        if (date_insurance < 1 || date_insurance > 12) {
            alert('thời gian bảo hành nhập từ tháng từ 1 đến 12');
            return
        }
        if (!product_image_db) {
            alert('vui lòng chọn ảnh')
            return
        }
        if (!fileName.split('.')[1].match('jpg') && !fileName.split('.')[1].match('png')) {
            alert('chọn ảnh có đuôi jpg hoặc png')
            return
        }

        var form_Data = new FormData();
        form_Data.append('category_id', category_product_new);
        form_Data.append('product_name', name_product);
        form_Data.append('date_insurance', date_insurance);
        form_Data.append('ram', ram);
        form_Data.append('rom', rom);
        form_Data.append('battery', product_battery);
        form_Data.append('screen', screen_product);
        form_Data.append('made_in', product_made_in);
        form_Data.append('year_produce', product_year_produce);
        form_Data.append('img', fileName);


        $.ajax({
            url: "http://localhost/shop/ImportController/addNewProduct",
            method: 'POST',
            data: form_Data,
            processData: false,
            contentType: false,
            success: function(data) {
                var responseData = JSON.parse(data);
                if (responseData) {
                    alert(responseData.message);
                    $('#add_new_product').modal('hide');
                    let productId = responseData.data.product_id
                    let name = responseData.data.product_name
                    console.log(productId, name)
                    const newRow = createLoadDataRow(productId, name);
                    $('#load_data tbody').append(newRow);
                } else {
                    alert(responseData.message);
                }
            }

        })
    }

    function modalAddProduct() {
        $('#add_new_product').modal('show');
    }

    function delete_good_receipt(row) {
        row.remove();
    }
    // hiện modal thêm loại sản phẩm
    function showModalCateogry() {
        $('#modal_category').modal('show');
    }
    // thêm loại sản phẩm mới
    function addNewCategory() {
        let name_category = document.querySelector('input[name="name_category"]').value
        if (name_category === '') {
            alert('vui lòng nhập đầy đủ thông tin')
            return;
        }
        $.ajax({
            url: "http://localhost/shop/ImportController/add_category",
            method: 'POST',
            data: {
                name_category: name_category
            },
            success: function(data) {
                alert(data.message);
                $('#modal_category').modal('hide');
                load_data_category()
            }
        })
    }
    // hiện modal excel
    function showModalExcel() {
        $('#modal_excel').modal('show');
    }
    // hiện modal thêm nhà cung cấp
    function showModalSupplier() {
        $('#modal_supplier').modal('show');
    }
    // thêm nhà cung cấp mới
    function addNewSupplier() {
        let name_supplier = document.querySelector('input[name="name_supplier"]').value
        let phone_supplier = document.querySelector('input[name="phone_supplier"]').value
        let address_supplier = document.querySelector('input[name="address_supplier"]').value
        let email_supplier = document.querySelector('input[name="email_supplier"]').value
        if (name_supplier === '' || phone_supplier === '' || address_supplier === '' || email_supplier === '') {
            alert('vui lòng nhập đầy đủ thông tin')
            return;
        }
        if (!(/^\d{10}$/.test(phone_supplier))) {
            alert('Số điện thoại không đúng định dạng');
            return;
        }
        if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_supplier)) {
            alert('Email không đúng định dạng');
            return;
        }
        $.ajax({
            url: "http://localhost/shop/ImportController/add_supplier",
            method: 'POST',
            data: {
                name_supplier: name_supplier,
                phone_supplier: phone_supplier,
                address_supplier: address_supplier,
                email_supplier: email_supplier,
            },
            success: function(data) {
                alert(data.message);
                $('#modal_supplier').modal('hide');
                load_data_supplier()
            }
        })
        alert('Success')
    }

    function importExcel() {
        let fileInput = document.getElementById('excelFileInput');
        if (fileInput.files.length === 0) {
            alert('vui lòng chọn file')
            return
        }
        let fileName = fileInput.files[0].name
        let fileNameLast = fileName.split('.')[1].toLowerCase()
        if (fileNameLast !== 'xlsx') {
            alert('vui lòng chọn file excel có định dạng .xlsx')
            return
        }
        let formData = new FormData();
        formData.append('excelFile', fileInput.files[0])
        $.ajax({
            url: "http://localhost/shop/ImportController/importExcel",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                // product_id, product_name, product_quantity = 1, product_price, seri_start, seri_end) 
                console.log(data)
                if (data.error) {
                    alert('có lỗi :' + data.error)
                } else {
                    data.data.forEach((item) => {
                        console.log(item)
                        const newRow = createLoadDataRow(item.product_id, item.product_name, item.product_quantity, item.price, item.seri[0], item.seri[item.seri.length - 1]);
                        $('#load_data tbody').append(newRow);

                        const inputInNewRow = $(newRow).find('.quantity');
                        updateTotal(inputInNewRow[0]);
                    })
                    $('#modal_excel').modal('hide');
                    updateOverallTotal()


                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Có lỗi xảy ra khi đẩy dữ liệu từ Excel lên máy chủ.');
            }
        })
    }
</script>