<?php
class DangkyCtl extends Controller
{
    public function index()
    {
        $this->data['content'] = 'blocks/clients/register';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    public function HandleRegister()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ho = $_POST['ho'] ?? '';
            $ten = $_POST['ten'] ?? '';
            $sdt = $_POST['sdt'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra dữ liệu đầu vào
            if (empty($ho) || empty($ten) || empty($sdt) || empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            } elseif (strlen($ho . ' ' . $ten) > 255) {
                $error = "Họ và tên không được vượt quá 255 ký tự!";
            } elseif (strlen($sdt) > 20) {
                $error = "Số điện thoại không được vượt quá 20 ký tự!";
            } elseif (strlen($email) > 255) {
                $error = "Email không được vượt quá 255 ký tự!";
            } else {
                $model = $this->model('AccountModel');
                $result = $model->register($ho, $ten, $sdt, $email, $password);
                error_log("Kết quả từ register(): " . print_r($result, true)); // Debug

                if (isset($result['status']) && $result['status'] === true) {
                    $_SESSION['toastr'] = [
                        'type' => 'success',
                        'message' => 'Đăng ký thành công!'
                    ];
                    error_log("Chuyển hướng đến: " . _WEB_ROOT . '/login');
                    header('Location: ' . _WEB_ROOT . '/login');
                    exit();
                } else {
                    $error = $result['message'] ?? 'Đăng ký thất bại! Vui lòng thử lại.';
                    error_log("Đăng ký thất bại cho email: $email - Lý do: " . $error);
                }
            }
        }

        $this->data['content'] = 'blocks/clients/register';
        $this->data['sub_content'] = ['error' => $error];
        $this->render('layouts/client_layout', $this->data);
    }
}