<?php
class orderModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    // load list hóa đơn
    public function getAllorder()
    {
        $sql = "SELECT 
        order_id,
        account_id,
        COALESCE(employee_id, 'IDAuto') AS employee_id,  
        total,
        date_buy
         FROM 
        orders";
        $result = $this->__conn->query($sql);
        $order = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $order[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }
        return $order;
    }


    public function updateOrder($orderId, $orderData)
    {
        $setValues = [];
        foreach ($orderData as $key => $value) {
            $value = $this->__conn->real_escape_string($value);
            $setValues[] = "$key = '$value'";
        }
        $setValuesString = implode(", ", $setValues);

        $sql = "UPDATE `orders` SET $setValuesString WHERE order_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $orderId);
            if ($stmt->execute()) {
                $affectedRows = $stmt->affected_rows;
                $stmt->close();
                return $affectedRows > 0;
            } else {
                error_log("SQL Error: " . $this->__conn->error);
                $stmt->close();
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }


    // Phương thức xóa hóa đơn
    public function deleteOrder($orderId)
    { // Xóa các chi tiết đơn hàng trước
        $deleteDetailSql = "DELETE FROM `detail_order` WHERE order_id = ?";
        $deleteDetailStmt = $this->__conn->prepare($deleteDetailSql);
        if ($deleteDetailStmt) {
            $deleteDetailStmt->bind_param("i", $orderId);
            $deleteDetailStmt->execute();
            $deleteDetailStmt->close();
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            return false;
        }


        // Truy vấn để lấy trạng thái của đơn hàng
        $statusQuery = "SELECT status_order_id FROM `orders` WHERE order_id = ?";
        $statusStmt = $this->__conn->prepare($statusQuery);
        if ($statusStmt) {
            $statusStmt->bind_param("i", $orderId);
            $statusStmt->execute();
            $result = $statusStmt->get_result();
            $order = $result->fetch_assoc();

            // Kiểm tra nếu trạng thái của đơn hàng không phải là "Đã Hủy"
            if ($order['status_order_id'] != 3) { // Giả sử 3 là trạng thái "Đã Hủy"
                // Kiểm tra các trạng thái khác và trả về thông báo tương ứng
                switch ($order['status_order_id']) {
                    case 1: // Giả sử 1 là "Chờ Xử Lý"
                        return "Order is in 'Pending' status and cannot be deleted.";
                    case 2: // Giả sử 2 là "Đã Xử Lý"
                        return "Order is in 'Processed' status and cannot be deleted.";
                        // Bạn có thể thêm nhiều case cho các trạng thái khác nếu cần
                    default:
                        return "Order cannot be deleted due to its current status.";
                }
            }

            // Nếu trạng thái là "Đã Hủy", tiến hành xóa
            $sql = "DELETE FROM `orders` WHERE order_id = ?";
            $stmt = $this->__conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $orderId);
                if ($stmt->execute()) {
                    return $stmt->affected_rows;
                } else {
                    error_log("SQL Error: " . $this->__conn->error);
                    return false;
                }
            } else {
                error_log("Prepare Statement Error: " . $this->__conn->error);
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }



    public function addOrder($orderData)
    {
        // Kiểm tra dữ liệu đầu vào ở đây...

        // Chuẩn bị câu lệnh SQL để chèn dữ liệu
        $stmt = $this->__conn->prepare("INSERT INTO orders (customer_id, employee_id, total, date_buy, status_order_id) VALUES (?, ?, ?, ?, ?)");

        // Ràng buộc tham số status
        $stmt->bind_param(
            "ssdsi",
            $orderData['customer_id'],
            $orderData['employee_id'],
            $orderData['total'],
            $orderData['date_buy'],
            $orderData['status_order_id'] // Giả định bạn có khóa này trong mảng $orderData
        );

        // Thực hiện câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            $stmt->close();
            return $this->__conn->insert_id; // Trả về ID của hóa đơn vừa được thêm
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            $stmt->close();
            return false;
        }
    }

    public function getOrderById($orderId)
    {
        $sql = "SELECT * FROM `orders` WHERE order_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {

            $stmt->bind_param("i", $orderId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                $stmt->close();
                return $order;
            } else {
                error_log("SQL Error: " . $this->__conn->error);
                $stmt->close();
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }


    


    //tìm kiếm
    public function getOrdersByDateRange($start_date, $end_date)
    {
        $sql = "SELECT * FROM `orders` WHERE date_buy BETWEEN ? AND ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            $stmt->close();
            return $orders;
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }

    // chi tiết sp hóa đơn
    public function getOrderDetails($orderId)
    {
        // Truy vấn SQL để lấy chi tiết sản phẩm của đơn hàng
        $sql = "SELECT d.order_id, p.product_id, p.product_name, p.product_price, 
                        p.product_ram, p.product_rom, p.product_screen, p.quantity 
                FROM detail_order AS d
                JOIN product_seri ps ON d.product_seri = ps.product_seri
                JOIN product p ON ps.product_id = p.product_id
                WHERE d.order_id = ?";


        // Chuẩn bị câu truy vấn SQL
        $stmt = $this->__conn->prepare($sql);

        // Kiểm tra xem câu truy vấn có chuẩn bị thành công không
        if (!$stmt) {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }

        // Ràng buộc tham số vào câu truy vấn
        $stmt->bind_param("i", $orderId);

        // Thực hiện câu truy vấn
        $stmt->execute();

        // Lấy kết quả truy vấn
        $result = $stmt->get_result();

        // Mảng để giữ kết quả
        $details = [];

        // Lặp qua từng dòng kết quả và thêm vào mảng chi tiết
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }

        // Đóng câu lệnh đã chuẩn bị
        $stmt->close();

        // Trả về mảng chứa chi tiết sản phẩm
        return $details;
    }


    // Lấy danh sách hóa đơn theo trang
    public function getOrdersWithPagination($offset, $limit)
    {
        $sql = "SELECT * FROM orders LIMIT ?, ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('ii', $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }

    // Đếm tổng số lượng hóa đơn
    public function countAllOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $result = $this->__conn->query($sql);
        $count = $result->fetch_assoc();
        return $count['total'];
    }

    // Tương tự, lấy danh sách theo ngày với phân trang
    public function getOrdersByDateRangeWithPagination($start_date, $end_date, $offset, $limit)
    {
        $sql = "SELECT * FROM orders WHERE date_buy BETWEEN ? AND ? LIMIT ?, ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('ssii', $start_date, $end_date, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }

    // Đếm số lượng hóa đơn theo ngày
    public function countOrdersByDateRange($start_date, $end_date)
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE date_buy BETWEEN ? AND ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('ss', $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc();
        $stmt->close();
        return $count['total'];
    }

   
}
