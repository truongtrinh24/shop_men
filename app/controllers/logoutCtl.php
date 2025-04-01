<?php
session_start();

class LogoutCtl extends Controller
{
    public function index()
    {
        // Xóa session user
        session_unset();
        session_destroy();

        // Bắt đầu session mới để lưu thông báo tạm
        session_start();
        $_SESSION['toastr'] = [
            'type' => 'success',
            'message' => 'Đăng xuất thành công'
        ];

        // Redirect về trang home thay vì render trực tiếp
        header('Location: http://localhost/shop/');
        exit();
    }
}