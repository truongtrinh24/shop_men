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

        // Kiểm tra nếu không tìm thấy sản phẩm thì chuyển hướng đến 404
        if (!$product) {
            header("Location: /404");
            exit;
        }

        // Lấy danh sách màu sắc và kích thước
        $colors = $detail->getProductColors($id);
        $sizes = $detail->getProductSizes($id);
        // Truyền dữ liệu vào view
        $this->data['content'] = 'blocks/clients/DetailProduct';
        $this->data['sub_content']['product'] = $product;
        $this->data['sub_content']['images'] = $images;
        $this->data['sub_content']['colors'] = $colors; // Thêm màu sắc
        $this->data['sub_content']['sizes'] = $sizes;   // Thêm kích thước

        // Render view
        $this->render('layouts/client_layout', $this->data);
    }
}