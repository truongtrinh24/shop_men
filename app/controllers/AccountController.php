<?php
class AccountController extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {
    }
    public function index()
    {
        $products = $this->model("accountModel");
        $Products = $products->getAccountLimit(5);
        $this->data['content'] = 'blocks/admin/accountView';
        $this->data['sub_content']['dataProduct'] = $Products;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function detail(){
        $account_id = $_GET['id']; 
        $accountModel = $this->model("accountModel");
        $listAccount = $accountModel->getAccountById($account_id);
        
        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "account" => $listAccount));
    }
    
    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve new account information from the request
            $username = $_POST['username'];
            $password = $_POST['password'];
            $roleId = $_POST['role_id'];
    
            // Validate the received data (You can add more validation as needed)
            if (empty($username) || empty($password) || empty($roleId)) {
                echo json_encode(array("status" => "error", "message" => "Please provide all necessary data for adding a new account"));
                return;
            }
    
            // Add the account to the database
            $accountModel = $this->model("accountModel");
            // $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = $accountModel->addAccount($username, $password, $roleId);
    
            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account added successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to add account"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }
    
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve updated account information from the request
            $accountId = $_POST['account_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $roleId = $_POST['role_id'];

            // Validate the received data (You can add more validation as needed)
            // if (empty($accountId) || empty($username) || empty($password) || empty($roleId)) {
            //     echo json_encode(array("status" => "error", "message" => "Please provide all necessary data for account update"));
            //     return;
            // }

            // Update the account in the database
            $accountModel = $this->model("accountModel");
            // $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $result = $accountModel->updateAccount($accountId, $username, $password, $roleId);

            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account updated successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to update account"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accountId = $_POST['account_id'];

            $accountModel = $this->model("accountModel");
            $result = $accountModel->updateAccountStatusById($accountId);

            if ($result) {
                echo json_encode(array("status" => "success", "message" => "Account deleted successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to account product"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }
    }
    public function search(){
        $keyword = $_POST['keyword'] ?? '';
        if ($keyword != null) {
            $accountModel = $this->model("accountModel");
            // Thêm từ khóa tìm kiếm vào phương thức searchAccount() của model
            $listAccount = $accountModel->searchAccount($keyword);
            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "account" => $listAccount));
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }   
    }
    
}
