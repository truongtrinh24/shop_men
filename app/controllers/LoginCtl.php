<?php
class LoginCtl extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $this->data['content'] = 'blocks/clients/login';
        $this->data['sub_content'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            // Hiển thị kết quả từ model ngay lập tức
            // echo "<pre>User data from model: " . htmlspecialchars(print_r($user, true)) . "</pre>";

            if ($user) {
                $_SESSION['user'] = [
                    'account_id' => $user['account_id'],
                    'email' => $user['customer_email'],
                    'customer_name' => $user['customer_name'],
                ];
                $_SESSION['toastr'] = [
                    'type' => 'success',
                    'message' => 'đăng nhập thành công!'
                ];
                header('Location: http://localhost/shop/    ');
                exit();
            } else {
                $this->data['sub_content']['error'] = 'Email hoặc mật khẩu không đúng.';
                // Hiển thị thông báo lỗi ngay lập tức
                echo "<p style='color: red;'>Login failed: Email hoặc mật khẩu không đúng.</p>";
            }
        }

        // Hiển thị toàn bộ $this->data trước khi render
        // echo "<pre>Data before render: " . htmlspecialchars(print_r($this->data, true)) . "</pre>";

        // Render layout
        $this->render('layouts/client_layout', $this->data);
    }
}