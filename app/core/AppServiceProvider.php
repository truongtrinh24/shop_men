<?php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $model = $this->model('ProductModel');

        // Lấy danh mục cho Áo Nam (id_type = 1)
        $clothesCategories = $model->getCategoriesByType(1); // id_type cho Áo Nam
        $pantsCategories = $model->getCategoriesByType(2);
        $data['clothesCategories'] = $clothesCategories;
        $data['pantsCategories'] = $pantsCategories;
        View::share($data);
    }
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
}
