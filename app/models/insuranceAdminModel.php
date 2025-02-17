<?php

class InsuranceAdminModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllInsurance($page, $pageSize)
    {
        // Convert $page and $pageSize to integers
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT COUNT(*) as total_records FROM insurance";
        $result = $this->conn->query($sql);
        $total_records = $result->fetch_assoc()['total_records'];
        $total_page = ceil($total_records / $pageSize);

        $sql = "SELECT * FROM insurance JOIN employee ON employee.employee_id = insurance.employee_id JOIN customer ON customer.customer_id = insurance.customer_id LIMIT $start, $pageSize";
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
    public function searchProductIdforInsurance($product_seri)
    {
        $sql = "SELECT pr.*, d.*, o.*, c.*, p.*, 
        CASE
            WHEN DATE_ADD(o.date_buy, INTERVAL p.product_time_insurance MONTH) > NOW() THEN 'Còn bảo hành'
            ELSE 'Hết bảo hành'
        END AS status_product
    FROM product_seri pr 
    JOIN detail_order d ON pr.product_seri = d.product_seri 
    JOIN orders o ON d.order_id = o.order_id 
    JOIN account a ON o.account_id = a.account_id
    JOIN customer c ON a.username = c.customer_id 
    JOIN product p ON p.product_id = pr.product_id
    WHERE pr.product_seri = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $product_seri);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false; // Không tìm thấy dữ liệu
        }
    }

    public function infoInsert($product_seri)
    {
        $sql = "SELECT pr.*, d.*, o.*, c.*, p.*, 
        CASE
            WHEN DATE_ADD(o.date_buy, INTERVAL p.product_time_insurance MONTH) > NOW() THEN 'Còn bảo hành'
            ELSE 'Hết bảo hành'
        END AS status_product
    FROM product_seri pr 
    JOIN detail_order d ON pr.product_seri = d.product_seri 
    JOIN orders o ON d.order_id = o.order_id 
    JOIN customer c ON o.customer_id = c.customer_id 
    JOIN product p ON p.product_id = pr.product_id
    WHERE pr.product_seri = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $product_seri);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    public function fetchEmployeeList()
    {
        $sql = "SELECT * FROM employee";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function insertInsurance($order_id, $customer_id, $product_seri, $equipment_replacement, $employee_id)
    {
        $sql = "INSERT INTO insurance(order_id, customer_id, product_seri, employee_id, equipment_replacement, status_insurance) VALUES(?,?,?,?,?,0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", $order_id, $customer_id, $product_seri, $employee_id, $equipment_replacement);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateInsuranceStatus($new_status, $insurance_id)
    {
        $sql = "UPDATE insurance SET insurance.status_insurance = ? WHERE insurance.insurance_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $new_status, $insurance_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deltailInsurancebyID($insurance_id)
    {
        $sql = "SELECT s.*, e.*, o.*, c.* ,i.*,p.*
        FROM insurance i 
        JOIN orders o ON i.order_id = o.order_id
        JOIN customer c ON i.customer_id = c.customer_id
        JOIN product_seri s ON i.product_seri = s.product_seri
        JOIN employee e ON i.employee_id = e.employee_id
        JOIN product p ON s.product_id = p.product_id
        WHERE i.insurance_id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $insurance_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }



}
?>