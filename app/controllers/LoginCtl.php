<?php
require_once __DIR__ . '/../../core/Controller.php';

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if ($user) {
                var_dump($user);
                $_SESSION['user_session'] = ['user' => $user];


                $_SESSION['toastr'] = [
                    'type' => 'success',
                    'message' => 'Đăng nhập thành công!'
                ];

                // Phân quyền
                if ($user['role_id'] == 1) {
                    header('Location: ' . _WEB_ROOT . '/admin/dashboard');
                } else {
                    header('Location: ' . _WEB_ROOT . '');
                }
                exit();
            } else {
                $this->data['sub_content']['error'] = 'Email hoặc mật khẩu không đúng.';
            }
        }

        $this->render('layouts/client_layout', $this->data);
    }
}
