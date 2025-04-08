<?php
class AccountModel {
    private $__conn;

    function __construct() {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
        if (!$this->__conn) {
            throw new Exception("Không thể kết nối đến database!");
        }
    }

    public function register($ho, $ten, $sdt, $email, $password) {
        if (!$this->__conn->begin_transaction()) {
            error_log("Lỗi khi bắt đầu transaction: " . $this->__conn->error);
            return ['status' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại sau!'];
        }

        try {
            // 1. Kiểm tra email
            $stmt = $this->__conn->prepare("SELECT * FROM customer WHERE customer_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $this->__conn->rollback();
                return ['status' => false, 'message' => 'Email đã tồn tại!'];
            }
            $stmt->close();

            // 2. Thêm vào bảng customer
            $customer_name = $ho . ' ' . $ten;
            $stmt = $this->__conn->prepare("INSERT INTO customer (customer_name, customer_phone, customer_email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $customer_name, $sdt, $email);
            if (!$stmt->execute()) {
                $this->__conn->rollback();
                error_log("Lỗi khi thêm vào bảng customer: " . $stmt->error);
                return ['status' => false, 'message' => 'Lỗi khi thêm thông tin khách hàng: ' . $stmt->error];
            }
            $customer_id = $this->__conn->insert_id;
            $stmt->close();

            if (!$customer_id) {
                $this->__conn->rollback();
                error_log("Không lấy được customer_id");
                return ['status' => false, 'message' => 'Lỗi hệ thống, không lấy được customer_id!'];
            }

            // 3. Thêm vào bảng account
            $role_id = 2;
            $status_account = 1;
            $stmt = $this->__conn->prepare("INSERT INTO account (password, role_id, status_account, customer_email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siis", $password, $role_id, $status_account, $email);
            if (!$stmt->execute()) {
                $this->__conn->rollback();
                error_log("Lỗi khi thêm vào bảng account: " . $stmt->error);
                return ['status' => false, 'message' => 'Lỗi khi tạo tài khoản: ' . $stmt->error];
            }
            $account_id = $this->__conn->insert_id;
            $stmt->close();

            if (!$account_id) {
                $this->__conn->rollback();
                error_log("Không lấy được account_id");
                return ['status' => false, 'message' => 'Lỗi hệ thống, không lấy được account_id!'];
            }

            // 4. Cập nhật account_id trong bảng customer
            $stmt = $this->__conn->prepare("UPDATE customer SET account_id = ? WHERE customer_id = ?");
            $stmt->bind_param("ii", $account_id, $customer_id);
            if (!$stmt->execute()) {
                $this->__conn->rollback();
                error_log("Lỗi khi cập nhật account_id trong bảng customer: " . $stmt->error);
                return ['status' => false, 'message' => 'Lỗi khi liên kết tài khoản: ' . $stmt->error];
            }
            $stmt->close();

            // Commit transaction
            if (!$this->__conn->commit()) {
                $this->__conn->rollback();
                error_log("Lỗi khi commit transaction: " . $this->__conn->error);
                return ['status' => false, 'message' => 'Lỗi hệ thống, không thể hoàn tất đăng ký!'];
            }

            return ['status' => true, 'message' => 'Đăng ký thành công!'];
        } catch (Exception $e) {
            $this->__conn->rollback();
            error_log("Lỗi đăng ký: " . $e->getMessage());
            return ['status' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    
}