<?php
class Insurance_Admin extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->getAllInsurance($page, $pageSize);
        $this->data['content'] = 'blocks/admin/insurance';
        $this->data['sub_content']['dataInsurance'] = $Insurance;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function loadDataInsurance()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->getAllInsurance($page, $pageSize);
        header('Content-Type: application/json');
        echo json_encode($Insurance, $page);
    }
    public function searchProductIDforInsurance()
    {
        $seri = $_POST['product_seri'];
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->searchProductIDforInsurance($seri);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $Insurance));
    }
    public function getEmployeeList()
    {
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->fetchEmployeeList();
        header('Content-Type: application/json');
        echo json_encode($Insurance);
    }
    public function getInfoInsurance()
    {
        $seri = $_POST['product_seri'];
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->infoInert($seri);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $Insurance));
    }
    public function insertInsurance()
    {
        if (isset($_POST['product_seri']) && isset($_POST['customer_id']) && isset($_POST['order_id']) && isset($_POST['equipment_replacement'])) {
            $product_seri = $_POST['product_seri'];
            $customer_id = $_POST['customer_id'];
            $order_id = $_POST['order_id'];
            $equipment_replacement = $_POST['equipment_replacement'];
            $employee_id = $_POST['employee_id'];
            $insurance = $this->model("InsuranceAdminModel");
            $result = $insurance->insertInsurance($order_id, $customer_id, $product_seri, $equipment_replacement, $employee_id);
            if ($result == true) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "message" => "Insurance insert successfully"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "message" => "Failed to insert Insurance"
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Missing data"
                )
            );
        }
    }

    public function updateInsuranceStatus()
    {
        $insurance_id = $_POST['insurance_id'];
        $new_status = $_POST['new_status'];
        echo $insurance_id;
        echo $new_status;
        $insurance = $this->model("InsuranceAdminModel");
        $success = $insurance->updateInsuranceStatus($new_status, $insurance_id);
        if ($success) {
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => "Insurance updated successfully"
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Failed to update Insurance"
                )
            );
        }
    }

    public function detailInsurance()
    {
        $insurance_id = $_GET['insurance_id'];
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->deltailInsurancebyID($insurance_id); // Sửa tên phương thức gọi
        header('Content-Type: application/json');
        echo json_encode($Insurance);
    }

}

?>