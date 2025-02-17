<?php

class AuthMiddleware extends Middlewares {
    public function handle(){
        if($_SESSION['user_session']['user']['role_id'] == 3) {
            $response = new Response();
            $response->redirect('home/index');
        }
    }
}