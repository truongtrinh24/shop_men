<?php
class DetailProduct extends Controller
{
    public function index()
    {


        $this->data['content'] = 'blocks/clients/DetailProduct';
        $this->data['sub_content'] = [];

        // Render view
        $this->render('layouts/client_layout', $this->data);
    }
    public function detail($id)
    {
        $detail = $this->model('ProductModel');
        $product = $detail->getProductById($id);
        $images = $detail->getProductImages($id);
        if(!$product){
            header("Location: /404");
            exit;
        }        
        $this->data['content'] = 'blocks/clients/DetailProduct';
        $this->data['sub_content']['product'] = $product;
        $this->data['sub_content']['images'] = $images;

        // Render view
        $this->render('layouts/client_layout', $this->data);
    }
}