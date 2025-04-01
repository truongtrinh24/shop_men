<?php
class Home extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {
        // Khởi tạo model sản phẩm
        $this->productModel = $this->model("ProductModel"); // Đảm bảo tên model đúng
    }

    public function index()
    {
        $categories = $this->model("categories");
        
        if (isset($_SESSION['user']['account_id'])) {
            $account_id = $_SESSION['user']['account_id'];
            $cart = $this->model("cart");
            $numOfProduct = $cart->getNumOfProductInTheCartByUserId($account_id);
            $this->data['sub_content']['numOfProductInCart'] = $numOfProduct;
            $this->data['sub_content']['user_email'] = $_SESSION['user']['email'];
            $this->data['sub_content']['customer_name'] = $_SESSION['user']['customer_name'];
        } else {
            $this->data['sub_content']['numOfProductInCart'] = 0;
            $this->data['sub_content']['user_email'] = null;
            $this->data['sub_content']['customer_name'] = null;
        }
        
        // Lấy danh sách danh mục
        $dataCategories = $categories->getAllCategories();
        $this->data['sub_content']['dataCategories'] = $dataCategories;

        // Lấy 6 sản phẩm mới nhất
        $latestProducts = $this->productModel->getLatestProducts(6); // Gọi phương thức lấy sản phẩm mới nhất
        $this->data['sub_content']['latestProducts'] = $latestProducts; // Truyền dữ liệu sản phẩm mới nhất

        $this->data['content'] = 'home/home'; // Đường dẫn đến view
        $this->render('layouts/client_layout', $this->data); // Render view
    }
}