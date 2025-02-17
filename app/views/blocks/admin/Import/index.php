<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="container-fluid">
    <div id="dulieu"></div>
    <div class="row">
        <div class="col-2 ">
            <span>Phiếu Nhập Hàng</span>
        </div>
        <div class="col-10">
            <div class="d-flex align-items-center justify-content-between">
                <nav class="search w-50">
                    <div class="d-flex">
                        <input onkeyup="searchByEmployee()" id="search" class="form-control me-2" type="search" placeholder="Tìm Kiếm" aria-label="Search" />
                    </div>
                </nav>
                <div class="d-flex">
                    <div class="dropdown ">
                        <!-- <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Thao Tác
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Xuất Excel</a></li>
                            <li><a class="dropdown-item" href="#">Xuất DPF</a></li>

                        </ul> -->
                    </div>

                    <a href="<?php echo _WEB_ROOT; ?>/ImportController/ImportGoodReceipt" class="ms-2 btn btn-success">
                        Nhập Hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8 d-flex">
            <div>
                <label for="start">Từ:</label>
                <input onchange="searchByDate_good()"  class="w-100 border-0" type="date" id="startDate_good"  value=""  />
            </div>
            <br />
            <div class="ms-4">
                <label for="end">Đến:</label>
                <input onchange="searchByDate_good()" class="w-100 border-0" type="date" id="endDate_good"  value=""  />
            </div>
          
            <!-- <div>
                <button onclick="searchByDate_good()" class="btn btn-success ms-4">lọc</button>
            </div> -->
        </div>
        <div class="col-2"></div>
        <div class="col-2">
            <nav aria-label="Page navigation example ">
                <ul class="pagination d-flex justify-content-center ">
                    <li class="page-item">
                        <a onclick="load_prev_page_good()" class="page-link  text-dark fs-3" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <span class="page-link text-dark fw-semibold"> <span id="current_page_good" class="text-primary"></span>/<span id="total_pages_good"></span></span>
                    </li>
                    <li class="page-item">
                        <a onclick="load_next_page_good()" class="page-link  text-dark fs-3" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <!-- <div id="id"></div> -->
            <table id="load_data_import" class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã Nhập Hàng</th>
                        <th>Ngày Nhập</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Tổng Tiền</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>


        </div>
    </div>
</div>
<!-- modal detail -->
<div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông Tin Phiếu Nhập</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="row ">
                    <div class="col-2">
                        <span>Mã nhập hàng:</span>
                    </div>
                    <div class="col-2">
                        <input type="number" step="" value="" id="detail_good_id" name="detail_good_id" disabled class=" border-0 border-bottom border-dark text-center w-100">
                    </div>
                    <div class="col-2">
                        <span>Ngày nhập:</span>
                    </div>
                    <div class="col-4">
                        <input type="text" step="" value="" id="detail_good_date " name="detail_good_date" disabled class=" border-0 border-bottom border-dark text-center w-50">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        <span>Người tạo:</span>
                    </div>
                    <div class="col-2">
                        <input type="text" step="" value="" id="detail_person" name="detail_person" disabled class=" border-0 border-bottom border-dark text-center w-100">
                    </div>
                </div>
                <div class="row mt-2">
                    <div style="height: 300px;  overflow: auto" class="container">
                        <table id="load_data_detail_good" class="table table-striped ">
                            <thead>
                                <div style=" max-height: 100%; overflow: auto;">
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </div>

                            </thead>
                            <tbody style="overflow: auto;">
                                <!-- 
                                     <tr>
               
                <td>${item.good_receipt_id}</td>
                <td>${item.date_good_receipt}</td>
                <td>${item.supplier_id}</td>
                <td>${item.total}</td>
              
                <td>
                    <button onclick="detail('${item.good_receipt_id}')" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </td>
              </tr>
                                 -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-5">
                                <span>Tổng số lượng:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_quantity"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <span>Tổng mặt hàng:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_product"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <span>Tổng Tiền:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_good"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="exportToPDF()" class="btn btn-primary">Xuất file pdf</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        load_data_good();
    });
