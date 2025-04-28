<?php
class Orders {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    // 1. Lấy chi tiết đơn hàng theo order_id (Dùng trong viewDetailOrder())
    public function  getDetailOrderByOrderId($order_id) {
        $sql = "SELECT id, order_id, product_id, quantity, price
                FROM order_details
                WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $stmt->close();
        return $data;
    }

    // 2. Hủy đơn hàng (Dùng trong cancelOrder($order_id))
    public function cancelOrder($order_id) {
        // Update bảng orders: set trạng thái thành '3' (Đã hủy)
        $sql = "UPDATE  SET status_order_id = 3 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $order_id);

        if (!$stmt->execute()) {
            echo "Lỗi khi hủy đơn hàng: " . $stmt->error;
            return false;
        }

        $stmt->close();
        return true;
    }
}
?>
