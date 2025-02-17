<?php
class roleModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }
    public function getAllRoles()
    {
        $sql = "SELECT * FROM role";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function getDetailRoleById($role_id)
    {
        $sql = "SELECT role.role_id, role.role_name, task.task_id, task.task_name 
                FROM detail_task_role
                JOIN task ON task.task_id = detail_task_role.task_id
                JOIN role ON role.role_id = detail_task_role.role_id
                WHERE role.role_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getAllTask()
    {
        $sql = "SELECT * FROM task";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function updateRole($roleId, $tasks, $roleName)
    {
        $this->__conn->begin_transaction();

        try {
            // Xóa tất cả các nhiệm vụ của vai trò
            $deleteSql = "DELETE FROM detail_task_role WHERE role_id = ?";
            $deleteStmt = $this->__conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $roleId);
            $deleteStmt->execute();

            // Thêm các nhiệm vụ mới cho vai trò
            foreach ($tasks as $task) {
                $task_id = $task['task_id'];
                $insertSql = "INSERT INTO detail_task_role (role_id, task_id, activity_id) VALUES (?, ?, 1)";
                $insertStmt = $this->__conn->prepare($insertSql);
                $insertStmt->bind_param("ii", $roleId, $task_id);
                $insertStmt->execute();
            }

            // Cập nhật role_name
            $updateSql = "UPDATE role SET role_name = ? WHERE role_id = ?";
            $updateStmt = $this->__conn->prepare($updateSql);
            $updateStmt->bind_param("si", $roleName, $roleId);
            $updateStmt->execute();

            $this->__conn->commit();
            return true;
        } catch (Exception $e) {
            $this->__conn->rollback();
            return false;
        }
    }


    public function updateRole2($roleId, $tasks)
    {
        $this->__conn->begin_transaction();

        try {
            // Xóa tất cả các bản ghi có role_id tương ứng
            $deleteSql = "DELETE FROM detail_task_role WHERE role_id = ?";
            $deleteStmt = $this->__conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $roleId);
            $deleteStmt->execute();

            // Thêm các task mới cho vai trò
            $insertSql = "INSERT INTO detail_task_role (role_id, task_id) VALUES (?, ?)";
            $insertStmt = $this->__conn->prepare($insertSql);

            foreach ($tasks as $task) {
                $task_id = $task['task_id'];
                $insertStmt->bind_param("ii", $roleId, $task_id);
                $insertStmt->execute();
            }

            $this->__conn->commit();
            return true;
        } catch (Exception $e) {
            $this->__conn->rollback();
            return false;
        }
    }




    //add role
    public function addRole($roleName, $tasks)
    {
        $this->__conn->begin_transaction();

        try {
            // Thêm vai trò mới vào bảng role
            $insertRoleSql = "INSERT INTO role (role_name) VALUES (?)";
            $insertRoleStmt = $this->__conn->prepare($insertRoleSql);
            $insertRoleStmt->bind_param("s", $roleName);
            $insertRoleStmt->execute();

            // Lấy ID của vai trò mới được thêm vào
            $roleId = $insertRoleStmt->insert_id;

            // Thêm các nhiệm vụ cho vai trò


            foreach ($tasks as $task) {
                $task_id = $task['task_id'];
                $insertDetailSql = "INSERT INTO detail_task_role (role_id, task_id,activity_id ) VALUES (?, ?,1)";
                $insertDetailStmt = $this->__conn->prepare($insertDetailSql);
                $insertDetailStmt->bind_param("ii", $roleId, $task_id);
                $insertDetailStmt->execute();
            }

            $this->__conn->commit();
            return true;
        } catch (Exception $e) {
            $this->__conn->rollback();
            return false;
        }
    }
    public function deleteRole($role_id)
    {
        $sql = "DELETE FROM role WHERE role_id =?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $role_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
