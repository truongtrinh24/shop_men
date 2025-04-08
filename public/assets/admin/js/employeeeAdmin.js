let currentPageEmployee = 1;
let total_pageEmployee = 0;

$(function () {
    load_dataEmployee(currentPageEmployee);
});



function load_next_pageEmployee() {
    currentPageEmployee++;
    if (currentPageEmployee > total_pageEmployee) {
        currentPageEmployee = total_pageEmployee;
    }
    if ($('#search-employee-input').val() !== '') {
        loadEmployeeSearch(currentPageEmployee); // Truyền trang cho tìm kiếm
    } else {
        load_dataEmployee(currentPageEmployee);
    }
}

function load_prev_pageEmployee() {
    currentPageEmployee--;
    if (currentPageEmployee < 1) {
        currentPageEmployee = 1;
    }
    if ($('#search-employee-input').val() !== '') {
        loadEmployeeSearch(currentPageEmployee); // Truyền trang cho tìm kiếm
    } else {
        load_dataEmployee(currentPageEmployee);
    }
}


function create_tableEmployee(data) {
    $('#dataEmployee').empty();

    if (Array.isArray(data)) {
        data.forEach(item => {
            $('#dataEmployee').append(`
                <tr>
                    <td>${item.employee_id}</id>
                    <td>${item.employee_name}</td>
                    <td>${item.employee_phone}</td>
                    <td>${item.employee_address}</td>
                    <td>${item.employee_email}</td>
                    <td>
                        <div>
                            <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formDetailEmployee' onclick='openDetailEmployeeModal("${item.employee_id}")'>Detail</button>
                            <button class='btn btn-primary me-1 mb-3 w-100' data-bs-toggle='modal' data-bs-target='#formUpdateEmployee' onclick='openUpdateEmployeeModal("${item.employee_id}")'>Update</button>
                        </div>
                    </td>

                </tr>
            
            `)
        })
    }
}
function load_dataEmployee(page) {
    $.ajax({
        url: `http://localhost/shop/Employee_Admin/loadDataEmployee?page=${page}`,
        method: "GET",
        success: function (data) {
            console.log(data);
            create_tableEmployee(data.data);
            total_pageEmployee = data.total_page;
            console.log(total_pageEmployee);
            updatePanigationEmployee();
        }
    })
}

function updatePanigationEmployee() {
    $('#current_pageEmployee').text(currentPageEmployee);
    $('#total_pagesEmployee').text(total_pageEmployee);
    $('#pagination').empty();
    for (let i = 1; i <= total_pageEmployee; i++) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="load_dataEmployee(${i})">${i}</a></li>`);
    }
}

function openDetailEmployeeModal(employee_Id) {
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Employee_Admin/detailEmployeeId?employee_id=${employee_Id}`,
        success: function (data) {
            console.log(data.data);
            var html = `
                <div class="row mt-3">  
                    <div class="col-6">
                        <label for="employee_id" class="form-label">EmployeeID:</label>
                        <input type="text" class="form-control" id="employee_id" value="${data.data.employee_id}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="employee_name" class="form-label">Employee's Name</label>
                        <input type="text" class="form-control" id="employee_name" value="${data.data.employee_name}" readonly>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <label for="employee_phone" class="form-label">Employee's Phone</label>
                        <input type="text" class="form-control" id="employee_phone" value="${data.data.employee_phone}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="employee_address" class="form-label">Employee's Address</label>
                        <input type="text" class="form-control" id="employee_address" value="${data.data.employee_address}" readonly>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-6">
                        <label for="employee_email" class="form-label">Employee's Email</label>
                        <input type="text" class="form-control" id="employee_email" value="${data.data.employee_email}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="employee_password" class="form-label">Employee's Password</label>
                        <input type="text" class="form-control" id="employee_email" value="${data.data.password}" readonly>
                    </div>
                </div>
            `;
            $('#employeeDetail').html(html);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function openUpdateEmployeeModal(employee_Id) {
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Employee_Admin/detailEmployeeId?employee_id=${employee_Id}`,
        success: function (data) {
            var html = `
                <div class="row mt-3">  
                    <div class="col-6">
                        <label for="employee_idUpdate" class="form-label">EmployeeID:</label>
                        <input type="text" class="form-control" id="employee_idUpdate" value="${data.data.employee_id}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="employee_nameUpdate" class="form-label">Employee's Name</label>
                        <input type="text" class="form-control" id="employee_nameUpdate" value="${data.data.employee_name}" required>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <label for="employee_phoneUpdate" class="form-label">Employee's Phone</label>
                        <input type="text" class="form-control" id="employee_phoneUpdate" value="${data.data.employee_phone}" required>
                    </div>
                    <div class="col-6">
                        <label for="employee_addressUpdate" class="form-label">Employee's Address</label>
                        <input type="text" class="form-control" id="employee_addressUpdate" value="${data.data.employee_address}" required>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <label for="employee_emailUpdate" class="form-label">Employee's Email</label>
                        <input type="email" class="form-control" id="employee_emailUpdate" value="${data.data.employee_email}" required>
                    </div>
                </div>
            `;
            $('#employeeUpdate').html(html);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function updateEmployee() {
    var employee_id = $('#employee_idUpdate').val();
    var employee_name = $('#employee_nameUpdate').val();
    var employee_phone = $('#employee_phoneUpdate').val();
    var employee_address = $('#employee_addressUpdate').val();
    var employee_email = $('#employee_emailUpdate').val();

    if (!employee_name) {
        alert("Tên không được để trống");
        return;
    } else if (!employee_address) {
        alert("Địa chỉ không được để trống");
        return;
    } else if (!phone_regex.test(employee_phone)) {
        alert("Số điện thoại phải 10 số và bắt đầu bằng số 0");
        return;
    } else if (!employee_email) {
        alert("Địa chỉ Email không được để trống");
        return;
    } else if (!email_regex.test(employee_email)) {
        alert("Địa chỉ Email không hợp lệ");
        return;
    }

    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Employee_Admin/updateEmployee`,
        data: {
            employee_id: employee_id,
            employee_name: employee_name,
            employee_phone: employee_phone,
            employee_address: employee_address,
            employee_email: employee_email
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert("Update Employee Successfully");
                location.reload();
            }
            else {
                alert(data.message);
            }
        }
    })
}