</script>
<script>
     function setCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const currentDate = `${year}-${month}-${day}`;
        
        document.getElementById('endDate_good').value = currentDate;
    }

    // Call the function to set the current date when the page loads
    window.onload = setCurrentDate;

    let currentPage_good = 1
    let tongsotrang = 0
    
    function create_tablee(data) {
        $('#load_data_import tbody').empty();
        // $('#load_data_import tbody').text(data)
        data.forEach(item => {
            $('#load_data_import tbody').append(`
              <tr>

                <td>${item.good_receipt_id}</td>
                <td>${item.date_good_receipt}</td>
                <td>${item.supplier_id}</td>
                <td>${item.total}</td>

                <td>
                    <button onclick="detail('${item.good_receipt_id}')" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </td>
              </tr>

            `)
        })
    }

    function load_data_good() {
        $.ajax({

            url: `http://localhost/shop/ImportController/getAllGood?page=${currentPage_good}`,
            method: "GET",
            page: {
                currentPage_good
            },
            success: function(data) {

                create_tablee(data.data)
                tongsotrang = data.total_page
                updatePagination_good();
             
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải dữ liệu:', status, error);
            }
        });
    }

    function updatePagination_good() {
        $('#current_page_good').text(currentPage_good);
        $('#total_pages_good').text(tongsotrang);
    }

    function load_next_page_good() {
        currentPage_good++;
        if (currentPage_good > tongsotrang) {
            currentPage_good = 1
        }
        load_data_good();
    }

    function load_prev_page_good() {
        currentPage_good--;
        if (currentPage_good < 1) {
            currentPage_good = 1
        }
        load_data_good();
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

    const debounceSearch = debounce(search, 1000);

    function searchByEmployee() {

        $.ajax({
            url: `http://localhost/shop/ImportController/searchGoodReceipt`,
            method: 'POST',
            data: {
                searchInput: $('#search').val(),
            },
            success: function(data) {
                create_tablee(data.data);
            }
        })
    }

    function searchByDate_good() {
        $.ajax({
            url: 'http://localhost/shop/ImportController/searchGoodReceiptByDate',
            method: 'POST',
            data: {
                startDate: $('#startDate_good').val(),
                endDate: $('#endDate_good').val()
            },
            success: function(data) {
                create_tablee(data.data);
            }
        })

    }



    // $('#modal_detail').modal('show');
    // document.querySelector('input[name="detail_good_id"]').value=data.good_receipt_id.toFixed(2)
    // document.querySelector('input[name="detail_good_date"]').value=data.date_good_receipt.toFixed(2)
    // document.querySelector('input[name="detail_person"]').value=data.employee_name.toFixed(2)
    function detail(id) {
        $.ajax({
            url: "http://localhost/shop/ImportController/getAllDetailGoodById",
            method: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                // total_quantity
                //         total_good
                //         total_product

                document.querySelector('input[name="detail_good_id"]').value = data.data_good.good_receipt_id
                document.querySelector('input[name="detail_good_date"]').value = data.data_good.date_good_receipt
                document.querySelector('input[name="detail_person"]').value = data.data_good.employee_name

                var totalValue = data.data_good.total;
                var formattedTotal = totalValue.toLocaleString('vi-VN');
                var totalWithUnits = formattedTotal + " VND";
                document.getElementById("total_quantity").innerText = data.data_good.quantity_sum;
                document.getElementById("total_good").innerText = totalWithUnits;
                document.getElementById("total_product").innerText = data.data_good.mathang;

                $('#modal_detail').modal('show');
                $('#load_data_detail_good tbody').empty();
                data.data.forEach(item => {
                    $('#load_data_detail_good tbody').append(`
                    <tr>
                        <td>${item.product_id}</td>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price}</td>
                        <td>${item.quantity*item.price}</td>
                    </tr>
                    `)
                })
            }
        })
    }

    function getInvoiceData() {
        const goodId = document.querySelector('input[name="detail_good_id"]').value.trim();
        const goodDate = document.querySelector('input[name="detail_good_date"]').value.trim();
        const person = document.querySelector('input[name="detail_person"]').value.trim();
        console.log(typeof goodDate)
        console.log(typeof goodId)
        console.log(typeof person)


        // Lặp qua các dòng trong bảng để lấy thông tin sản phẩm
        const products = [];
        const tableBody = document.getElementById('load_data_detail_good').getElementsByTagName('tbody')[0];
        const rows = tableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const product = {
                productId: rows[i].cells[0].textContent,
                productName: rows[i].cells[1].textContent,
                quantity: rows[i].cells[2].textContent,
                price: rows[i].cells[3].textContent,
                total: rows[i].cells[4].textContent,
            };
            products.push(product);
        }

        // Tạo object chứa dữ liệu hóa đơn
        const invoiceData = {
            goodId,
            goodDate,
            person,
            products,
            totalQuantity: document.getElementById('total_quantity').textContent,
            totalPrice: document.getElementById('total_good').textContent,
            total_product: document.getElementById('total_product').textContent,
        };
        return invoiceData;

    }

    function exportToPDF() {
        // Lấy dữ liệu hóa đơn
        const invoiceData = getInvoiceData();

        // Tạo một đối tượng jsPDF
        const doc = new jsPDF();

        // Định dạng tiêu đề
        doc.setFontSize(18);
        doc.text('Hóa đơn', 105, 15, null, null, 'center');

        // Định dạng nội dung hóa đơn
        let startY = 30;
        let currentY = startY; // Biến lưu trữ vị trí y hiện tại của văn bản
        const lineHeight = 10; // Độ cao của mỗi dòng văn bản

        doc.setFontSize(12);

        doc.text(`Mã Hóa Đơn : ${invoiceData.goodId}`, 15, currentY);
        currentY += lineHeight; // Cập nhật vị trí y
        doc.text(`Người Nhập Hàng: ${invoiceData.person}`, 15, currentY);
        currentY += lineHeight; // Cập nhật vị trí y
        doc.text(`Ngày Nhập: ${invoiceData.goodDate}`, 15, currentY);
        currentY += lineHeight * 2; // Cập nhật vị trí y và tăng khoảng cách giữa các dòng

        // Tạo bảng sản phẩm
        const tableColumn = ["Mã sản phẩm", "Tên sản phẩm", "Số lượng", "Giá", "Thành tiền"];
        const tableRows = [];
        invoiceData.products.forEach(product => {
            const productData = [product.productId, product.productName, product.quantity, product.price, product.total];
            tableRows.push(productData);
        });

        // Thêm bảng vào tài liệu PDF
        doc.autoTable({
            head: [tableColumn],
            body: tableRows,
            startY: currentY // Sử dụng vị trí y hiện tại của văn bản làm vị trí bắt đầu của bảng
        });
        currentY = doc.autoTable.previous.finalY + lineHeight; // Cập nhật vị trí y

        // Hiển thị tổng kết
        doc.text(`Tổng số sản phẩm: ${invoiceData.total_product}`, 15, currentY);
        currentY += lineHeight; // Cập nhật vị trí y
        doc.text(`Tổng số lượng: ${invoiceData.totalQuantity}`, 15, currentY);
        currentY += lineHeight; // Cập nhật vị trí y
        doc.text(`Tổng giá: ${invoiceData.totalPrice}`, 15, currentY);

        // Xuất file PDF
        doc.save('hoa_don.pdf');
    }
</script>