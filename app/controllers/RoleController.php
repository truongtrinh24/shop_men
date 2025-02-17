<?php
class RoleController extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {
    }
    public function index()
    {
        $products = $this->model("roleModel");
        $Products = $products->getAllRoles();
        $this->data['content'] = 'blocks/admin/roleView';
        $this->data['sub_content']['dataProduct'] = $Products;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function detail()
    {
        $role_id = $_GET['id'];
        $roleModel = $this->model("roleModel");
        $listRole = $roleModel->getDetailRoleById($role_id);

        header('Content-Type: application/json');
        echo json_encode(array("data" => $listRole));
    }
   

    public function detailRole()
    {
        $role_id = $_GET['id'];
        $roleModel = $this->model("roleModel");
        $listRole = $roleModel->getAllTask($role_id);

        header('Content-Type: application/json');
        echo json_encode(array("data" => $listRole));
    }
    public function a()
    {
        echo "hello";
    }
    public function getAllTask()
    {
        $roleModel = $this->model("roleModel");
        $data = $roleModel->getAllTask();
        header('Content-Type: application/json');
        echo json_encode(array("data" => $data));
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu gửi từ form
            $roleName = $_POST['role_name'];
            $tasks = $_POST['tasks']; 
            
            if (empty($roleName) || empty($tasks) || !is_array($tasks)) {
                echo json_encode(array("status" => "error", "message" => "Please provide all necessary data for role creation"));
                return;
            }
    
            $roleModel = $this->model("roleModel");
            $result = $roleModel->addRole($roleName, $tasks);
    
            if ($result) {
                header('Content-Type: application/json');
                echo json_encode(array("status" => "success", "message" => "Role added successfully"));
            } else {
                // echo $roleName;
                // print_r($tasks);
                echo json_encode(array("status" => "error", "message" => "Failed to add role"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }
    
    
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $roleId = $_POST['role_id'];
            $roleName = $_POST['role_name'];
            $tasks = $_POST['tasks'];

            if (empty($roleId) || empty($tasks) || !is_array($tasks)) {
                echo json_encode(array("status" => "error", "message" => "Please provide all necessary data for role update"));
                return;
            }

            $roleModel = $this->model("roleModel");
            $result = $roleModel->updateRole($roleId, $tasks,$roleName);

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode(array("status" => "success", "message" => "Role updated successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to update role"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }


    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $roleId = $_POST['role_id'];

            $roleModel = $this->model("roleModel");
            $result = $roleModel->deleteRole($roleId);

            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account deleted successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to account product"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }
}
