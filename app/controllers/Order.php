<?php
class Order extends Controller {
    public $data = [], $model = [];

    public function __construct() {

    }

    public function index() {
        $orders = $this->model("orders");

        if(isset($_SESSION['user_session']['user']['account_id'])) {
            $account_id = $_SESSION['user_session']['user']['account_id'];
            $dataOrders = $orders->getAllOrders($account_id);

            $this->data['content'] = 'blocks/clients/orders';
            $this->data['sub_content']['dataOrders'] = $dataOrders;
            $this->render('layouts/client_layout', $this->data);
        }else {
            $this->data['content'] = 'blocks/clients/orders';
            $this->data['sub_content']['notification'] = 'Vui long đăng nhập để xem đơn hàng';
            $this->render('layouts/client_layout', $this->data);
        }
    }

    public function placeOrder() {
        $cart = $this->model("cart");
        $orders = $this->model("orders");

        $account_id = $_SESSION['user_session']['user']['account_id'];
        $total_amount = $cart->getTotalAmountByUserId($account_id); 
        $order_id = $orders->placeOrder($account_id, $total_amount);
        $cart_items = $cart->getProductsInTheCartByUserId($account_id);
        foreach ($cart_items as $cart_item) {
            $product_series = $orders->getProductSeriByProductId($cart_item['product_id'], $cart_item['quantity']);
            foreach ($product_series as $product_seri) {
                $orders->placeOrderWithItems($order_id, $product_seri['product_seri']);
                $orders->updateStatusProductSeries($product_seri['product_seri']);
            }
            
        }
         $cart->deleteAllProductsInTheCartByUserId($account_id);
         $_SESSION['success_message'] = "Đơn hàng của bạn đã được đặt thành công!";
        $response = new Response();
        $response->redirect('carts');
    }

    public function viewDetailOrder() {
        $orders = $this->model("orders");
        $order_id = $_GET['orderId'];
        $dataDetailOrder = $orders->getDetailOrderByOrderId($order_id);
        header('Content-Type: application/json');
        echo json_encode($dataDetailOrder);
    }

    public function cancelOrder($order_id) {
        $orders = $this->model("orders");
        $orders->cancelOrder($order_id);
        $_SESSION['success_message'] = "Đơn hàng đã được hủy thành công!";
        $response = new Response();
        $response->redirect('order');
    }
}