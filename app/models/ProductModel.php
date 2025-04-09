<?php
class ProductModel
{
    private $__conn;
    private $table = "category";


    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
        if (!$this->__conn) {
            throw new Exception("Không thể kết nối đến database!");
        }
    }

    // Phương thức lấy 6 sản phẩm mới nhất
    public function getLatestProducts($limit = 6)
    {
        $stmt = $this->__conn->prepare("SELECT * FROM product ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }
    // app/models/ProductModel.php


    public function getProductById($id)
    {
        // Sử dụng kết nối đã được thiết lập
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->__conn->prepare($query);

        // Ràng buộc tham số
        $stmt->bind_param("i", $id);

        // Thực thi truy vấn
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Trả về thông tin sản phẩm
        return $result->fetch_assoc(); // Trả về thông tin sản phẩm

    }
    public function getProductImages($productId)
    {
        $query = "SELECT image_url FROM product_images WHERE product_id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); // Trả về tất cả hình ảnh
    }

    public function getCategoriesByType($typeId)
{
    $query = "SELECT * FROM category WHERE id_type = ?";
    $stmt = $this->__conn->prepare($query);

    // ✅ Kiểm tra lỗi prepare
    if (!$stmt) {
        die("Lỗi prepare: " . $this->__conn->error . "<br>SQL: " . $query);
    }

    $stmt->bind_param("i", $typeId);
    $stmt->execute();

    $result = $stmt->get_result();
    if (!$result) {
        die("Lỗi lấy kết quả: " . $stmt->error);
    }

    $categories = $result->fetch_all(MYSQLI_ASSOC);

    return $categories;
}


    public static function getAll() {
        $db = new DB();
        return $db->table('product')->get();
    }
    
    public static function getById($id) {
        $db = new DB();
        return $db->table('product')->where('id', '=', $id)->first();
    }
    
    public static function update($id, $data) {
        $db = new DB();
        $db->table('product')->where('id', '=', $id)->update($data);
    }
    
    public static function delete($id) {
        $db = new DB();
        $db->table('product')->where('id', '=', $id)->delete();
    }
    
    public static function insert($data) {
        $sql = "INSERT INTO product (name, price, image, category)
                VALUES (:name, :price, :image, :category)";
        $params = [
            ':name' => $data['name'],
            ':price' => $data['price'],
            ':image' => $data['image'],
            ':category' => $data['category']
        ];
        return (new DB())->query($sql, $params);
    }
    
    public static function countAll() {
        global $db_config;
        $conn = Connection::getInstance($db_config); // dùng lại đúng hệ thống của bạn
    
        $sql = "SELECT COUNT(*) AS total FROM product";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    
        return $row['total'] ?? 0;
    }     
    
    public static function getFiltered($category_id = null, $keyword = '', $min_price = null, $max_price = null, $limit = 10, $offset = 0) {
        $db = new DB();
        $sql = "SELECT p.*, c.name AS category_name
                FROM product p
                LEFT JOIN category c ON p.category_id = c.id
                WHERE 1";
    
        if ($category_id) {
            $sql .= " AND p.category_id = " . intval($category_id);
        }
    
        if (!empty($keyword)) {
            $kw = $db->escape("%$keyword%");
            $sql .= " AND p.name LIKE '$kw'";
        }
    
        if ($min_price !== null) {
            $sql .= " AND p.price >= " . floatval($min_price);
        }
    
        if ($max_price !== null) {
            $sql .= " AND p.price <= " . floatval($max_price);
        }
    
        $sql .= " ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset";
    
        return $db->query($sql);
    }           
    
    public static function countFiltered($category_id = null, $keyword = '', $min_price = null, $max_price = null) {
        $db = new DB();
        $sql = "SELECT COUNT(*) as total FROM product WHERE 1";
    
        if ($category_id) {
            $sql .= " AND category_id = " . intval($category_id);
        }
    
        if (!empty($keyword)) {
            $kw = $db->escape("%$keyword%");
            $sql .= " AND name LIKE '$kw'";
        }
    
        if ($min_price !== null) {
            $sql .= " AND price >= " . floatval($min_price);
        }
    
        if ($max_price !== null) {
            $sql .= " AND price <= " . floatval($max_price);
        }
    
        $result = $db->query($sql);
        return $result[0]['total'] ?? 0;
    }       
    
}