function searchEmployee() {
    var key = document.getElementById('search-employee-input').value;
    if (key.trim() === '') {
        load_dataEmployee(currentPageEmployee); // Load lại dữ liệu khi input search trống
        updatePanigationEmployee();
    } else {
        $.ajax({
            type: 'POST',
            url: 'http://localhost/shop/Employee_Admin/searchEmployee',
            data: { keyword: key, page: currentPageEmployee },
            success: function (response) {
                create_tableEmployee(response.data);
                currentPageEmployee = response.currentPageEmployee;
                total_pageEmployee = response.total_pageEmployee;
                updatePaginationEmployeeSearch(response.currentPageEmployee, response.total_pageEmployee);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}

function loadEmployeeSearch(page) {
    var key = document.getElementById('search-employee-input').value.trim(); // Sử dụng trim để loại bỏ khoảng trắng thừa

    if (key === "") {
        load_dataEmployee(currentPageEmployee); // Load lại dữ liệu khi input search trống
        updatePagination();
    } else {
        $.ajax({
            url: `http://localhost/shop/Employee_Admin/searchEmployee`,
            method: "POST",
            data: { keyword: key, page: currentPageEmployee },
            success: function (data) {
                if (data != "No Employee found") {
                    create_tableEmployee(data.data);
                    updatePaginationEmployeeSearch(data.currentPageEmployee, data.total_pageEmployee); // Truyền số trang cần cập nhật
                } else {
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}

function updatePaginationEmployeeSearch(currentPageEmployee, total_pageEmployee) {
    $('#current_pageEmployee').text(currentPageEmployee);
    $('#total_pagesEmployee').text(total_pageEmployee);
    $('#pagination').empty();

    if (total_pageEmployee > 1) {
        for (let i = 1; i <= total_pageEmployee; i++) {
            $('#pagination').append(`<li class="page-item"><a class="page-link" onclick="loadEmployeeSearch(${i})">${i}</a></li>`);
        }
    } else {
        $('#pagination').append(`<li class="page-item active"><a class="page-link">${currentPageEmployee}</a></li>`);
    }
}

function insertEmployee() {
    var employee_name = $('#employee_nameInsert').val();
    var employee_address = $('#employee_addressInsert').val();
    var employee_email = $('#employee_emailInsert').val();
    var employee_phone = $('#employee_phoneInsert').val();

    // Regular expression for email validation
    var email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Regular expression for phone number validation (10 digits starting with 0)
    var phone_regex = /^0\d{9}$/;

    if (!employee_name) {
        alert("Tên không được để trống");
        return;
    } else if (!employee_address) {
        alert("Địa chỉ không được để trống");
        return;
    } else if (!phone_regex.test(employee_phone)) {
        alert("Số điện thoại phải 10 số và bắt đầu bằng số 0");
        return;
    } else if (!employee_email) {
        alert("Địa chỉ Email không được để trống");
        return;
    } else if (!email_regex.test(employee_email)) {
        alert("Địa chỉ Email không hợp lệ");
        return;
    }

    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Employee_Admin/insertEmployee`,
        data: {
            employee_name: employee_name,
            employee_phone: employee_phone,
            employee_address: employee_address,
            employee_email: employee_email
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert("Insert Employee Successfully");
                location.reload();
            } else {
                alert(data.message);
            }
        }
    });
}


function openInsertEmployeeModal() {
    var html = `
        <div class="row mt-3">  
            <div class="col-12">
                <label for="employee_nameInsert" class="form-label">Employee's Name</label>
                <input type="text" class="form-control" id="employee_nameInsert" value="" required>
            </div>
            <div class="col-12">
                <label for="employee_emailInsert" class="form-label">Employee's Email</label>
                <input type="email" class="form-control" id="employee_emailInsert" value="" required>
            </div>
            <div class="col-12">
                <label for="employee_phoneInsert" class="form-label">Employee's Phone</label>
                <input type="text" class="form-control" id="employee_phoneInsert" value="" required>
            </div>
            <div class="col-12">
                <label for="employee_addressInsert" class="form-label">Employee's Address</label>
                <input type="text" class="form-control" id="employee_addressInsert" value="" required>
            </div>
        </div>
    `;
    $('#employeeInsert').html(html);
}



