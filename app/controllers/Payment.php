<?php
class Payment extends Controller
{
    public $data = [];
    protected $model;

    public function __construct()
    {
        $this->model = $this->model("PaymentModel");
    }

    public function index()
    {
        $account_id = isset($_SESSION['user']['account_id']) ? $_SESSION['user']['account_id'] : null;

        if ($account_id) {
            $this->data['sub_content']['customer_name'] = $_SESSION['user']['customer_name'];
            $this->data['sub_content']['customer_email'] = $_SESSION['user']['email'];
            $order_items = $this->model->getCartItems($account_id);
            $this->data['sub_content']['order_items'] = $order_items;

            // Tính tổng tiền tạm tính
            $subtotal = 0;
            foreach ($order_items as $item) {
                $price = (int) str_replace(['.', 'đ'], '', $item['price']);
                $subtotal += $price * $item['quantity'];
            }

            // Thêm phí vận chuyển (ví dụ: 30,000đ nếu tổng < 350,000đ)
            $shipping_fee = ($subtotal < 350000) ? 30000 : 0;

            // Tổng cộng (có thể thêm giảm giá sau)
            $total = $subtotal + $shipping_fee;

            $this->data['sub_content']['subtotal'] = number_format($subtotal, 0, ',', '.') . 'đ';
            $this->data['sub_content']['shipping_fee'] = $shipping_fee > 0 ? number_format($shipping_fee, 0, ',', '.') . 'đ' : '-';
            $this->data['sub_content']['total'] = number_format($total, 0, ',', '.') . 'đ';
        } else {
            $this->data['sub_content']['customer_name'] = 'Khách';
            $this->data['sub_content']['customer_email'] = 'Chưa đăng nhập';
            $this->data['sub_content']['order_items'] = [];
            $this->data['sub_content']['subtotal'] = '0đ';
            $this->data['sub_content']['shipping_fee'] = '-';
            $this->data['sub_content']['total'] = '0đ';
        }

        $this->data['content'] = 'blocks/clients/payment';
        $this->render('layouts/client_layout', $this->data);
    }
    public function complete_order()
    {
        header('Content-Type: application/json');
        try {
            error_log("complete_order called"); // Ghi log khi hàm được gọi

            if (!isset($_SESSION['user']['account_id'])) {
                error_log("User not logged in");
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để đặt hàng']);
                exit;
            }

            $account_id = $_SESSION['user']['account_id'];
            $requestData = json_decode(file_get_contents('php://input'), true);

            if (!$requestData || !isset($requestData['customer_name']) || !isset($requestData['customer_phone']) || !isset($requestData['customer_address']) || !isset($requestData['payment_method'])) {
                error_log("Invalid data: " . json_encode($requestData));
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            // Lấy thông tin từ form
            $customer_name = $requestData['customer_name'];
            $customer_phone = $requestData['customer_phone'];
            $customer_address = $requestData['customer_address'];
            $payment_method = $requestData['payment_method'];

            error_log("Form data - Name: $customer_name, Phone: $customer_phone, Address: $customer_address, Payment: $payment_method");

            // Cập nhật thông tin khách hàng
            $this->model->updateCustomerInfo($account_id, $customer_name, $customer_phone, $customer_address);
            error_log("Customer info updated for account_id: $account_id");

            // Lấy giỏ hàng
            $cart_items = $this->model->getCartItems($account_id);
            if (empty($cart_items)) {
                error_log("Cart is empty for account_id: $account_id");
                echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống']);
                exit;
            }

            // Tính tổng tiền
            $subtotal = 0;
            foreach ($cart_items as $item) {
                $price = (int) str_replace(['.', 'đ'], '', $item['price']);
                $subtotal += $price * $item['quantity'];
            }
            $shipping_fee = ($subtotal < 350000) ? 30000 : 0;
            $total_price = $subtotal + $shipping_fee;

            error_log("Subtotal: $subtotal, Shipping: $shipping_fee, Total: $total_price");

            // Lưu vào bảng orders
            $order_id = $this->model->createOrder($account_id, $total_price, $payment_method);
            error_log("Order created with ID: $order_id");

            // Lưu chi tiết đơn hàng vào order_details
            foreach ($cart_items as $item) {
                $this->model->createOrderDetail($order_id, $item['product_id'], $item['quantity']);
                error_log("Order detail added - Order ID: $order_id, Product ID: {$item['product_id']}, Quantity: {$item['quantity']}");
            }

            // Xóa giỏ hàng sau khi đặt hàng
            $this->model->clearCart($account_id);
            error_log("Cart cleared for account_id: $account_id");

            echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công']);
            exit;
        } catch (Exception $e) {
            error_log("Error in complete_order: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
            exit;
        }
    }
}