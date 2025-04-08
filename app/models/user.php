<?php
class User
{
    private $__conn;

    public function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
        if (!$this->__conn) {
            throw new Exception("Không thể kết nối đến database!");
        }
    }

    public function login($email, $password)
    {
        echo "<p>Input email: " . htmlspecialchars($email) . "</p>";
        echo "<p>Input password: " . htmlspecialchars($password) . "</p>";

        $stmt = $this->__conn->prepare("SELECT * FROM account WHERE customer_email = ?");
        if ($stmt === false) {
            echo "<p style='color: red;'>Prepare failed: " . htmlspecialchars($this->__conn->error) . "</p>";
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        echo "<pre>User from account table: " . htmlspecialchars(print_r($user, true)) . "</pre>";

        if ($user) {
            echo "<p>Password in DB: " . htmlspecialchars($user['password']) . "</p>";
            // So sánh trực tiếp mật khẩu plain text
            if ($password === $user['password']) {
                $stmt = $this->__conn->prepare("SELECT customer_name FROM customer WHERE customer_email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $customer = $result->fetch_assoc();
                $stmt->close();

                echo "<pre>Customer data: " . htmlspecialchars(print_r($customer, true)) . "</pre>";

                $user['customer_name'] = $customer['customer_name'] ?? null;
                echo "<p style='color: green;'>Login successful!</p>";
                return $user;
            } else {
                echo "<p style='color: red;'>Password does not match! (Input: $password, DB: " . $user['password'] . ")</p>";
                return false;
            }
        } else {
            echo "<p style='color: red;'>No user found with this email!</p>";
            return false;
        }
    }
    //laythongtin customer
    public function getCustomerByAccountId($accountId)
    {
        $query = "SELECT customer_name, customer_address, customer_phone FROM customer WHERE account_id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về thông tin khách hàng
    }
    public function getOrdersByAccountId($accountId)
    {
        $query = "SELECT o.id, o.created_at, o.total_price, so.status_order_name, ss.status_name AS shipping_status_name
              FROM orders o
              LEFT JOIN status_order so ON o.status_order_id = so.id
              LEFT JOIN shipping_status ss ON o.shipping_status_id = ss.id
              WHERE o.account_id = ?";
        $stmt = $this->__conn->prepare($query);
        if ($stmt === false) {
            echo "<p style='color: red;'>Prepare failed: " . htmlspecialchars($this->__conn->error) . "</p>";
            return [];
        }

        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $orders;
    }
    public function getOrderDetails($orderId)
    {
        // Lấy thông tin đơn hàng và khách hàng
        $query = "SELECT o.id AS order_id, o.created_at AS order_date, o.total_price, 
                     c.customer_name, c.customer_phone, c.customer_address
              FROM orders o
              JOIN customer c ON o.account_id = c.account_id
              WHERE o.id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if (!$order) {
            return null;
        }

        // Lấy danh sách sản phẩm trong đơn hàng
        $query = "SELECT p.name, p.price, od.quantity
              FROM order_details od
              JOIN product p ON od.product_id = p.id
              WHERE od.order_id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return [
            'order_id' => $order['order_id'],
            'order_date' => $order['order_date'], // Giữ nguyên định dạng, JavaScript sẽ định dạng
            'customer_name' => $order['customer_name'],
            'customer_phone' => $order['customer_phone'],
            'customer_address' => $order['customer_address'],
            'total_price' => $order['total_price'],
            'products' => $products,
        ];
    }
}