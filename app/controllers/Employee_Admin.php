<?php
class Employee_Admin extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $employees = $this->model("EmployeeAdminModel");
        $Employees = $employees->getAllEmployees($page, $pageSize);
        $this->data['content'] = 'blocks/admin/employee';
        $this->data['sub_content']['dataEmployee'] = $Employees;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function loadDataEmployee()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $employees = $this->model("EmployeeAdminModel");
        $Employees = $employees->getAllEmployees($page, $pageSize);
        header('Content-Type: application/json');
        echo json_encode($Employees, $page);
    }

    public function detailEmployeeId()
    {
        $employee_id = $_GET['employee_id'];
        $employee = $this->model("EmployeeAdminModel");
        $Employee = $employee->getEmployeeById($employee_id);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $Employee));
    }

    public function updateEmployee()
    {
        $employee_id = $_POST['employee_id'];
        $employee_name = $_POST['employee_name'];
        $employee_phone = $_POST['employee_phone'];
        $employee_address = $_POST['employee_address'];
        $employee_email = $_POST['employee_email'];
        $employees = $this->model("EmployeeAdminModel");
        $result = $employees->updateEmployee($employee_id, $employee_name, $employee_phone, $employee_address, $employee_email);
        // Kiểm tra kết quả và trả về JSON response
        if ($result) {
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => "Product updated successfully"
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Failed to update product"
                )
            );
        }
    }
    public function searchEmployee()
    {
        $keyword = $_POST['keyword'];
        $sizePage = 8;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        if ($keyword != null) {
            $employees = $this->model("EmployeeAdminModel");
            $result = $employees->searchEmployee($keyword, $page, $sizePage);
            if ($result !== false) {
                // Count total products
                $totalEmployees = $employees->countEmployeeBySearch($keyword); // Change to countProductBySearch

                // Calculate total pages
                $totalPages = ceil($totalEmployees / $sizePage);

                // Return JSON response
                header('Content-Type: application/json');
                echo json_encode(array("data" => $result, "current_page" => $page, "total_page" => $totalPages));
            } else {
                // Return JSON response if no products found
                header('Content-Type: application/json');
                echo json_encode("No products found");
            }
        } else {
            $employees = $this->model("EmployeeAdminModel");
            $Employees = $employees->getAllEmployees($page, $sizePage);
            header('Content-Type: application/json');
            echo json_encode($Employees, $page);
        }
    }

    public function insertEmployee()
    {
        $employee_name = $_POST['employee_name'];
        $employee_phone = $_POST['employee_phone'];
        $employee_address = $_POST['employee_address'];
        $employee_email = $_POST['employee_email'];
        $employees = $this->model("EmployeeAdminModel");
        $result = $employees->insertEmployee($employee_name, $employee_phone, $employee_address, $employee_email);
        // Kiểm tra kết quả và trả về JSON response
        if ($result) {
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => "Product insert successfully"
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Failed to insert product"
                )
            );
        }
    }
}


?>