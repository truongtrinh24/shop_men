
<?php
class Products {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllProducts() {
        $sql = 'SELECT * FROM  product';
        $result = $this->conn->query($sql);
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductByUrl($url) {
        $sql = 'SELECT * FROM  product WHERE product_url = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) { 
            $product = $result->fetch_assoc();
            return $product;
        }
        return false;
    }

    public function getProductsByName($name) {
        $sql = "SELECT * FROM  product WHERE product_name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%{$name}%";
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    
    public function getProductsByCategoryAndFilters($categoryIds, $nameQuery = '', $priceRangeStart = '', $priceRangeEnd = '') {
        // Khởi tạo biến $sql với phần truy vấn cơ bản
        $sql = 'SELECT * FROM  product';
    
        // Khởi tạo mảng $params để lưu trữ các tham số của truy vấn
        $params = array();
    
        // Thêm điều kiện cho category_id nếu danh sách $categoryIds không rỗng
        if (!empty($categoryIds)) {
            $sql .= ' WHERE category_id IN ('.implode(',', array_fill(0, count($categoryIds), '?')).')';
            $params = array_merge($params, $categoryIds);
        }
        
        // Thêm điều kiện cho tên sản phẩm nếu có
        if (!empty($nameQuery)) {
            // Kiểm tra nếu đã thêm điều kiện WHERE vào câu truy vấn
            $sql .= !empty($params) ? ' AND' : ' WHERE';
            $sql .= ' product_name LIKE ?';
            $params[] = '%'.$nameQuery.'%';
        }
    
        // Thêm điều kiện cho khoảng giá nếu có
        if (!empty($priceRangeStart) && !empty($priceRangeEnd)) {
            // Kiểm tra nếu đã thêm điều kiện WHERE vào câu truy vấn
            $sql .= !empty($params) ? ' AND' : ' WHERE';
            $sql .= ' product_price BETWEEN ? AND ?';
            $params[] = $priceRangeStart;
            $params[] = $priceRangeEnd;
        }
    
        // Chuẩn bị và thực thi câu truy vấn
        $stmt = $this->conn->prepare($sql);
    
        // Kiểm tra nếu có tham số để bind
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Xử lý kết quả trả về
        if($result->num_rows > 0) { 
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        }
        return false;
    }
 
}