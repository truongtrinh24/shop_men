<?php
function displayRoleList($dataRole)
{
    echo '<div class="container mt-3">';
    echo '<div class="row align-items-center">';
    echo '<div class="col">';
    echo '<h2 class="mb-3 ms-2">LIST ROLE</h2>'; // Thêm lớp ms-2 để lùi sang trái 2 đơn vị
    echo '</div>';

    echo '<div class="col-auto">';
    echo '<div class="d-grid gap-2">';
    echo '<button class="btn btn-success" type="button" id="add-customer-button" data-bs-toggle="modal" data-bs-target="#addAccount" onclick="showFormAddRole()"><i class="bi bi-plus-square">Add</i></button>'; // Thêm nút "Thêm" với icon plus-circle
    echo '</div>';
    echo '</div>';

    echo '</div>'; // Đóng dòng div có class row align-items-center

    echo '<table id="roleList" class="table table-hover text-center mt-3">'; // Thêm lớp text-center để căn giữa nội dung của bảng
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">STT</th>';
    echo '<th scope="col">Role_ID</th>';
    echo '<th scope="col">Role_Name</th>';
    echo '<th scope="col">Function</th>';
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';
    $stt = 1;
    if ($dataRole) {
        foreach ($dataRole as $role) {
            echo '<tr>';
            echo "<td>" . $stt . "</td>"; // Display the value of the STT counter
            echo "<td>" . $role['role_id'] . "</td>";
            echo "<td>" . $role['role_name'] . "</td>";
            echo '<td class="d-flex justify-content-center">';
            echo '<button class="btn btn-success me-1" data-role-id="' . $role['role_id'] . '" data-bs-toggle="modal" data-bs-target="#updateRoleModel" onclick="openUpdateModel(' . $role['role_id'] . ')"><i class="bi bi-pencil-square">Update</i></button>';
            // echo '<button class="btn btn-danger" onclick="deleteRole(\'' . $role['role_id'] . '\')"><i class="bi bi-archive"></i></button>';
            echo '</td>';
            echo '</tr>';
            $stt++;
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}


$role = new roleModel();

$dataRole = $role->getAllRoles();

displayRoleList($dataRole);

?>
<div class="modal fade" id="detailRole" tabindex="-1" aria-labelledby="detailRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailRoleLabel">Detail Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="detailRoleForm"> <!-- Form để cập nhật vai trò -->
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="roleName">
                    </div>
                    <div id="taskCheckboxes">
                        <label for="taskName" class="form-label">Task Name</label>
                        <!-- Các checkbox task sẽ được thêm vào đây -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="updateRoleModel" tabindex="-1" aria-labelledby="updateRoleModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateRoleModelLabel">Update Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateRoleForm"> <!-- Form để cập nhật vai trò -->
                    <!-- Thêm trường ẩn để hiển thị roleId -->
                    <input type="hidden" id="roleId" name="roleId">

                    <div class="mb-3">
                        <label for="roleNameUpdate" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleNameUpdate" name="roleName">
                    </div>
                    <div id="taskCheckboxesUpdate">
                        <label for="taskNameUpdate" class="form-label">Task Name</label>
                        <!-- Các checkbox task sẽ được thêm vào đây -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="updateRole()">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAccount" tabindex="-1" aria-labelledby="addAccountModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateRoleModelLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateRoleForm"> <!-- Form để cập nhật vai trò -->
                    <!-- Thêm trường ẩn để hiển thị roleId -->
                    <input type="hidden" id="roleId" name="roleId">

                    <div class="mb-3">
                        <label for="roleNameUpdate" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleNameAdd" name="roleName">
                    </div>
                    <div id="taskCheckboxesAdd">
                        <label for="taskNameUpdate" class="form-label">Task Name</label>
                        <!-- Các checkbox task sẽ được thêm vào đây -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addRoleNew()">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

