<?php
class Carts extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {
        // Có thể khởi tạo model ở đây nếu cần, nhưng để trống theo yêu cầu ban đầu
    }

    public function index()
    {
        // Khởi tạo model Cart
        $cart = $this->model("cart");

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user']['account_id'])) {
            // Nếu chưa đăng nhập, hiển thị giỏ hàng rỗng
            $dataCart = [];
        } else {
            // Lấy account_id từ session
            $account_id = $_SESSION['user']['account_id'];
            // Gọi phương thức lấy dữ liệu giỏ hàng từ model
            $dataCart = $cart->getJoinDataCartAndProducts($account_id);
        }

        // Gán dữ liệu vào view
        $this->data['content'] = 'blocks/clients/cart';
        $this->data['sub_content']['dataCart'] = $dataCart; // Truyền dataCart vào sub_content
        $this->render('layouts/client_layout', $this->data);
    }
    // Phương thức xử lý thêm sản phẩm vào giỏ hàng
    public function add_to_cart()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user']['account_id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!']);
            return;
        }

        // Lấy dữ liệu từ request AJAX
        $requestData = json_decode(file_get_contents('php://input'), true);
        $account_id = $_SESSION['user']['account_id'];
        $product_id = $requestData['product_id'];
        $quantity = $requestData['quantity'];
        $color = $requestData['color'];
        $size = $requestData['size'];

        // Gọi model Cart để thêm sản phẩm
        $cart = $this->model("Cart");
        $result = $cart->addToCart($account_id, $product_id, $quantity, $color, $size);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Thêm vào giỏ hàng thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm vào giỏ hàng!']);
        }
    }

    //xử lý xóa sp ở giỏ hàng
    public function delete_product()
    {
        error_log("Entering delete_product");
        header('Content-Type: application/json');
        try {
            if (!isset($_SESSION['user']['account_id'])) {
                error_log("User not logged in, session: " . print_r($_SESSION, true));
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện']);
                exit;
            }
            error_log("Processing delete for user: " . $_SESSION['user']['account_id']);
            $requestData = json_decode(file_get_contents('php://input'), true);
            error_log("Request data: " . print_r($requestData, true));
            if (!$requestData || !isset($requestData['cart_id'])) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            $cart_id = $requestData['cart_id'];
            $cart = $this->model('Cart');
            $result = $cart->deleteProductInTheCartById($cart_id);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi khi xóa sản phẩm']);
                exit;
            }
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
            exit;
        }
    }
    public function update_quantity()
    {
        header('Content-Type: application/json');
        try {
            if (!isset($_SESSION['user']['account_id'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện']);
                exit;
            }

            $rawData = file_get_contents('php://input');
            error_log("Raw data received: " . $rawData);

            $requestData = json_decode($rawData, true);
            error_log("Decoded data: " . print_r($requestData, true));

            if (!$requestData || !isset($requestData['cart_id']) || !isset($requestData['quantity'])) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            $cart_id = $requestData['cart_id'];
            $quantity = $requestData['quantity'];

            error_log("Updating cart: cart_id=$cart_id, quantity=$quantity");

            $cart = $this->model('Cart');
            $result = $cart->updateQuantityOfProductInTheCartByCartId($cart_id, $quantity);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật số lượng thành công']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi khi cập nhật số lượng']);
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
            exit;
        }
    }
}