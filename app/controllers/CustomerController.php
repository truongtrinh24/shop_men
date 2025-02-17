<?php
class CustomerController extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {
    }
    public function index()
    {
        $products = $this->model("customerModel");
        $Products = $products->getAccountLimit(5);
        $this->data['content'] = 'blocks/admin/customerView';
        $this->data['sub_content']['dataProduct'] = $Products;
        $this->render('layouts/admin_layout', $this->data);
    }

    public function detail(){
        $account_id = $_GET['id']; 
        $accountModel = $this->model("customerModel");
        $listAccount = $accountModel->getAccountById($account_id);
        
        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "customer" => $listAccount));
    }
    
    
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve updated account information from the request
            $customerId = $_POST['customer_id'];
            $customerName = $_POST['customer_name'];
            $customerAddress = $_POST['customer_address'];
            $customerPhone = $_POST['customer_phone'];
            $customerEmail = $_POST['customer_email'];

         

            $accountModel = $this->model("customerModel");

            $result = $accountModel->updateCustomer($customerId,$customerName, $customerAddress, $customerPhone, $customerEmail);

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
            $accountId = $_POST['customer_id'];

            $accountModel = $this->model("customerModel");
            $result = $accountModel->deleteCustomer($accountId);

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
            $accountModel = $this->model("customerModel");
            // Thêm từ khóa tìm kiếm vào phương thức searchAccount() của model
            $listAccount = $accountModel->searchCustomer($keyword);
            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "account" => $listAccount));
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid request method"));
        }   
    }
    
}
