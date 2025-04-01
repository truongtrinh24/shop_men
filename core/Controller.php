<?php
class Controller{

    public $db;
    public $data = [];

    public function model($model){
        if (file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')){
            require_once _DIR_ROOT.'/app/models/'.$model.'.php';
            if (class_exists($model)){
                $model = new $model();
                return $model;
            }

        }

        return false;
    }

    public function render($view, $data = []) {
        if (!empty(View::$dataShare)) {
            $data = array_merge($data, View::$dataShare);
        }
    
        extract($data);
    
        $contentView = null;
    
        if (preg_match('~^layouts~', $view)) {
            if (file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')) {
                require_once _DIR_ROOT.'/app/views/'.$view.'.php';
            } else {
                echo "Layout not found: " . _DIR_ROOT.'/app/views/'.$view.'.php'; // Thông báo nếu không tìm thấy layout
            }
        } else {
            if (file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')) {
                ob_start(); 
                include _DIR_ROOT.'/app/views/'.$view.'.php';
                $contentView = ob_get_clean(); // Lấy nội dung đã bắt đầu từ đầu
            } else {
                echo "View not found: " . _DIR_ROOT.'/app/views/'.$view.'.php'; // Thông báo nếu không tìm thấy view
            }
    
            echo $contentView; // Hiển thị nội dung
        }
    }
}