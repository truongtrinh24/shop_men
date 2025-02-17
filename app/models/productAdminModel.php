<?php
class ProductAdminModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllProducts($page, $pageSize)
    {
        // Convert $page and $pageSize to integers
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT COUNT(*) as total_records FROM product";
        $result = $this->conn->query($sql);
        $total_records = $result->fetch_assoc()['total_records'];
        $total_page = ceil($total_records / $pageSize);

        $sql = "SELECT * FROM product JOIN categories ON product.category_id = categories.category_id LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return array("data" => $data, "total_page" => $total_page);
        }
        return false;
    }



    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM product JOIN categories ON product.category_id = categories.category_id WHERE product.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function updateProduct($product_id, $product_name, $product_description, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_image)
    {
        $sql = "UPDATE product SET 
        product_image = ?,
        product_name = ?,
        product_description = ?,
        product_ram = ?, 
        product_rom = ?, 
        product_battery = ?, 
        product_screen = ?,
        product_made_in = ?, 
        product_year_produce = ?, 
        product_time_insurance = ?, 
        product_price = ? 
        WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssiiidsiiii", $product_image, $product_name, $product_description, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateProductQuantity()
    {
        $sql = "UPDATE product
                SET quantity = (
                    SELECT COUNT(*) 
                    FROM product_seri 
                    WHERE product_seri.product_id = product.product_id and product_seri.status = 1
                )";

        $result = $this->conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function softProducIncreasing($column, $page, $pageSize)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM product INNER JOIN categories ON product.category_id = categories.category_id ORDER BY $column ASC LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }


    public function softProducDescreasing($column, $page, $pageSize)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM product INNER JOIN categories ON product.category_id = categories.category_id ORDER BY $column DESC LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
    public function searchProduct($keyword, $page)
    {
        $page = (int) $page;
        $pageSize = (int) 4;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT * FROM product 
            INNER JOIN categories ON product.category_id = categories.category_id 
            WHERE product.product_name LIKE '%$keyword%' or categories.category_name LIKE '%$keyword%' or product.product_made_in LIKE '%$keyword%' or product.product_year_produce LIKE '%$keyword%'
            LIMIT $start, $pageSize";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
    public function countProductBySearch($keyword)
    {
        $sql = "SELECT COUNT(*) as total_count FROM product 
            INNER JOIN categories ON product.category_id = categories.category_id 
            WHERE product.product_name LIKE N'%$keyword%' 
            OR categories.category_name LIKE N'%$keyword%' 
            OR product.product_made_in LIKE N'%$keyword%' 
            OR product.product_year_produce LIKE N'%$keyword%'
            OR product.product_ram LIKE N'%$keyword%'
            OR product.product_rom LIKE N'%$keyword%'
            OR product.quantity LIKE N'%$keyword%'
            OR product.product_battery LIKE N'%$keyword%'
            OR product.product_price LIKE N'%$keyword%'
            ";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();
        return $row['total_count'];
    }
    public function deleteProduct($product_id)
    {
        // Kiểm tra xem có tồn tại product_seri nào với product_id cần xóa hay không
        $check_seri_sql = "SELECT COUNT(*) AS count FROM product_seri WHERE product_id = ?";
        $stmt_check_seri = $this->conn->prepare($check_seri_sql);
        $stmt_check_seri->bind_param("i", $product_id);
        $stmt_check_seri->execute();
        $result_check_seri = $stmt_check_seri->get_result();
        $row_seri = $result_check_seri->fetch_assoc();
    
        // Nếu không có product_seri nào liên quan, xóa sản phẩm
        if ($row_seri['count'] == 0) {
            $delete_product_sql = "DELETE FROM product WHERE product_id = ?";
            $stmt_delete_product = $this->conn->prepare($delete_product_sql);
            $stmt_delete_product->bind_param("i", $product_id);
            $stmt_delete_product->execute();
    
            // Kiểm tra số hàng bị ảnh hưởng
            if ($stmt_delete_product->affected_rows > 0) {
                return true; // Xóa thành công sản phẩm
            } else {
                return false; // Không có sản phẩm nào bị xóa
            }
        } else {
            // Chuyển status của product_seri từ 1 sang 2 nếu tồn tại product_seri với status = 1
            $update_seri_sql = "UPDATE product_seri SET status = 2 WHERE product_id = ? AND status = 1";
            $stmt_update_seri = $this->conn->prepare($update_seri_sql);
            $stmt_update_seri->bind_param("i", $product_id);
            $stmt_update_seri->execute();
    
            // Kiểm tra số hàng bị ảnh hưởng
            if ($stmt_update_seri->affected_rows > 0) {
                return true; // Cập nhật thành công product_seri từ status 1 sang 2
            } else {
                return false; // Không có product_seri nào được cập nhật
            }
        }
    }
    
    
}
