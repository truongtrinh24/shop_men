<?php
class ImportModel {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    // Lấy tất cả các phiếu nhập
    public function getAllImports() {
        $sql = 'SELECT * FROM import ORDER BY date_import DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    // Tạo phiếu nhập mới
    public function createImport($supplier_id, $employee_id, $total) {
        $date_import = (new DateTime())->format('Y-m-d');
        $sql = 'INSERT INTO import (supplier_id, employee_id, date_import, total) VALUES (?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: " . $this->conn->error;
            return false;
        }
        $stmt->bind_param('iisd', $supplier_id, $employee_id, $date_import, $total);
        
        if ($stmt->execute()) {
            $importId = $stmt->insert_id;
            $stmt->close();
            return $importId;
        } else {
            echo "Execution failed: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    // Thêm chi tiết phiếu nhập
    public function addImportDetail($import_id, $product_id, $price) {
        $sql = 'INSERT INTO detail_import (import_id, product_id, price) VALUES (?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iid', $import_id, $product_id, $price);

        if (!$stmt->execute()) {
            echo "Error adding import detail: " . $stmt->error;
            return false;
        }

        $stmt->close();
        return true;
    }

    // Lấy chi tiết 1 phiếu nhập
    public function getImportDetails($import_id) {
        $sql = "SELECT detail_import.*, product.product_name
                FROM detail_import
                JOIN product ON detail_import.product_id = product.product_id
                WHERE detail_import.import_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $import_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = [];
        while($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
        $stmt->close();
        return $details;
    }

    // Cập nhật tổng tiền phiếu nhập
    public function updateImportTotal($import_id, $new_total) {
        $sql = 'UPDATE import SET total = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('di', $new_total, $import_id);

        if (!$stmt->execute()) {
            echo "Error updating total: " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }

    // Xóa 1 phiếu nhập (và tự động xoá luôn chi tiết do ON DELETE CASCADE)
    public function deleteImport($import_id) {
        $sql = 'DELETE FROM import WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $import_id);

        if (!$stmt->execute()) {
            echo "Error deleting import: " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }
}
?>
