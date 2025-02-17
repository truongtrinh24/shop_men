// function signIn() {
//     event.preventDefault();
//     var username = $("#username").val();
//     var password = $("#password").val();

//     $.ajax({
//         url: "http://localhost/shop/authenticate/processSignin",
//         type: "POST",
//         data: {
//             username: username,
//             password: password
//         },
//         dataType: "json",
//         success: function(data) {
//             if (data.success == true) {
//                 toastr.success('Đăng nhập thành công');

//                 setTimeout(function() {
//                     window.location.href = data.redirect_url;
//                 }, 1000);

//             } else {
//                 if(data.error_message != null) {
//                     toastr.warning(data.error_message);
//                 }

//                 if(data.error_message_username != null ) {
//                     $('.error-message-username').html(data.error_message_username);
//                 }else {
//                     $('.error-message-username').html('');
//                 }

//                 if(data.error_message_password != null ) {
//                     $('.error-message-password').html(data.error_message_password);
//                 }else {
//                     $('.error-message-password').html('');
//                 }

//             }
//         },
//         error: function(error) {
//             console.error("Lỗi khi gửi yêu cầu đăng nhập:", error);
//             alert("An error occurred while processing the request.");
//         }
//     });
// }
function signIn() {
  event.preventDefault(); 
  var username = $("#username").val();
  var password = $("#password").val();

  $.ajax({
    url: "http://localhost/shop/authenticate/processSignin",
    type: "POST",
    data: {
      username: username,
      password: password,
    },
    dataType: "json",
    success: function (data) {
      if (data.success == true) {

     
        toastr.success("Đăng nhập thành công");

        // Lấy role_id từ dữ liệu nhận được
        var roleId = data.role_id;

        // Gửi yêu cầu để lấy danh sách các chức năng tương ứng với role_id
        $.ajax({
          url: `http://localhost/shop/authenticate/getPermissions?role_id=${roleId}`,
          type: "POST",
          data: {
            roleId: roleId,
          },
          dataType: "json",
          success: function (permissionData) {
            var taskNamesUser = [];
            for (var i = 0; i < permissionData.listPermission.length; i++) {
              taskNamesUser.push(permissionData.listPermission[i].task_name);
            }
            loadPermissionsFromDatabase(taskNamesUser);
          },
          error: function (error) {
            console.error("Lỗi khi lấy danh sách chức năng:", error);
            alert("An error occurred while fetching permissions.");
          },
        });

        setTimeout(function () {
          window.location.href = data.redirect_url;
        }, 1000);
      } else {
        if (data.error_message != null) {
          toastr.warning(data.error_message);
        }

        if (data.error_message_username != null) {
          $(".error-message-username").html(data.error_message_username);
        } else {
          $(".error-message-username").html("");
        }

        if (data.error_message_password != null) {
          $(".error-message-password").html(data.error_message_password);
        } else {
          $(".error-message-password").html("");
        }
      }
    },
    error: function (error) {
      console.error("Lỗi khi gửi yêu cầu đăng nhập:", error);
      alert("An error occurred while processing the request.");
    },
  });
}

function loadPermissionsFromDatabase(taskNamesUser) {
  $.ajax({
    url: "http://localhost/shop/authenticate/getAllPermissions",
    type: "GET",
    dataType: "json",
    success: function (data) {
      // Sau khi nhận được dữ liệu, cập nhật navigationPermissions
      if (data) {
        var allTaskNames = [];
        data.listPermission.forEach(function(item) {
          allTaskNames.push(item.task_name);
        });
        loadNavigationBasedOnPermissions(taskNamesUser, allTaskNames);
      }
    },
    error: function (error) {
      console.error("Lỗi khi lấy danh sách chức năng từ cơ sở dữ liệu:", error);
      alert("An error occurred while fetching permissions.");
    },
  });
}
function loadNavigationBasedOnPermissions(taskNamesUser, allTaskNames) {
  // Lấy thẻ nav
  var sidebarNav = document.querySelector(".sidebar-nav");

  // Xóa nội dung navigation hiện tại
  sidebarNav.innerHTML = "";

  // Duyệt qua danh sách tất cả các tên nhiệm vụ
  allTaskNames.forEach(function(taskName) {
      // Kiểm tra xem tên nhiệm vụ có trong danh sách của người dùng không
      if (taskNamesUser.includes(taskName)) {
          // Nếu có, thêm mục navigation tương ứng
          var navItem = document.createElement("li");
          navItem.classList.add("sidebar-item");
          var navLink = document.createElement("a");
          navLink.classList.add("sidebar-link");
          navLink.href = getLinkByNavItemText(taskName); // Bạn cần cung cấp hàm này để lấy đường link tương ứng với nhiệm vụ
          navLink.setAttribute("aria-expanded", "false");
          // Thêm icon nếu cần
          var icon = getIconByNavItemText(taskName); // Hàm này cần được thay thế bằng hàm thực sự để lấy icon
          if (icon) {
              navLink.innerHTML = `
                  <span>
                      <i class="${icon}"></i>
                  </span>
                  <span class="hide-menu">${taskName}</span>
              `;
          } else {
              navLink.textContent = taskName;
          }
          navItem.appendChild(navLink);
          sidebarNav.appendChild(navItem);
      }
  });
}
