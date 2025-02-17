<?php

class EmployeeModel {
   

    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getEmployees() {
        $sql = "SELECT employee_id, employee_name FROM employee";
        $result = $this->__conn->query($sql);
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        return $employees;
    }
}


?>
