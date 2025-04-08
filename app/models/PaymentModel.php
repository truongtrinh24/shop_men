<?php
class PaymentModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getCustomerInfo($account_id)
    {
        $sql = "SELECT customer_name, customer_email FROM customer WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();
        return $customer ?: ['customer_name' => 'Khách hàng', 'customer_email' => 'email@example.com'];
    }

    public function getCartItems($account_id)
    {
        $sql = "
        SELECT p.id AS product_id, p.name, p.price, p.product_image, p.image_folder, c.quantity, col.description AS color, s.description AS size
        FROM cart c
        JOIN product p ON c.product_id = p.id
        JOIN color col ON c.color_id = col.id
        JOIN size s ON c.size_id = s.id
        WHERE c.account_id = ?
    ";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'product_id' => $row['product_id'], // Thêm product_id
                'name' => $row['name'],
                'price' => number_format($row['price'], 0, ',', '.') . 'đ',
                'image' => $row['product_image'],
                'image_folder' => $row['image_folder'],
                'color' => $row['color'],
                'size' => $row['size'],
                'quantity' => $row['quantity']
            ];
        }
        $stmt->close();
        return $items;
    }
    public function updateCustomerInfo($account_id, $name, $phone, $address)
    {
        $sql = "UPDATE customer SET customer_name = ?, customer_phone = ?, customer_address = ? WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $phone, $address, $account_id);
        $stmt->execute();
        $stmt->close();
    }
    public function createOrder($account_id, $total_price, $payment_method)
    {
        $status_order_id = 1; // Chờ xác nhận
        $shipping_status_id = 1; // Chưa giao
        $sql = "INSERT INTO orders (account_id, total_price, status_order_id, shipping_status_id, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("idii", $account_id, $total_price, $status_order_id, $shipping_status_id);
        $stmt->execute();
        $order_id = $this->__conn->insert_id;
        $stmt->close();
        return $order_id;
    }

    public function createOrderDetail($order_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("iii", $order_id, $product_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    public function clearCart($account_id)
    {
        $sql = "DELETE FROM cart WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $stmt->close();
    }
}