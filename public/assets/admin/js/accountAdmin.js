

function openUpdateModal(accountId) {
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/account/detail?id=${accountId}`,
    success: function (response) {
      var username = response.account.username;
      var roleId = response.account.role_id;
      console.log(username);

      // Đặt giá trị cho combobox username
      $("#userSelectUpdate").val(username);

      // Đặt giá trị cho combobox role_id
      $("#roleSelectUpdate").val(roleId);

      // Đặt giá trị cho input password
      $("#password").val(response.account.password);

      // Đặt giá trị cho input accountId
      $("#accountId").val(accountId);
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
function deleteProduct(accountId) {
  if (confirm("Bạn có chắc chắn muốn xóa tài khoản này không?")) {
    $.ajax({
      type: "POST", // Hoặc có thể sử dụng phương thức DELETE tùy thuộc vào cách bạn cấu hình server
      url: `http://localhost/shop/admin/account/delete`, // URL để gửi yêu cầu xóa
      data: {
        account_id: accountId,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          alert("Tài khoản đã được xóa thành công");
          location.reload();
        } else {
          alert(data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Đã xảy ra lỗi khi xóa sản phẩm:", error);
      },
    });
  }
}

function updateAccount() {
  var accountId = $("#accountId").val();
  var username = $("#userSelectUpdate").val();
  var password = $("#password").val();
  var roleId = $("#roleSelectUpdate").val();

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

  $.ajax({
    type: "POST",
    url: `http://localhost/shop/admin/account/update`,
    data: {
      account_id: accountId,
      username: username,
      password: password,
      role_id: roleId,
    },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status === "success") {
        alert("Account information updated successfully!");
        location.reload()
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
  var keyword = $("#search-account-input").val().trim(); // Lấy từ khóa tìm kiếm và loại bỏ khoảng trắng đầu cuối
  console.log(keyword);

  // Thực hiện tìm kiếm chỉ khi có từ khóa
  if (keyword) {
    // Thực hiện AJAX request để tìm kiếm account
    $.ajax({
      type: "POST",
      url: "http://localhost/shop/admin/account/search",
      data: {
        keyword: keyword,
      },
      success: function (response) {
        // console.log(response);
        if (response.status === "success") {
          console.log(response.account);
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
