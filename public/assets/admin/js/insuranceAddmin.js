$(function () {
    load_dataInsurance(currentPageInsurance)
});

function load_dataInsurance(page) {
    $.ajax({
        url: `http://localhost/shop/Insurance_Admin/loadDataInsurance?page=${page}`,
        method: "GET",
        success: function (data) {
            create_tableInsurance(data.data);
            total_pageInsurance = data.total_page;
            updatePaginationInsurance();
        }
    })
}

function updatePaginationInsurance() {
    $('#current_pageInsurance').text(currentPageInsurance);
    $('#total_pagesInsurance').text(total_pageInsurance);
    $('#pagination').empty();
    for (let i = 1; i <= total_pageInsurance; i++) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="load_data(${i})">${i}</a></li>`);
    }
}


function create_tableInsurance(data) {
    $('#contentDataInsurance').empty();

    if (Array.isArray(data)) {
        data.forEach(item => {
            let statusText = "";
            let optionValue = "";
            if (item.status_insurance === "1") {
                statusText = "Đã xử lý";
                optionValue = "1";
            } else {
                statusText = "Đang xử lý";
                optionValue = "0";
            }
            $('#contentDataInsurance').append(`
                <tr>
                    <td>${item.insurance_id}</td>
                    <td>${item.order_id}</td>
                    <td>${item.customer_name}</td>
                    <td>${item.product_seri}</td>
                    <td>${item.equipment_replacement}</td>
                    <td>
                        <select class="form-control" id="status_insurance_${item.insurance_id}" onchange="updateInsuranceStatus(${item.insurance_id}, this.value)" style="background-color: rgb(0, 191, 255); color: white; text-align: center; cursor:pointer;">
                            <option style="cursor:pointer;" value="${optionValue === "0" ? "0" : "1"}" >${statusText}</option>
                            <option style="cursor:pointer;" value="${optionValue === "0" ? "1" : "0"}" >${statusText === 'Đã xử lý' ? 'Đang xử lý' : 'Đã xử lý'}</option>
                        </select>
                    </td>
                    <td class="d-flex justify-content-center">
                        <div class="text-center">
                            <button class='btn btn-primary w-100' data-bs-toggle='modal' data-bs-target='#formDetailInsuranceByID' onclick='openDetailInsuranceIDModal(${item.insurance_id})'>Detail</button>
                        </div>
                    </td>
                </tr>
            `);
        });
    }
}


let currentPageInsurance = 1;
let total_pageInsurance = 0;

function load_next_pageInsurance() {
    currentPageInsurance++;
    if (currentPageInsurance > total_pageInsurance) {
        currentPageInsurance = total_pageInsurance;
    }
    load_dataInsurance(currentPageInsurance);
}

function load_prev_pageInsurance() {
    currentPageInsurance--;
    if (currentPageInsurance < 1) {
        currentPageInsurance = 1;
    }
    load_dataInsurance(currentPageInsurance);
}
function updateInsuranceStatus(insurance_id, new_status) {
    $.ajax({
        type: "POST",
        url: "http://localhost/shop/Insurance_Admin/updateInsuranceStatus",
        data: { insurance_id: insurance_id, new_status: new_status },
        success: function (response) {
            // Xử lý kết quả nếu cần
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function openDetailInsuranceIDModal(insurance_id)
{
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Insurance_Admin/detailInsurance?InsuranceID=${'insurance_id'}`,
        data: { insurance_id: insurance_id },
        success: function(data)
        {
            let statusText = "";
            console.log(data.status_insurance);
            if (data.status_insurance === 1) {
                statusText = "Đã xử lý";
            } else {
                statusText = "Đang xử lý";
            }
            console.log(statusText);
            var html = `
                        <img id="productImage" src="../public/assets/clients/img/${data.product_image}" alt="Product Image" style="max-width: 150px; justify-content: center; display: flex; margin: 0 auto;">
                <div class="row mt-3">
                    <div class="col-6">
                        <label for="customer_name" class="form-label">Customer's Name:</label>
                        <input type="text" class="form-control" id="customer_name" value="${data.customer_name}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="order_id" class="form-label">Order's ID:</label>
                        <input type="text" class="form-control" id="order_id" value="${data.order_id}" disabled>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <label for="employee_name" class="form-label">Customer's Name:</label>
                        <input type="text" class="form-control" id="employee_name" value="${data.employee_name}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="product_seri" class="form-label">Product Seri:</label>
                        <input type="text" class="form-control" id="product_seri" value="${data.product_seri}" disabled>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <label for="equipment_replacement" class="form-label">Equipment Replacement:</label>
                        <input type="text" class="form-control" id="equipment_replacement" value="${data.equipment_replacement}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="status_insurance" class="form-label">Status Insurance:</label>
                        <input type="text" class="form-control" id="status_insurance" value="${statusText}" disabled>
                    </div>
                </div>
                
            `;
            $('#insuranceID').val(insurance_id);
            $('#insuranceDetail').html(html);
        }
    })
}


