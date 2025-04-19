
<?php
class OrderModel {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }
    public static function getAll() {
        global $db_config;
        $conn = Connection::getInstance($db_config);
    
        $sql = "SELECT 
                    orders.id, 
                    orders.account_id, 
                    orders.total_price, 
                    orders.status_order_id, 
                    orders.shipping_status_id, 
                    orders.created_at, 
                    orders.discount_id, 
                    orders.employee_id, 
                    customer.customer_name 
                FROM 
                    orders
                JOIN 
                    account ON orders.account_id = account.account_id
                JOIN 
                    customer ON account.account_id = customer.account_id";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    
        return $orders;
    }
    public static function getOrderDetails($order_id)
    {
        global $db_config;
        $conn = Connection::getInstance($db_config);
        
        // Truy vấn chi tiết đơn hàng từ bảng order_details
        $query = "SELECT od.id AS order_detail_id, 
            od.order_id, 
            p.name AS product_name, 
            p.price AS product_price, 
            od.quantity AS order_quantity, 
            p.product_image, 
            p.description AS product_description
        FROM order_details od
        JOIN product p ON od.product_id = p.id
        WHERE od.order_id = ?
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public static function getTopCustomersByDateRange($startDate, $endDate)
    {

        global $db_config;
        $conn = Connection::getInstance($db_config);
    
        $sql = "
            SELECT 
                customer.customer_name, 
                SUM(product.price * order_details.quantity) AS total_spent
            FROM orders
            INNER JOIN account ON orders.account_id = account.account_id
            INNER JOIN customer ON account.account_id = customer.account_id
            INNER JOIN order_details ON orders.id = order_details.order_id
            INNER JOIN product ON order_details.product_id = product.id
            WHERE orders.created_at BETWEEN ? AND ?
            GROUP BY customer.customer_id
            ORDER BY total_spent DESC
            LIMIT 5
        ";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    
        return $customers;
    }
    
    
    public static function getTopCustomers($startDate = null, $endDate = null)
    {
        if (!$startDate) $startDate = date('Y-m-d', strtotime('-30 days'));
        if (!$endDate) $endDate = date('Y-m-d');
    
        return self::getTopCustomersByDateRange($startDate, $endDate);
    }
    

    
    
    public  function getAllOrders($account_id) {
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