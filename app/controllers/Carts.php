<?php
class Carts extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index()
    {
        // Giả lập thông tin tài khoản từ cơ sở dữ liệu
        $userData = [
            'account_id' => 2, // ID của tài khoản từ cơ sở dữ liệu
            'username' => 'kh1',
            'role_id' => 1,
            'status_account' => 1
        ];

        // Thiết lập session
        $_SESSION['user_session']['user'] = $userData;

        // Kiểm tra xem session đã được thiết lập chưa
        if (isset($_SESSION['user_session']['user'])) {
            echo "Đăng nhập ảo thành công!<br>";
        } else {
            echo "Đăng nhập ảo thất bại!<br>";
        }

        $cart = $this->model("cart");
        $dataCart = $cart->getJoinDataCartAndProducts();
        
        // Debug: In ra dữ liệu để kiểm tra
        echo "<pre>";
        print_r($dataCart);  // Thay vì dùng echo, dùng print_r() để xem mảng
        echo "</pre>";
        
        $this->data['content'] = 'blocks/clients/cart';
        $this->data['sub_content']['dataCart'] = $dataCart;
        $this->render('layouts/client_layout', $this->data);
    }

    public function updateQuantity()
    {
        $cart = $this->model("cart");
        $cart_id = (isset($_POST['cart_id'])) ? $_POST['cart_id'] : 0;
        $quantity = (isset($_POST['quantity'])) ? $_POST['quantity'] : 0;
        $product_id = (isset($_POST['product_id'])) ? $_POST['product_id'] : 0;
        $quantityInStock = $cart->checkQuantityProductById($product_id);
        $response = array();
        if ($quantityInStock && $quantityInStock >= $quantity) {
            $cart->updateQuantityOfProductInTheCartByCartId($cart_id, $quantity);
            $dataCart = $cart->getQuantityOfProductInTheCartByCartId($cart_id);
            $response = [
                'success' => true,
                'data' => $dataCart
            ];
        } else {
            $response = [
                'success' => false,
                'data' => $quantityInStock
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }

    public function deleteProductInTheCartById()
    {
        $cart = $this->model("cart");
        $cart_id = $_GET['cart_id'];
        $result = $cart->deleteProductInTheCartById($cart_id);
        $response = new Response();
        $response->redirect('carts');
    }

    public function addToCart()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(403);
            exit('Access denied');
        }

        $response = ['success' => false];

        if (!isset($_SESSION['user_session']['user']['account_id'])) {
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $account_id = isset($_SESSION['user_session']['user']['account_id']) ? $_SESSION['user_session']['user']['account_id'] : null;
        $product_id = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : 1;
        $quantityInStock = $this->model("cart")->checkQuantityInStockByProductById($product_id);
        if ($quantityInStock < $quantity) {
            $response['message_warning'] = 'Số lượng hàng không đủ trong kho';
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $cart = $this->model("cart");

        if ($cart->checkProductExistInCart($account_id, $product_id)) {
            $result = $cart->updateQuantityProduct($account_id, $product_id, $quantity);
            if ($result) {
                $response['success'] = true;
            }
        } else {
            $result = $cart->addToCart($account_id, $product_id, $quantity);
            if ($result) {
                $response['success'] = true;
            }
        }

        $response['message'] = 'Thêm sản phẩm vào giỏ hàng thành công.';

        header('Content-Type: application/json');
        echo json_encode($response);

    }
}