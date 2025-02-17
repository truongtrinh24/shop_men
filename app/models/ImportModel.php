<?php
class ImportModel extends Connection
{
    private $connection;
    public function __construct()
    {
        global $db_config;
        $this->connection = Connection::getInstance($db_config);
    }
    // add new product
    // getAll hóa đơn
    public function getAllGoodReceipt($page, $pageSize)
    {
        $start = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM good_receipt g ORDER BY  g.date_good_receipt DESC LIMIT $start, $pageSize";
        $result = $this->connection->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    // lấy tất cả nhà cung cấp
    public function getAllSupplier()
    {
        $sql = "SELECT s.supplier_id,s.supplier_name
        FROM supplier s";
        $result = $this->connection->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    // lấy tất cả loại
    public function getAllCategories()
    {
        $sql = "SELECT c.category_id,c.category_name
        FROM  categories c";
        $result = $this->connection->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    // get quntity
    public function totalCount()
    {
        $sql = "SELECT COUNT(*) AS total FROM good_receipt";
        $result = $this->connection->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
    // search
    public function searchGoodReceipt($keyword)
    {
        $sql = "SELECT g.* ,e.employee_name 
        FROM good_receipt g
        JOIN employee e ON g.employee_id=e.employee_id
        WHERE g.good_receipt_id = ? OR g.employee_id LIKE ? OR e.employee_name LIKE ? LIMIT 5";
        $stmt = $this->connection->prepare($sql);
        $idEmployee = "%" . $keyword . "%";
        $name = "%" . $keyword . "%";
        $idGoodReceipt = intval($keyword);
        $stmt->bind_param("iss", $idGoodReceipt, $idEmployee, $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $goodReceipt = array();
        while ($row = $result->fetch_assoc()) {
            $goodReceipt[] = $row;
        }
        return $goodReceipt;
    }
    public function searchGoodReceiptByDate($startDate, $endDate)
    {
        $sql = "SELECT * FROM good_receipt g WHERE g.date_good_receipt BETWEEN ?
        AND ? LIMIT 5";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $goodReceipt = array();
        while ($row = $result->fetch_assoc()) {
            $goodReceipt[] = $row;
        }
        return $goodReceipt;
    }

    public function getAllProducts($keyword)
    {
        $sql = "SELECT p.product_id, p.product_name,p.category_id, COUNT(ps.product_seri) AS product_count
        FROM product p
        LEFT JOIN product_seri ps ON p.product_id = ps.product_id 
        LEFT JOIN categories c ON p.category_id=c.category_id
        WHERE p.product_name LIKE ? OR p.product_id=? 
        GROUP BY p.product_id, p.product_name LIMIT 5";
        $stmt = $this->connection->prepare($sql);
        $id = intval($keyword);
        $name = "%" . $keyword . "%";
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $goodReceipt = array();
        while ($row = $result->fetch_assoc()) {
            $goodReceipt[] = $row;
        }
        return $goodReceipt;
    }
    public function getAllGoodReceptDetail($keyword)
    {
        $sql = "SELECT *
        FROM product p
        JOIN product_seri s ON p.product_id=s.product_id
        JOIN categories c ON p.category_id = c.category_id
        WHERE p.product_name LIKE ? OR p.product_id=? LIMIT 5";
        $stmt = $this->connection->prepare($sql);
        $name = "%" . $keyword . "%";
        $idGoodReceipt = intval($keyword);
        $stmt->bind_param("is", $idGoodReceipt, $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $goodReceipt = array();
        while ($row = $result->fetch_assoc()) {
            $goodReceipt[] = $row;
        }
        return $goodReceipt;
    }
    public function addNewProduct($category_id, $name, $date_insurance, $ram, $rom, $battery, $screen, $made_in, $year_produce, $image)
    {
        $sql = "INSERT INTO product (category_id, product_name, product_time_insurance, product_ram, product_rom, product_battery, product_screen,  product_made_in, product_year_produce, product_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("isiiiidsis", $category_id, $name, $date_insurance, $ram, $rom, $battery, $screen, $made_in, $year_produce, $image);
        if ($stmt->execute()) {
            $last_insert_id = $stmt->insert_id;
            return array("product_id" => $last_insert_id, "product_name" => $name);
        } else {
            return false;
        }
    }
    // thêm loại sản phẩm
    public function add_category($name_category)
    {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $name_category);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // thêm nhà cung cấp
    public function add_supplier($name_supplier, $phone_supplier, $address_supplier, $email_supplier)
    {
        $sql = "INSERT INTO supplier (supplier_name ,supplier_phone ,supplier_address ,supplier_email) VALUES (?,?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ssss', $name_supplier, $phone_supplier, $address_supplier, $email_supplier);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function insertGoodReceipt($supplier_id, $employee_id, $date_good_receipt, $total, $product_details,$price_percent)
    {

        try {
            // Thêm thông tin phiếu nhập hàng vào bảng good_receipt
            $sql1 = "INSERT INTO good_receipt (supplier_id, employee_id, date_good_receipt, total) VALUES (?, ?, ?, ?)";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bind_param("isss", $supplier_id, $employee_id, $date_good_receipt, $total);
            $stmt1->execute();
            $good_receipt_id = $stmt1->insert_id;

            // Thêm chi tiết sản phẩm vào bảng detail_good_receipt
            $sql2 = "INSERT INTO detail_good_receipt (good_receipt_id, product_id, product_seri, price) VALUES (?, ?, ?, ?)";
            $stmt2 = $this->connection->prepare($sql2);

            foreach ($product_details as $product_detail) {
                $product_id = $product_detail['product_id'];
                $product_seri = $product_detail['product_seri'];
                $price = $product_detail['price'];

                // Thêm product_seri 
                $sql_insert_product_seri = "INSERT IGNORE INTO product_seri (product_seri, product_id,status) VALUES (?, ?,1)";
                $stmt_insert_product_seri = $this->connection->prepare($sql_insert_product_seri);
                $stmt_insert_product_seri->bind_param("si", $product_seri, $product_id);
                $stmt_insert_product_seri->execute();

                // Bind các giá trị và thực thi câu lệnh SQL
                $stmt2->bind_param("iisd", $good_receipt_id, $product_id, $product_seri, $price);
                $stmt2->execute();

                // Cập nhật số lượng sản phẩm trong bảng product
                $sql_update_product_quantity = "UPDATE product SET quantity = quantity + 1,product_price=? WHERE product_id = ?";
                $stmt_update_product_quantity = $this->connection->prepare($sql_update_product_quantity);
                $stmt_update_product_quantity->bind_param("di",$price_percent,$product_id);
                $stmt_update_product_quantity->execute();
            }
            $this->connection->commit();
            return $good_receipt_id;
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }
    public function updateQuantity($product_id, $new_quantity)
    {
        try {
            $sql = "UPDATE product SET quantity = ? WHERE product_id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ii", $new_quantity, $product_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function getAllDetailGoodById($id)
    {
        $sql = "SELECT 
        d.good_receipt_id,
        d.product_id,
        p.product_name,
        d.price,
        COUNT(d.product_seri) AS quantity
        FROM  detail_good_receipt d
        JOIN product p ON d.product_id = p.product_id
        JOIN product_seri ps ON d.product_seri = ps.product_seri
        WHERE d.good_receipt_id = ?
        GROUP BY d.product_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = array();
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
        return $details;
    }
    public function getGoodReceipt($id)
    {
        $sql = "SELECT 
            d.good_receipt_id,
            g.total,
            e.employee_name,
            g.date_good_receipt,
            COUNT(DISTINCT d.product_seri) AS quantity_sum,
            COUNT(DISTINCT p.product_id) AS mathang
        FROM  
            detail_good_receipt d
        JOIN 
            product_seri ps ON d.product_seri = ps.product_seri
        JOIN 
            product p ON ps.product_id = p.product_id
        JOIN 
            good_receipt g ON d.good_receipt_id = g.good_receipt_id
        JOIN 
            employee e ON g.employee_id = e.employee_id
        WHERE 
            d.good_receipt_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    public function isProductIdExists($productId)
    {
        $sql = "SELECT COUNT(*) AS total FROM product WHERE product_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            // Xử lý lỗi, có thể là log lỗi hoặc trả về false
            return false;
        }
        
        $row = $result->fetch_assoc();
        $total = $row['total'];
        
        return $total > 0; 
    }
    
}
