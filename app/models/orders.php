
<?php
class Orders {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllOrders($account_id) {
        $sql = 'SELECT * FROM orders WHERE account_id =?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function placeOrder($account_id, $total_amount) {
        $status = 1;

        $now = new DateTime();
        $date_buy = $now->format('Y-m-d H:i:s');
    
        $sql = 'INSERT INTO  orders (account_id, status_order_id, total, date_buy) VALUES (?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            echo "Prepare statement failed: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param('iiis', $account_id, $status, $total_amount, $date_buy);

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;
            $stmt->close(); 
            return $orderId;
        } else {
            echo "Execution failed: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }
    

    public function placeOrderWithItems($order_id, $product_seri) {
        $sql = 'INSERT INTO  detail_order (order_id, product_seri) VALUES (?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $order_id, $product_seri);

        if (!$stmt->execute()) {
            echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $stmt->error;
            return false;
        }
    
        return $order_id;
    }

    public function getProductSeriByProductId($productId, $quantity) {
        $sql = 'SELECT product_seri 
        FROM product_seri 
        WHERE product_id = ? AND status = 1 
        ORDER BY product_seri
        LIMIT ?;
        ';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $productId, $quantity);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function getDetailOrderByOrderId($order_id) {
        $sql = "SELECT *
        FROM detail_order
        JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
        JOIN product ON product_seri.product_id = product.product_id
        WHERE detail_order.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function updateStatusProductSeries($product_seri) {
        $sql = 'UPDATE product_seri SET status = 0 WHERE product_seri = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $product_seri);

        if (!$stmt->execute()) {
            echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $stmt->error;
            return false;
        }
        return true;
    }

    public function cancelOrder($order_id) {
        $sql = 'UPDATE orders SET status_order_id = 3 WHERE order_id =?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $order_id);

        if (!$stmt->execute()) {
            echo "Lỗi khi thêm sản phẩm vào đơn hàng: ". $stmt->error;
            return false;
        }
        return true;
    }
}