function openDetailInsuranceModal() {
    var key = document.getElementById('search-insurance-input').value;
    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Insurance_Admin/searchProductIDforInsurance`,
        data: { product_seri: key },
        success: function (data) {
            if (data.data != false) {
                var html = `
            <img id="productImage" src="../public/assets/clients/img/${data.data.product_image}" alt="Product Image" style="max-width: 150px; justify-content: center; display: flex; margin: 0 auto;">
            <p style="margin:10px 0 10px 0;"><strong>Product Name:</strong> <span id="productName">${data.data.product_name}</span></p>
            <div class="mb-3 d-flex">
                    <label for="customer_id" class="form-label">Customer ID:</label>
                    <input type="text" class="form-control" id="customer_id" value="${data.data.customer_id}" disabled>
            </div>
            <div class="mb-3 d-flex">
                    <label for="order_id" class="form-label">Order ID:</label>
                    <input type="text" class="form-control" id="order_id" value="${data.data.order_id}" disabled>
            </div>
            <div class="mb-3 d-flex">
                <label for="employee_id" class="form-label">Employee ID:</label>
                <select class="form-control" id="employee_id"></select>
            </div>
            <p style="margin:10px 0 10px 0;"><strong>Time to Buy:</strong> <span id="create_at">${data.data.date_buy}</span></p>
            <p style="margin:10px 0 10px 0;"><strong>Year Produce:</strong> <span id="yearProduce">${data.data.product_year_produce}</span></p>
            <p style="margin:10px 0 10px 0;"><strong>Time Insurance:</strong> <span id="timeInsurance">${data.data.product_time_insurance}</span> months</p>
            <p style="margin:10px 0 10px 0; color: red"><strong>Status Product:</strong> <span>${data.data.status_product}</span></p>

            <div class="mb-3">
                    <label for="equipmentReplacementInsert" class="form-label" id="labelequipement">Equipment Replacement:</label>
                    <input type="text" class="form-control" id="equipmentReplacementInsert" value="" required>
            </div>
            `;
                $('#product_seri').val(key);
                $('#detailProductforInsurance').html(html);
                getEmployeeList();
                
                // Check if status is 'Hết bảo hành', then hide the 'Create' button
                if (data.data.status_product === 'Hết bảo hành') {
                    $('#createInsuranceBtn').hide();
                    $('#equipmentReplacementInsert').hide();
                    $('#labelequipement').hide();
                } else {
                    $('#createInsuranceBtn').show();
                    $('#equipmentReplacementInsert').show();
                }
                
                $('#formDetailProductforInsurance').modal('show'); // Hiển thị modal
            }
            else
            {
                alert("Không tìm thấy mã thiết bị")
            }
        },
        error: function (xhr, status, error) {
            alert("Không tìm thấy mã thiết bị")
        }
    })

}

function getEmployeeList() {
    $.ajax({
        type: "GET",
        url: "http://localhost/shop/Insurance_Admin/getEmployeeList",
        success: function (data) {
            var options = '';
            if (data && data.length > 0) {
                data.forEach(function (employee) {
                    options += `<option value="${employee.employee_id}">${employee.employee_name}</option>`;
                });
            } else {
                options = '<option value="">No employees found</option>';
            }
            $('#employee_id').html(options);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function createInsurance() {
    var product_seri = $('#product_seri').val();
    var customer_id = $('#customer_id').val();
    var order_id = $('#order_id').val();
    var employee_id = $('#employee_id').val();
    var equipment_replacement = $('#equipmentReplacementInsert').val();

    if(!equipment_replacement)
        {
            alert("KHÔNG ĐƯỢC BỎ TRỐNG THIẾT BỊ THAY THẾ");
            return;
        }
    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Insurance_Admin/insertInsurance`,
        data: {
            product_seri: product_seri,
            customer_id: customer_id,
            order_id: order_id,
            employee_id: employee_id,
            equipment_replacement: equipment_replacement,
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

