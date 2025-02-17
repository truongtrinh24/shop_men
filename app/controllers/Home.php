<?php

class Home extends Controller
{

    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index()
    {
        $categories = $this->model("categories");
        if(isset($_SESSION['user_session']['user']['account_id'])) {
            $account_id = $_SESSION['user_session']['user']['account_id'];
            $cart = $this->model("cart");
            $numOfProduct = $cart->getNumOfProductInTheCartByUserId($account_id);
            $this->data['sub_content']['numOfProductInCart'] = $numOfProduct;
        }
        
        $dataCategories = $categories->getAllCategories();
        $this->data['content'] = 'home/home';
        $this->data['sub_content']['dataCategories'] = $dataCategories;
        $this->render('layouts/client_layout', $this->data);
    }

}
