<?php

class AuthMiddleware extends Middlewares {

    // ❗ Chặn client (role_id = 3)
    public function handle() {
        if (!isset($_SESSION['user_session']) || $_SESSION['user_session']['user']['role_id'] == 3) {
            $response = new Response();
            $response->redirect('home/index');
        }
    }

    // ✅ Chỉ cho phép admin (role_id = 1)
    public static function handleAdmin() {
        if (!isset($_SESSION['user_session']) || $_SESSION['user_session']['user']['role_id'] != 1) {
            $response = new Response();
            $response->redirect('home/index');
        }
    }

    // ✅ Cho phép admin và nhân viên (role_id = 1 hoặc 2)
    public static function handleStaffAndAdmin() {
        if (
            !isset($_SESSION['user_session']) ||
            !in_array($_SESSION['user_session']['user']['role_id'], [1, 2])
        ) {
            $response = new Response();
            $response->redirect('home/index');
        }
    }

    // ✅ Chỉ cho phép khách hàng
    public static function handleGuestOnly() {
        if (
            isset($_SESSION['user_session']) &&
            $_SESSION['user_session']['user']['role_id'] != 3
        ) {
            $response = new Response();
            $response->redirect('home/index');
        }
    }
}
