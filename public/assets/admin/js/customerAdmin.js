


function openUpdateModal(customerId) {
  console.log(customerId);
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/customer/detail?id=${customerId}`,
    success: function (response) {
      console.log(response);
      var customerId = response.customer.customer_id;
      // console.log(customerId)

      // Đặt giá trị cho input Customer ID
      $("#customerId").val(response.customer.customer_id);

      // Đặt giá trị cho input Customer Name
      $("#customerName").val(response.customer.customer_name);

      // Đặt giá trị cho input Customer Address
      $("#customerAddress").val(response.customer.customer_address);

      // Đặt giá trị cho input Customer Phone
      $("#customerPhone").val(response.customer.customer_phone);

      // Đặt giá trị cho input Customer Email
      $("#customerEmail").val(response.customer.customer_email);
    },
    error: function (xhr, status, error) {
      console.error(
        "An error occurred while retrieving account information: ",
        error
      );
    },
  });
}

// Hàm xác nhận xóa
function deleteCustomer(customerId) {
  if (confirm("Bạn có chắc chắn muốn xóa khách hàng này không?")) {
    $.ajax({
      type: "POST", // Hoặc có thể sử dụng phương thức DELETE tùy thuộc vào cách bạn cấu hình server
      url: `http://localhost/shop/admin/customer/delete`, // URL để gửi yêu cầu xóa
      data: {
        customer_id: customerId,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == "success") {
          alert("Khách hàng đã được xóa thành công");
          location.reload();
        } else {
          alert(data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Đã xảy ra lỗi khi xóa khách hàng:", error);
      },
    });
  }
}

function updateCustomer() {
  var customerId = $("#customerId").val();
  var customerName = $("#customerName").val();
  var customerAddress = $("#customerAddress").val();
  var customerPhone = $("#customerPhone").val();
  var customerEmail = $("#customerEmail").val();

  console.log(customerId);
  // Kiểm tra nếu username hoặc roleId không được chọn và hiển thị thông báo
  if (!customerName) {
    alert("Vui lòng nhập tên khách hàng.");
    return;
  }
  if (!customerAddress) {
    alert("Vui lòng nhập địa chỉ khách hàng.");
    return;
  }
  if (!customerPhone) {
    alert("Vui lòng nhập số điện thoại khách hàng.");
    return;
  }
  if (!customerEmail) {
    alert("Vui lòng nhập email khách hàng.");
    return;
  }

  $.ajax({
    type: "POST",
    url: `http://localhost/shop/admin/customer/update`,
    data: {
      customer_id: customerId,
      customer_name: customerName,
      customer_address: customerAddress,
      customer_phone: customerPhone,
      customer_email: customerEmail,
    },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status === "success") {
        alert("Customer information updated successfully!");
        location.reload();
        // Nếu cần, thực hiện các hành động phản hồi khác sau khi cập nhật thành công
      } else {
        alert(data.message);
      }
    },
    error: function (xhr, status, error) {
      console.error(
        "An error occurred while updating account information: ",
        error
      );
    },
  });
}

function addAccountNew() {
  // Retrieve values from the input fields
  var username = $("#userSelectAdd").val();
  var password = $("#passwordAdd").val();
  var roleId = $("#roleSelectAdd").val();

  // Kiểm tra nếu username hoặc roleId không được chọn và hiển thị thông báo
  if (username === "" || username === "Chọn username") {
    alert("Vui lòng chọn username.");
    return;
  }

  if (roleId === "" || roleId === "Chọn quyền") {
    alert("Vui lòng chọn quyền.");
    return;
  }

  // Kiểm tra password không được để trống
  if (!password) {
    alert("Vui lòng nhập mật khẩu.");
    return;
  } else if (password.length < 6) {
    alert("Mật khẩu phải có ít nhất 6 ký tự.");
    return;
  }

  // Perform AJAX request to add account
  $.ajax({
    type: "POST",
    url: "http://localhost/shop/admin/account/add", // URL to add account
    data: {
      username: username,
      password: password, // Gửi mật khẩu đã được mã hóa
      role_id: roleId,
    },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status === "success") {
        alert("Account added successfully.");
        // Close the form
        $("#addAccount").modal("hide");
        // Update the table (assuming you have a function to update the table)
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("An error occurred while adding account: ", error);
      alert("Error: Failed to add account. Please try again later.");
    },
  });
}

function searchCustomer() {
  var keyword = $("#search-customer-input").val().trim(); // Lấy từ khóa tìm kiếm và loại bỏ khoảng trắng đầu cuối
  console.log(keyword);

  // Thực hiện tìm kiếm chỉ khi có từ khóa
  if (keyword) {
    $.ajax({
      type: "POST",
      url: "http://localhost/shop/admin/customer/search",
      data: {
        keyword: keyword,
      },
      success: function (response) {
        // console.log(response);
        if (response.status === "success") {
            displayDataAccount(response.data); // Gọi hàm hiển thị dữ liệu khách hàng với dữ liệu từ kết quả tìm kiếm
        } else {
          alert(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("An error occurred while searching account: ", error);
        alert("Error: Failed to search account. Please try again later.");
      },
    });
  } else {
    // Hiển thị thông báo khi từ khóa tìm kiếm không được nhập
    alert("Please enter a keyword to search.");
  }
}
