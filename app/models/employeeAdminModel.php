<?php
class EmployeeAdminModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllEmployees($page, $pageSize)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT COUNT(*) as total_records FROM employee";
        $result = $this->conn->query($sql);
        $total_records = $result->fetch_assoc()['total_records'];
        $total_page = ceil($total_records / $pageSize);
        $sql = "SELECT * FROM employee LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return array("data" => $data, "total_page" => $total_page);
        }
        return false;

    }

    public function getEmployeeById($employee_id)
    {
        $sql = "SELECT * FROM employee e
        JOIN account a ON a.username = e.employee_id
        WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function insertEmployee($employee_name, $employee_phone, $employee_address, $employee_email)
    {
        $sql = "INSERT INTO employee(employee_name, employee_phone, employee_address, employee_email) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $employee_name, $employee_phone, $employee_address, $employee_email);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateEmployee($employee_id, $employee_name, $employee_phone, $employee_address, $employee_email)
    {
        $sql = "UPDATE employee SET employee_name = ?, employee_phone = ?, employee_address = ?, employee_email = ? WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $employee_name, $employee_phone, $employee_address, $employee_email, $employee_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function searchEmployee($keyword, $page)
    {
        $page = (int) $page;
        $pageSize = (int) 8;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM employee e WHERE e.employee_id LIKE '%$keyword%' 
        or e.employee_name LIKE '%$keyword%' 
        or e.employee_phone LIKE '%$keyword%' 
        or e.employee_email LIKE '%$keyword%'
        LIMIT $start, $pageSize
        ";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }

    }
    public function countEmployeeBySearch($keyword)
    {
        $sql = "SELECT COUNT(*) as total_count FROM employee WHERE employee.employee_id LIKE N'%$keyword%'
    OR employee.employee_phone LIKE N'%$keyword%'
    OR employee.employee_address LIKE N'%$keyword% '
    OR employee.employee_email LIKE N'%$keyword%'
    ";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total_count'];
    }
}
?>