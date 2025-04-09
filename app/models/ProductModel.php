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

    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $result = $this->__conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về tất cả sản phẩm
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

    public function getProductById($id)
    {
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
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

    public function getProductsByPage($page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage; // Tính vị trí bắt đầu
        $query = "SELECT * FROM product LIMIT ? OFFSET ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("ii", $perPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }

    // Thêm hàm đếm tổng số sản phẩm để tính số trang
    public function getTotalProducts()
    {
        $query = "SELECT COUNT(*) as total FROM product";
        $result = $this->__conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getProductColors($productId)
    {
        $query = "SELECT c.description 
              FROM color c 
              JOIN product_color pc ON c.id = pc.color_id 
              WHERE pc.product_id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $colors = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $colors; // Trả về mảng chứa các màu sắc (description)
    }

    public function getProductSizes($productId)
    {
        $query = "SELECT s.description 
              FROM size s 
              JOIN product_size ps ON s.id = ps.size_id 
              WHERE ps.product_id = ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $sizes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $sizes; // Trả về mảng chứa các kích thước (description)
    }

    // lấy 3 sản phẩm quần short mới nhất
    public function getLatestShorts($limit = 3)
    {
        $query = "SELECT * FROM product WHERE category_id = (SELECT id FROM category WHERE name = 'Quần short') ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về 3 sản phẩm quần short mới nhất
    }

    // Tìm kiếm theo tên sản phẩm
    public function searchProducts($keyword)
    {
        $keyword = '%' . $keyword . '%';
        $query = "SELECT p.id, p.name, p.price, p.product_image, p.image_folder 
              FROM product p 
              WHERE p.name LIKE ? 
              LIMIT 5";
        $stmt = $this->__conn->prepare($query);
        $stmt->bind_param('s', $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    // Lọc sản phẩm linh động
    public function getFilteredProducts($colors = [], $priceRanges = [], $productTypes = [], $page = 1, $perPage = 12)
    {
        $query = "SELECT * FROM product WHERE 1=1";
        $countQuery = "SELECT COUNT(*) as total FROM product WHERE 1=1";
        $params = [];
        $types = "";

        // Lọc màu sắc, khoảng giá, loại sản phẩm
        if (!empty($colors)) {
            $colorConditions = [];
            foreach ($colors as $color) {
                switch ($color) {
                    case 'black':
                        $colorConditions[] = "id IN (SELECT product_id FROM product_color WHERE color_id = (SELECT id FROM color WHERE description = 'Đen'))";
                        break;
                    case 'white':
                        $colorConditions[] = "id IN (SELECT product_id FROM product_color WHERE color_id = (SELECT id FROM color WHERE description = 'Trắng'))";
                        break;
                    case 'beige':
                        $colorConditions[] = "id IN (SELECT product_id FROM product_color WHERE color_id = (SELECT id FROM color WHERE description = 'Kem'))";
                        break;
                }
            }
            if (!empty($colorConditions)) {
                $query .= " AND (" . implode(" OR ", $colorConditions) . ")";
                $countQuery .= " AND (" . implode(" OR ", $colorConditions) . ")";
            }
        }

        if (!empty($priceRanges)) {
            $priceConditions = [];
            foreach ($priceRanges as $range) {
                switch ($range) {
                    case 'under200k':
                        $priceConditions[] = "price < 200000";
                        break;
                    case '200kto300k':
                        $priceConditions[] = "price BETWEEN 200000 AND 300000";
                        break;
                    case '300kto400k':
                        $priceConditions[] = "price BETWEEN 300000 AND 400000";
                        break;
                    case '400kto600k':
                        $priceConditions[] = "price BETWEEN 400000 AND 600000";
                        break;
                    case 'over800k':
                        $priceConditions[] = "price > 800000";
                        break;
                }
            }
            if (!empty($priceConditions)) {
                $query .= " AND (" . implode(" OR ", $priceConditions) . ")";
                $countQuery .= " AND (" . implode(" OR ", $priceConditions) . ")";
            }
        }

        if (!empty($productTypes)) {
            $typePlaceholders = implode(',', array_fill(0, count($productTypes), '?'));
            $query .= " AND category_id IN (SELECT id FROM category WHERE name IN ($typePlaceholders))";
            $countQuery .= " AND category_id IN (SELECT id FROM category WHERE name IN ($typePlaceholders))";
            $types .= str_repeat('s', count($productTypes));
            $params = array_merge($params, $productTypes);
        }

        // Tính tổng số sản phẩm
        $countStmt = $this->__conn->prepare($countQuery);
        if (!empty($params)) {
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result()->fetch_assoc();
        $totalProducts = $countResult['total'];
        $totalPages = ceil($totalProducts / $perPage);

        // Phân trang
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT ? OFFSET ?";
        $types .= "ii";
        $params[] = $perPage;
        $params[] = $offset;

        $stmt = $this->__conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $countStmt->close();

        return [
            'products' => $products,
            'total_pages' => $totalPages
        ];
    }

    // Các phương thức static từ nhánh origin/Vu
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

?>
