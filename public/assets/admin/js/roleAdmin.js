function showListDetailRole(roleId) {
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/role/detail?id=${roleId}`,
    success: function (response) {
      if (response && response.data && response.data.length > 0) {
        var data = response.data;
        var roleName = data[0].role_name;

        // Đặt giá trị cho trường Role Name trong form
        $("#roleName").val(roleName);

        var taskNames = []; // Mảng lưu trữ các task_name từ response
        data.forEach(function (task) {
          taskNames.push(task.task_name);
        });

        // Hiển thị các checkbox cho các task
        var taskCheckboxesDiv = $("#taskCheckboxes");
        taskCheckboxesDiv.empty(); // Xóa bỏ các checkbox cũ trước khi thêm mới

        taskNames.forEach(function (taskName) {
          var isChecked = taskNames.includes(taskName) ? "checked" : "";
          var checkboxHtml = `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="${taskName}" id="${taskName}" name="taskName" ${isChecked} disabled>
              <label class="form-check-label" for="${taskName}">
                ${taskName}
              </label>
            </div>
          `;
          taskCheckboxesDiv.append(checkboxHtml);
        });
      } else {
        console.error("No valid data found for this role.");
      }
      $("#detailRole").modal("show");
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}

function openUpdateModel(roleId) {
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/role/detail?id=${roleId}`,
    success: function (response) {
      // console.log(response);
      if (response && response.data && response.data.length > 0) {
        var data = response.data;
        var roleName = data[0].role_name;
        // console.log(data)
        $("#roleId").val(roleId);
        $("#roleNameUpdate").val(roleName);

        // Lấy danh sách tất cả các task từ cơ sở dữ liệu
        $.ajax({
          type: "GET",
          url: "http://localhost/shop/admin/role/getAllTask",
          success: function (allTasksResponse) {
            // console.log(allTasksResponse)
            if (allTasksResponse && allTasksResponse.data) {
              var allTasks = allTasksResponse.data;
              // console.log(allTasks);

              var taskCheckboxesDiv = $("#taskCheckboxesUpdate");
              taskCheckboxesDiv.empty();

              allTasks.forEach(function (task) {
                var isChecked = data.some(function (roleTask) {
                  // console.log(roleTask)
                  return roleTask.task_id == task.task_id;
                });

                var checkboxHtml = `
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="${
                      task.task_id
                    }" id="${task.task_id}" name="taskName" ${
                  isChecked ? "checked" : ""
                }>
                    <label class="form-check-label" for="${task.task_id}">
                      ${task.task_id} - ${task.task_name}
                    </label>
                  </div>
                `;
                taskCheckboxesDiv.append(checkboxHtml);
              });
            } else {
              console.error("No valid data found for all tasks.");
            }
          },
          error: function (xhr, status, error) {
            console.error("Error fetching all tasks:", error);
          },
        });
      } else {
        console.error("No valid data found for this role.");
      }
      $("#updateRoleModel").modal("show");
    },
    error: function (xhr, status, error) {
      console.error("Error fetching role details:", error);
    },
  });
}

function updateRole() {
  var roleId = $("#roleId").val();
  var roleName = $("#roleNameUpdate").val();
  console.log(roleName)
  var selectedTasks = [];

  $("#taskCheckboxesUpdate input:checked").each(function () {
    selectedTasks.push($(this).val());
  });

  var selectedTasksWithId = [];

  if(!roleName){
    alert("Vui lòng nhập tên quyền");
    return;
  }

  $("#taskCheckboxesUpdate input:checked").each(function () {
    var task_id = $(this).attr("id");
    selectedTasksWithId.push({ task_id: task_id, task_name: $(this).val() });
  });

  if (selectedTasksWithId.length === 0) {
    alert("Vui lòng chọn ít nhất một task");
    return;
  }
  
  $.ajax({
    type: "POST",
    url: "http://localhost/shop/admin/role/update",
    data: {
      role_id: roleId,
      role_name: roleName,
      tasks: selectedTasksWithId,
    },
    success: function (response) {
      console.log(response);
      if (response.status === "success") {
        alert("Role information updated successfully!");
      } else {
        console.error("Error updating role:", response.message);
        alert(
          "An error occurred while updating the role. Please try again later."
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating role:", xhr.responseText);
      alert(
        "An error occurred while updating the role. Please try again later."
      );
    },
  });
}

//show detail role

$(document).ready(function () {
  $("#roleList tbody tr").click(function () {
    var roleId = $(this).find("td:eq(1)").text();
    console.log(roleId);
    // showListDetailRole(roleId);
  });
});

//show form add  role
function showFormAddRole() {
  $.ajax({
    type: "GET",
    url: "http://localhost/shop/admin/role/getAllTask",
    success: function (allTasksResponse) {
      if (allTasksResponse && allTasksResponse.data) {
        var allTasks = allTasksResponse.data;

        var taskCheckboxesDiv = $("#taskCheckboxesAdd");
        taskCheckboxesDiv.empty();

        allTasks.forEach(function (task) {
          var checkboxHtml = `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="${task.task_id}" id="task_${task.task_id}" name="taskName">
              <label class="form-check-label" for="task_${task.task_id}">
                ${task.task_id} - ${task.task_name}
              </label>
            </div>
          `;
          taskCheckboxesDiv.append(checkboxHtml);
        });
      } else {
        console.error("No valid data found for all tasks.");
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}

//add role

function addRoleNew() {
  var roleName = $("#roleNameAdd").val().trim();
  if (roleName === "") {
    alert("Vui lòng nhập tên vai trò");
    return;
  }

  var selectedTasks = [];
  $("#taskCheckboxesAdd input:checked").each(function () {
    var task_id = $(this).val();
    var task_name = $(this).siblings("label").text().trim().split(" - ")[1];
    selectedTasks.push({ task_id: task_id, task_name: task_name });
  });

  console.log({ roleName, selectedTasks });
  if (selectedTasks.length === 0) {
    alert("Vui lòng chọn ít nhất một task");
    return;
  }
  $.ajax({
    type: "POST",
    url: "http://localhost/shop/admin/role/add",
    data: {
      role_name: roleName,
      tasks: selectedTasks,
    },
    success: function (response) {
      console.log(response);
      if (response.status === "success") {
        alert("Role added successfully!");
        location.reload();
      } else {
        console.error("Error adding role:", response.status);
        alert("Error.");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error adding role:", xhr.responseText);
      alert("An error occurred while adding the role. Please try again later.");
    },
  });
}

//delete role
function deleteRole(roleId) {
  if (confirm("Bạn có chắc chắn muốn xóa quyền này không?")) {
    $.ajax({
      type: "POST", 
      url: `http://localhost/shop/admin/role/delete`, 
      data: {
        role_id: roleId
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          alert("Quyền đã được xóa thành công");
          location.reload();
        } else {
          alert(data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Đã xảy ra lỗi khi xóa quyền này:", error);
      },
    });
  }
}
