<?php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $cart = $this->model("cart");
        $categories = $this->model("categories");
        $allCategories = $categories->getAllCategories();
        if(isset($_SESSION['user_session']['user'])) {
            $dataCart = $cart->getNumOfProductInTheCartByUserId($_SESSION['user_session']['user']['account_id']);
            $data['numOfProductInCart'] = $dataCart;
        }
        $data['allCategories'] = $allCategories;
        $data['copyright'] ='Copyright';
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
