function loadAdmin() {
  var role_id = document.getElementById("role_id").value;

  $.ajax({
    url: `http://localhost/shop/authenticate/getPermissions?role_id=${role_id}`,
    type: "POST",
    data: {
      role_id: role_id,
    },
    dataType: "json",
    success: function (permissionData) {
      var taskNamesUser = [];
      for (var i = 0; i < permissionData.listPermission.length; i++) {
        taskNamesUser.push(permissionData.listPermission[i].task_name);
      }
      // console.log(taskNamesUser);
      loadPermissionsFromDatabase(taskNamesUser);
    },
    error: function (error) {
      console.error("Lỗi khi lấy danh sách chức năng:", error);
      alert("An error occurred while fetching permissions.");
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
        data.listPermission.forEach(function (item) {
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

function handleTabClick(event) {
  // Xóa lớp được chọn từ tất cả các tab
  var allTabs = document.querySelectorAll(".sidebar-link");
  allTabs.forEach(function(tab) {
    tab.classList.remove("active");
  });

  // Thêm lớp được chọn vào tab được click
  event.currentTarget.classList.add("active");
}

function loadNavigationBasedOnPermissions(taskNamesUser, allTaskNames) {
  // Lấy thẻ nav
  var sidebarNav = document.querySelector(".sidebar-nav");

  // Xóa nội dung navigation hiện tại
  sidebarNav.innerHTML = "";

  // Đường dẫn cơ sở
  var baseLink = "http://localhost/shop/admin/";

  // Custom CSS for sidebar navigation
  var css = `
  .sidebar-nav {
    padding: 20px; /* Adjust padding as needed */
  }
  
  .sidebar-item {
    margin-bottom: 10px; /* Adjust margin as needed */
    list-style-type: none; /* Remove the list item bullet */
  }
  
  .sidebar-link {
    display: flex; /* Display icon and text in a row */
    align-items: center; /* Center vertically */
    padding: 10px 20px; /* Adjust padding as needed */
    color: #333; /* Sidebar link color */
    text-decoration: none;
    transition: background-color 0.3s ease;
    white-space: nowrap; /* Ensure text stays on a single line */
  }
  
  .sidebar-link:hover {
    background-color: #f0f0f0; /* Sidebar link hover background color */
  }
  
  .sidebar-link span {
    margin-right: 10px; /* Adjust margin as needed */
  }
  
  .hide-menu {
    display: inline-block;
  }

  .sidebar-link.active {
    font-weight: bold; /* Tô đậm tab */
    color: #000; /* Màu chữ tương ứng */
    background-color: #f0f0f0; /* Màu nền */
  }
  `;

  // Create a style element and add CSS
  var style = document.createElement("style");
  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    style.appendChild(document.createTextNode(css));
  }
  document.getElementsByTagName("head")[0].appendChild(style);

  // Thêm trang chủ vào đầu danh sách navigation
  var homeNavItem = document.createElement("li");
  homeNavItem.classList.add("sidebar-item");
  var homeNavLink = document.createElement("span");
  homeNavLink.classList.add("sidebar-link");
  homeNavLink.innerHTML = `
  <span>
    <i class="ti ti-home"></i>
  </span>
  <span class="hide-menu">Home</span>
`;
  homeNavLink.addEventListener("click", handleTabClick); // Thêm sự kiện click
  homeNavItem.appendChild(homeNavLink);
  sidebarNav.appendChild(homeNavItem);

  // Duyệt qua danh sách tất cả các tên nhiệm vụ
  allTaskNames.forEach(function(taskName) {
    // Kiểm tra xem tên nhiệm vụ có trong danh sách của người dùng không
    if (taskNamesUser.includes(taskName)) {
      // Nếu có, thêm mục navigation tương ứng
      var navItem = document.createElement("li");
      navItem.classList.add("sidebar-item");
      var navLink = document.createElement("a");
      navLink.classList.add("sidebar-link");

      // Lấy từ đầu tiên của task name
      var formattedTaskName = taskName.split(" ")[0].toLowerCase(); // Chuyển thành chữ thường

      navLink.href = baseLink + formattedTaskName;

      // Thêm nội dung và các thuộc tính khác cho liên kết
      navLink.setAttribute("aria-expanded", "false");
      navLink.innerHTML = `
      <span>
      <i class="bi bi-arrows-move"></i>
      </span>
      <span class="hide-menu">${taskName}</span>
    `;

      // Thêm sự kiện click
      navLink.addEventListener("click", handleTabClick);

      // Thêm liên kết vào mục navigation
      navItem.appendChild(navLink);
      sidebarNav.appendChild(navItem);
    }
  });

  // Thêm mục "Đăng xuất" vào cuối danh sách navigation
  var logoutNavItem = document.createElement("li");
  logoutNavItem.classList.add("sidebar-item");
  var logoutNavLink = document.createElement("a");
  logoutNavLink.classList.add("sidebar-link");
  logoutNavLink.href = "http://localhost/shop/authenticate/logout";
  logoutNavLink.innerHTML = `
  <span>
    <i class="bi bi-box-arrow-left"></i>
  </span>
  <span class="hide-menu">Đăng xuất</span>
`;
  logoutNavLink.addEventListener("click", handleTabClick); // Thêm sự kiện click
  logoutNavItem.appendChild(logoutNavLink);
  sidebarNav.appendChild(logoutNavItem);
}

loadAdmin();
