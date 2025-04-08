<?php
class UserCtl extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        $this->data['content'] = 'blocks/clients/user';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    public function account()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user']['account_id'])) {
            header("Location: /shop/login");
            exit;
        }
    
        $model = $this->model('user');
        $accountId = $_SESSION['user']['account_id'];

        // Lấy thông tin khách hàng
        $customerInfo = $model->getCustomerByAccountId($accountId);
        if (!$customerInfo) {
            echo "Không tìm thấy thông tin khách hàng.";
            return;
        }

        // Lấy danh sách đơn hàng
        $orders = $model->getOrdersByAccountId($accountId);

        // Truyền dữ liệu vào view
        $this->data['sub_content']['customerInfo'] = $customerInfo;
        $this->data['sub_content']['orders'] = $orders; // Truyền danh sách đơn hàng
        $this->data['content'] = 'blocks/clients/user';
        $this->render('layouts/client_layout', $this->data);
    }
    public function orderDetail($orderId)
    {
        $model = $this->model('User');
        $orderDetails = $model->getOrderDetails($orderId);

        if (!$orderDetails) {
            // Trả về lỗi nếu không tìm thấy đơn hàng
            http_response_code(404);
            echo json_encode(['error' => 'Không tìm thấy đơn hàng']);
            exit;
        }

        // Trả về dữ liệu dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($orderDetails);
        exit;
    }
}