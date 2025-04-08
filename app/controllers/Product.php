<?php
class Product extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {

    }

    public function index()
    {
        // $categories = $this->model("categories");
        // $dataCategories = $categories->getAllCategories();
        $this->data['content'] = 'blocks/clients/product';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    public function getAllProducts()
    {
        $model = $this->model('ProductModel');

        // Lấy tổng số sản phẩm để tính số trang
        $totalProducts = $model->getTotalProducts();
        $perPage = 12;
        $totalPages = ceil($totalProducts / $perPage); // Tính tổng số trang

        // Lấy sản phẩm cho trang đầu tiên (mặc định)
        $products = $model->getProductsByPage(1, $perPage);

        // Gán dữ liệu vào view
        $this->data['sub_content']['products'] = $products;
        $this->data['sub_content']['total_pages'] = $totalPages;
        $this->data['content'] = 'blocks/clients/product';
        $this->render('layouts/client_layout', $this->data);
    }

    public function getFilteredProducts()
    {
        $model = $this->model('ProductModel');
        $colors = isset($_POST['colors']) ? $_POST['colors'] : [];
        $priceRanges = isset($_POST['priceRanges']) ? $_POST['priceRanges'] : [];
        $productTypes = isset($_POST['productTypes']) ? $_POST['productTypes'] : [];
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $perPage = 12;

        $result = $model->getFilteredProducts($colors, $priceRanges, $productTypes, $page, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'products' => $result['products'],
            'total_pages' => $result['total_pages']
        ]);
        exit;
    }
    public function detailProduct($urlProduct)
    {
        $product = $this->model("products");
        $dataProduct = $product->getProductByUrl($urlProduct);
        $this->data['content'] = 'blocks/clients/product-detail';
        $this->data['sub_content']['dataProduct'] = $dataProduct;
        $this->render('layouts/client_layout', $this->data);
    }
    // Hàm xử lý AJAX để lấy sản phẩm theo trang
    public function getProductsByPage()
    {
        $model = $this->model('ProductModel');
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1; // Lấy số trang từ AJAX
        $perPage = 12;

        // Lấy sản phẩm theo trang
        $products = $model->getProductsByPage($page, $perPage);

        // Trả về JSON để AJAX xử lý
        echo json_encode($products);
        exit; // Dừng để không render view
    }

    // tìm kiếm theo tên sản phẩm
    public function search()
    {
        $model = $this->model('ProductModel');
        if (isset($_GET['keyword'])) {
            $keyword = trim($_GET['keyword']);
            $products = $model->searchProducts($keyword);

            // Trả về kết quả dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($products);
        } else {
            echo json_encode([]);
        }
        exit();
    }

}