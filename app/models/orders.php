<?php
class Orders {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    // Lấy chi tiết đơn hàng theo order_id
    public function getDetailOrderByOrderId($order_id) {
        $sql = "SELECT id, order_id, product_id, quantity, price
                FROM detail_order
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

    // Thêm sản phẩm vào chi tiết đơn hàng
    public function addDetailOrder($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO detail_order (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param('iiid', $order_id, $product_id, $quantity, $price);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Xóa chi tiết đơn hàng theo id
    public function deleteDetailOrder($id) {
        $sql = "DELETE FROM detail_order WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param('i', $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Cập nhật số lượng hoặc giá trong chi tiết đơn hàng
    public function updateDetailOrder($id, $quantity, $price) {
        $sql = "UPDATE detail_order
                SET quantity = ?, price = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param('idi', $quantity, $price, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
?>
