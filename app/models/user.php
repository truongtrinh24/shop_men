
<?php
class User {
    private $__conn;

    function __construct(){
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getAccountByUsername($username, $password) {
        $sql = "SELECT * FROM account WHERE username = ? AND password = ? AND status_account = 1";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('ss', $username, $password); // Sử dụng 'ss' vì cả hai tham số đều là chuỗi
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) { 
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return false;
        }
    }
    
    
    public function checkEmailCustomerExist($email) {
        $sql = 'SELECT customer_id FROM customer WHERE customer_email =?';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }

        $stmt->bind_param('s', $email);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addCustomer($name, $address, $phone, $email) {
        $sql = 'INSERT INTO customer(customer_name, customer_address, customer_phone, customer_email) VALUES(?, ?, ?, ?)';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }
        $stmt->bind_param('ssss', $name, $address, $phone, $email);
        if ($stmt->execute()) {
            $stmt->close(); 
            return true; 
        }
        return false;
    }
    

    public function getNewlyCustomerId() {
        $sql = "SELECT customer_id FROM customer
        ORDER BY customer_id DESC
        LIMIT 1;";
        $stmt = $this->__conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) { 
            $row = $result->fetch_assoc();
            $customer_id = $row['customer_id']; // Retrieve the customer_id value from the associative array
            return $customer_id;
        } else {
            return false;
        }
    }

    public function getCustomerById($customer_id) {
        $sql = "SELECT * FROM customer WHERE customer_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if(!$stmt) {
            die('prepare failed: ' . $this->__conn->error);
        }
        $stmt->bind_param('s', $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
            return $customer;
        }
        return false;
    }
    
    public function getPermissionsByRoleId($roleId) {
        $sql = "SELECT detail_task_role.role_id, detail_task_role.task_id, task.task_name 
                FROM detail_task_role 
                JOIN task ON task.task_id = detail_task_role.task_id
                WHERE detail_task_role.role_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $roleId); // Liên kết tham số với giá trị roleId (kiểu integer)
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $permissions = $result->fetch_all(MYSQLI_ASSOC);
            return $permissions;
        }
        return false;
    }
    public function getAllPermissions(){
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
    
}
