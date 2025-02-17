<?php

class Authenticate extends Controller
{

    public $data = [], $model = [];

    public function __construct()
    {
    }

    public function signin()
    {
        if (isset($_SESSION['user_session']['user'])) {
            if ($_SESSION['user_session']['user']['role_id'] == 3) {
                $redirectUrl = 'trang-chu';
            } else {
                $redirectUrl = 'admin';
            }
            $response = new Response();
            $response->redirect($redirectUrl);
        } else {
            $this->render('blocks/clients/signin');
        }
    }

    public function signup()
    {
        if (isset($_SESSION['user_session']['user'])) {
            if ($_SESSION['user_session']['user']['role_id'] == 3) {
                $redirectUrl = 'trang-chu';
            } else {
                $redirectUrl = 'admin';
            }
            $response = new Response();
            $response->redirect($redirectUrl);
        } else {
            $this->render('blocks/clients/signup');
        }
    }


    public function processSignin()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(403);
            exit('Access denied');
        }
        $response = array();
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)) {
            $response += [
                'error_message_username' => 'Vui lòng nhập vào trường này'
            ];
        }

        if (empty($password)) {
            $response += [
                'error_message_password' => 'Vui lòng nhập vào trường này'
            ];
        }
        $user = $this->authenticate_user($username, $password);

        if ($user) {
            $customer = $this->getCustomerById($user['username']);
            $response += [
                'login_success' => 'Đăng nhập thành công',
                'success' => true
            ];

            Session::data('user', $user);

            if ($user['role_id'] == 1) {
                $response += [
                    'redirect_url' => 'http://localhost/shop/admin'
                ];
            } else if ($user['role_id'] == 3) {
                Session::data('customer', $customer);
                $response += [
                    'redirect_url' => 'http://localhost/shop/dien-thoai'
                ];
            } else {
                $response += [
                    'redirect_url' => 'http://localhost/shop/admin'
                ];
            }
            // Thêm dòng này để sử dụng username từ session
            $username = $_SESSION['user_session']['user']['username'];
          
        } else {
            $response += [
                'success' => false,
            ];
            if (!isset($response['error_message_username']) && !isset($response['error_message_password'])) {
                $response += [
                    'error_message' => 'Email hoặc mật khẩu không đúng'
                ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function processSignUp()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(403);
            exit('Access denied');
        }

        $response = [
            'success' => false,
            'error_messages' => [],
        ];

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($name)) {
            $response['error_messages']['name'] = 'Vui lòng nhập vào họ và tên.';
        }


        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (empty($email)) {
            $response['error_messages']['email'] = 'Vui lòng nhập email.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['error_messages']['email'] = 'Email không đúng định dạng.';
        } else if ($this->isEmailExist($email)) {
            $response['error_messages']['email'] = 'Email đã tồn tại.';
        }

        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($address)) {
            $response['error_messages']['address'] = 'Vui lòng nhập vào địa chỉ.';
        }

        $patternPhoneNumber = "/^\d{10};$/";
        $phone = trim($_POST['phone']);
        if (empty($phone)) {
            $response['error_messages']['phone'] = 'Vui lòng nhập vào số điện thoại';
        } else if (preg_match($patternPhoneNumber, $phone)) {
            $response['error_messages']['phone'] = 'Số điện thoại không đúng định dạng';
        }

        if (empty($response['error_messages'])) {
            try {
                $user = $this->model('user');
                $user->addCustomer($name, $address, $phone, $email);
                $response['success'] = true;
                $response['customer_id'] = $user;
                $response['redirect_url'] = 'http://localhost/shop/authenticate/nextStepSignup';
            } catch (Exception $e) {
                $response['error_messages'][] = 'Đã có lỗi trong quá trình đăng ký: ' . $e->getMessage();
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function processSignUpAccount()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(403);
            exit('Access denied');
        }

        $response = [
            'success' => false,
            'error_messages' => [],
        ];

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);


        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($password)) {
            $response['error_messages']['password'] = 'Vui lòng nhập vào mật khẩu.';
        } else if (strlen($password) < 6) {
            $response['error_messages']['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($confirmPassword)) {
            $response['error_messages']['confirmPassword'] = 'Vui lòng nhập lại mật khẩu.';
        } else if ($password !== $confirmPassword) {
            $response['error_messages']['confirmPassword'] = 'Mật khẩu không trùng khớp.';
        }

        if (empty($response['error_messages'])) {
            try {
                $account = $this->model('account');
                $account->addAccount($username, $password, 3, 1);
                $response['success'] = true;
                $response['redirect_url'] = 'http://localhost/shop/authenticate/signin';
            } catch (Exception $e) {
                $response['error_messages'][] = 'Đã có lỗi trong quá trình đăng ký: ' . $e->getMessage();
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function nextStepSignup()
    {
        $user = $this->model('user');
        $customer_id = $user->getNewlyCustomerId();

        $this->data['customer_id'] = $customer_id;
        $this->render('blocks/clients/nextStepSignup', $this->data);
    }


    public function authenticate_user($username, $password)
    {
        $user = $this->model('user');
        $dataUser = $user->getAccountByUsername($username, $password);
        return $dataUser;
    }

    public function getCustomerById($username)
    {
        $user = $this->model('user');
        $customer = $user->getCustomerById($username);
        return $customer;
    }

    public function isEmailExist($email)
    {
        $user = $this->model('user');
        $result = $user->checkEmailCustomerExist($email);
        return $result;
    }

    public function logout()
    {
        Session::delete('user');

        $_SESSION['success_message'] = "Đăng xuất thành công!";
        $response = new Response();
        $response->redirect('authenticate/signin');
    }

    public function getPermissions()
    {
        $role_id = $_GET['role_id'];
        $userModel = $this->model("user");
        $listPermission = $userModel->getPermissionsByRoleId($role_id);

        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "listPermission" => $listPermission));
    }
    public function getAllPermissions()
    {
        $userModel = $this->model("user");
        $listPermission = $userModel->getAllPermissions();

        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "listPermission" => $listPermission));
    }
}
