<?php
class thongkeModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    // load list hóa đơn
    public function getthongke($offset, $limit)
    {
        $sql = "SELECT product.product_name, categories.category_name, 
        COUNT(detail_order.product_seri) AS quantity,
        SUM(orders.total) AS total FROM orders 
        JOIN detail_order ON orders.order_id = detail_order.order_id 
        JOIN product_seri ON detail_order.product_seri = product_seri.product_seri 
        JOIN product ON product_seri.product_id = product.product_id
        JOIN categories ON product.category_id = categories.category_id 
        WHERE orders.status_order_id = 2 
        GROUP BY product.product_name, categories.category_name, orders.status_order_id
        ORDER BY product.product_name
        LIMIT ?, ?";


        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $thongke = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $thongke[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }

        $stmt->close();
        return $thongke;
    }
    //tong doanh thu mac dinh
    public function TongDoanhThuKL()
    {
        $sql = "SELECT SUM(total) AS totalRevenue FROM orders WHERE status_order_id = 2";
        $result = $this->__conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['totalRevenue'] ?? 0;
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            return 0;
        }
    }

    public function TongSanPhamKL()
    {
        $sql = "SELECT COUNT(detail_order.product_seri) AS totalProductsSold
                FROM orders
                JOIN detail_order ON orders.order_id = detail_order.order_id
                JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
                JOIN product ON product_seri.product_id = product.product_id
                WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalProductsSold'] : 0;
    }


    //tong doanh thu co loc
    public function getTotalRevenue($start_date, $end_date, $category_name)
    {
        $sql = "SELECT SUM(orders.total) AS totalRevenue
        FROM orders
        JOIN detail_order ON orders.order_id = detail_order.order_id
        JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
        JOIN product ON product_seri.product_id = product.product_id
        JOIN categories ON product.category_id = categories.category_id
        WHERE orders.status_order_id = 2";

        if ($start_date && $end_date) {
            $sql .= " AND orders.date_buy >= ? AND orders.date_buy <= ?";
        }
        if ($category_name) {
            $sql .= " AND categories.category_name = ?";
        }

        $stmt = $this->__conn->prepare($sql);
        $params = [];
        if ($start_date && $end_date) {
            $params[] = $start_date;
            $params[] = $end_date;
        }
        if ($category_name) {
            $params[] = $category_name;
        }
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['totalRevenue'] ?? 0;
    }

    public function getTotalProductsSold($start_date, $end_date, $category_name)
    {
        // Sửa câu truy vấn để đếm số lượng product_seri
        $sql = "SELECT COUNT(detail_order.product_seri) AS totalProductsSold
            FROM orders
            JOIN detail_order ON orders.order_id = detail_order.order_id
            JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
            JOIN product ON product_seri.product_id = product.product_id
            JOIN categories ON product.category_id = categories.category_id
            WHERE orders.status_order_id = 2";

        if ($start_date && $end_date) {
            $sql .= " AND orders.date_buy >= ? AND orders.date_buy <= ?";
        }
        if ($category_name) {
            $sql .= " AND categories.category_name = ?";
        }

        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->__conn->error);
            return 0;
        }

        // Động thái bổ sung các tham số tùy thuộc vào dữ liệu nhập vào
        $params = [];
        $param_types = "";
        if ($start_date && $end_date) {
            $params[] = $start_date;
            $params[] = $end_date;
            $param_types .= "ss"; // Tham số kiểu string cho ngày
        }
        if ($category_name) {
            $params[] = $category_name;
            $param_types .= "s"; // Tham số kiểu string cho danh mục
        }

        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result['totalProductsSold'] ?? 0;
    }


    public function getTotalSalesStaff()
    {
        $sql = "SELECT COUNT(DISTINCT employee_id) AS totalSalesStaff
                FROM orders
                WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalSalesStaff'] : 0;
    }


    public function getTotalAccounts()
    {
        $sql = "SELECT COUNT(DISTINCT account_id) AS totalAccounts
            FROM orders
            WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalAccounts'] : 0;
    }

    // lay loai dth
    public function getCategories()
    {
        $sql = "SELECT category_id, category_name FROM categories";
        $result = $this->__conn->query($sql);
        $categories = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }

        return $categories;
    }


    public function timthongke($start_date, $end_date, $category_name, $offset, $limit)
    {
        // Correct SQL syntax by removing PHP style comments and adjusting line breaks
        $sql = "SELECT 
                product.product_name,
                categories.category_name,
                COUNT(detail_order.product_seri) AS quantity, -- Correctly using SQL comment
                SUM(orders.total) AS total, 
                MIN(orders.date_buy) AS date_buy, 
                orders.status_order_id
            FROM orders
            JOIN detail_order ON orders.order_id = detail_order.order_id
            JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
            JOIN product ON product_seri.product_id = product.product_id
            JOIN categories ON product.category_id = categories.category_id
            WHERE orders.status_order_id = 2";

        // Adding conditions for date and category filters
        if ($start_date && $end_date) {
            $sql .= " AND orders.date_buy BETWEEN ? AND ?";
        }
        if ($category_name) {
            $sql .= " AND categories.category_name = ?";
        }

        // Grouping and ordering results
        $sql .= " GROUP BY product.product_name, categories.category_name, orders.status_order_id";
        $sql .= " ORDER BY product.product_name";
        $sql .= " LIMIT ?, ?";

        // Preparing the SQL statement
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->__conn->error);
            return [];
        }

        // Binding parameters based on the dynamic inputs
        $params = [];
        $param_types = "";
        if ($start_date && $end_date) {
            $params[] = $start_date;
            $params[] = $end_date;
            $param_types .= "ss";
        }
        if ($category_name) {
            $params[] = $category_name;
            $param_types .= "s";
        }
        $params[] = $offset;
        $params[] = $limit;
        $param_types .= "ii";

        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $thongke = [];
        while ($row = $result->fetch_assoc()) {
            $thongke[] = $row;
        }

        $stmt->close();
        return $thongke;
    }


    //bieu do
    public function getMonthlyRevenue()
    {
        $sql = "SELECT MONTH(date_buy) AS month, SUM(total) AS totalRevenue
        FROM orders
        WHERE YEAR(date_buy) = ? AND status_order_id = 2
        GROUP BY MONTH(date_buy)
        ORDER BY MONTH(date_buy)";
    }


    // biểu đồ tròn
    public function getSalesByCategory()
    {
        $sql = "SELECT c.category_name, COUNT(*) AS total_sales
                FROM orders o
                JOIN detail_order do ON o.order_id = do.order_id
                JOIN product_seri ps ON do.product_seri = ps.product_seri
                JOIN product p ON ps.product_id = p.product_id
                JOIN categories c ON p.category_id = c.category_id
                WHERE o.status_order_id = 2
                GROUP BY c.category_name";
        $result = $this->__conn->query($sql);
        $salesByCategory = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $salesByCategory[] = array(
                    'category' => $row['category_name'],
                    'sales' => $row['total_sales']
                );
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }
        return $salesByCategory;
    }


    // Hàm đếm tổng số bản ghi
    public function countThongkeRecords()
    {
        $sql = "SELECT COUNT(*) AS totalRecords FROM orders";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalRecords'] : 0;
    }



    // Lấy thống kê tăng dần, có phân trang
    public function getThongKeAscPaginated($offset, $limit)
    {
        $sql = "SELECT 
        product.product_name,
        categories.category_name,
        COUNT(detail_order.product_seri) AS quantity, 
        SUM(orders.total) AS total, 
        MIN(orders.date_buy) AS date_buy, 
        orders.status_order_id
    FROM orders
    JOIN detail_order ON orders.order_id = detail_order.order_id
    JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
    JOIN product ON product_seri.product_id = product.product_id
    JOIN categories ON product.category_id = categories.category_id
    WHERE orders.status_order_id = 2
    GROUP BY product.product_name, categories.category_name, orders.status_order_id
    ORDER BY SUM(orders.total) ASC
        LIMIT ?, ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $thongke = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $thongke[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }

        $stmt->close();
        return $thongke;
    }


    // Lấy thống kê giảm dần, có phân trang
    public function getThongKeDescPaginated($offset, $limit)
    {
        $sql = "SELECT 
        product.product_name,
        categories.category_name,
        COUNT(detail_order.product_seri) AS quantity,  
        SUM(orders.total) AS total, 
        MIN(orders.date_buy) AS date_buy, 
        orders.status_order_id
    FROM orders
    JOIN detail_order ON orders.order_id = detail_order.order_id
    JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
    JOIN product ON product_seri.product_id = product.product_id
    JOIN categories ON product.category_id = categories.category_id
    WHERE orders.status_order_id = 2
    GROUP BY product.product_name, categories.category_name, orders.status_order_id
    ORDER BY SUM(orders.total) DESC
            LIMIT ?, ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $thongke = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $thongke[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }

        $stmt->close();
        return $thongke;
    }



    // Hàm để lấy danh sách các năm
    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(date_buy) AS year FROM orders ORDER BY year";
        $result = $this->__conn->query($sql);
        $years = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $years[] = $row['year'];
            }
        }
        return $years;
    }




    public function getThongKeNameAsc($offset, $limit)
    {
        $sql = "SELECT 
        product.product_name, 
        categories.category_name, 
        COUNT(detail_order.product_seri) AS quantity, 
        SUM(orders.total) AS total
    FROM orders
    JOIN detail_order ON orders.order_id = detail_order.order_id
    JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
    JOIN product ON product_seri.product_id = product.product_id
    JOIN categories ON product.category_id = categories.category_id 
    WHERE orders.status_order_id = 2
    GROUP BY product.product_name, categories.category_name
    ORDER BY product.product_name ASC
    LIMIT ?, ?";

        return $this->executeSqlWithPagination($sql, $offset, $limit);
    }

    public function getThongKeNameDesc($offset, $limit)
    {
        $sql = "SELECT 
        product.product_name, 
        categories.category_name, 
        COUNT(detail_order.product_seri) AS quantity,
        SUM(orders.total) AS total
    FROM orders
    JOIN detail_order ON orders.order_id = detail_order.order_id
    JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
    JOIN product ON product_seri.product_id = product.product_id
    JOIN categories ON product.category_id = categories.category_id 
    WHERE orders.status_order_id = 2
    GROUP BY product.product_name, categories.category_name
    ORDER BY product.product_name DESC
    LIMIT ?, ?";

        return $this->executeSqlWithPagination($sql, $offset, $limit);
    }


    private function executeSqlWithPagination($sql, $offset, $limit)
    {
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }




    // Trong Model (thongkeModel bieu do cot)
    public function getMonthlyRevenueByYear($year)
    {
        $sql = "SELECT MONTH(date_buy) AS month, SUM(total) AS totalRevenue
            FROM orders
            WHERE YEAR(date_buy) = ? AND status_order_id = 2
            GROUP BY MONTH(date_buy)
            ORDER BY MONTH(date_buy)";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array_fill(0, 12, 0); // Đặt mặc định tất cả các tháng đều là 0

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month'] - 1] = $row['totalRevenue'];
            }
        }

        return $data;
    }
}
