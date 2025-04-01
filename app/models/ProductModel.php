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
        $stmt->bind_param("i", $typeId);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = $result->fetch_all(MYSQLI_ASSOC);
        // Kiểm tra dữ liệu trả về
        // if (empty($categories)) {
        //     echo "Không có danh mục nào được tìm thấy cho id_type = " . $typeId; // Thêm thông báo chi tiết
        // } else {
        //     echo "Có " . count($categories) . " danh mục được tìm thấy cho id_type = " . $typeId; // Thêm thông báo chi tiết
        // }
        
        return $categories; // Trả về tất cả danh mục thuộc loại
    }
}