
<?php
class OrderModel {
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
    
        $sql = 'INSERT INTO  orders (account_id, status_order_id, total_price, created_at) VALUES (?, ?, ?, ?)';
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
        $sql = 'INSERT INTO  order_details (order_id, product_id) VALUES (?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $order_id, $product_seri);

        if (!$stmt->execute()) {
            echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $stmt->error;
            return false;
        }
    
        return $order_id;
    }

    public function getProductSeriByProductId($productId, $quantity) {
        $sql = 'SELECT category_id
        FROM product
        WHERE product_id = ? 
        ORDER BY category_id
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
                FROM order_details
                JOIN product ON order_details.product_id = product.product_id
                WHERE order_id = ?";
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
        $sql = 'UPDATE orders SET status_order_id = 3 WHERE id =?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $order_id);

        if (!$stmt->execute()) {
            echo "Lỗi khi thêm sản phẩm vào đơn hàng: ". $stmt->error;
            return false;
        }
        return true;
    }

    public static function updateStatus($id, $status) {
        $db = new DB();
        return $db->table('orders')->where('id', '=', $id)->update(['status' => $status]);
    }
    
    public static function countAll() {
        global $db_config;
        $conn = Connection::getInstance($db_config);
    
        $sql = "SELECT COUNT(*) AS total FROM orders";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    
        return $row['total'] ?? 0;
    }    
    
    public static function getConfirmedRevenue() {
        global $db_config;
        $conn = Connection::getInstance($db_config);
    
        // Lấy tổng tiền đơn hàng đã xác nhận (giả sử 2 = đã xác nhận)
        $sql = "SELECT SUM(total_price) AS revenue FROM orders WHERE status_order_id = 2";
        $result = $conn->query($sql);
    
        if (!$result) {
            die("❌ Lỗi truy vấn: " . $conn->error);
        }
    
        $row = $result->fetch_assoc();
        return $row['revenue'] ?? 0;
    }    
    
    public static function getMonthlyRevenue() {
        global $db_config;
        $conn = Connection::getInstance($db_config);
    
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, 
                       SUM(total_price) AS revenue
                FROM orders
                WHERE status_order_id = 2
                GROUP BY month
                ORDER BY month ASC
                LIMIT 12";
    
        $result = $conn->query($sql);
    
        if (!$result) {
            die("❌ Lỗi SQL: " . $conn->error); // In lỗi ra màn hình
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }    
    
}
