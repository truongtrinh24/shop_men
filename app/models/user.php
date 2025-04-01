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
}