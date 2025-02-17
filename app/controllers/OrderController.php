<?php
class OrderController extends Controller
{

    public $data = [], $model = [];

    public function __construct()
    {
        // Khởi tạo model hóa đơn để sử dụng trong toàn bộ controller này
        $this->model = $this->model("orderModel"); // Đảm bảo rằng bạn có model tên là 'hoadonadmin'
    }


    public function index()
    { // Lấy thông tin trang hiện tại từ yêu cầu GET
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = 10; // Số lượng đơn hàng trên mỗi trang
        $offset = ($currentPage - 1) * $itemsPerPage;


        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        // Tìm kiếm hóa đơn trong khoảng thời gian, hoặc lấy tất cả nếu không có thời gian cụ thể
        if ($start_date && $end_date) {
            $orders = $this->model->getOrdersByDateRangeWithPagination($start_date, $end_date, $offset, $itemsPerPage);
            $totalOrders = $this->model->countOrdersByDateRange($start_date, $end_date);
        } else {
            $orders = $this->model->getOrdersWithPagination($offset, $itemsPerPage);
            $totalOrders = $this->model->countAllOrders();
        }
        $totalPages = ceil($totalOrders / $itemsPerPage);

        // Đặt dữ liệu và view
        $this->data['content'] = 'blocks/admin/orderView';
        // Phía controller
        $this->data['sub_content'] = [
            'dataorders' => $orders,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ];
        $this->render('layouts/admin_layout', $this->data);
    }


    // Thêm các phương thức khác nếu cần (ví dụ: xem chi tiết hóa đơn, cập nhật, xóa...)
    // Phương thức xử lý yêu cầu xóa hóa đơn
    public function delete($orderId)
    {
        $result = $this->model->deleteOrder($orderId);
        if ($result) {
            // Xóa thành công, bạn có thể chuyển hướng người dùng hoặc hiển thị thông báo
            header('Location: ' . _WEB_ROOT . '/admin/order');
        } else {
            // Xử lý khi không thể xóa hóa đơn
            echo "Không thể xóa hóa đơn.";
        }
    }




    public function edit($orderId)
    {

        // Lấy thông tin đơn hàng hiện tại
        $orderInfo = $this->model->getOrderById($orderId);

        // Kiểm tra xem có tìm thấy đơn hàng không
        if (!$orderInfo) {
            echo "Không tìm thấy đơn hàng.";
            return;
        }

        // Gán dữ liệu đơn hàng vào mảng data để truyền sang view
        $this->data['order_info'] = $orderInfo;

        $this->render('blocks/admin/editOrder', $this->data);
    }

    public function update($orderId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy thông tin đơn hàng hiện tại
            $currentOrder = $this->model->getOrderById($orderId);
            if (!$currentOrder) {
                echo "Không tìm thấy đơn hàng.";
                return;
            }
    
            // Chỉ cho phép cập nhật nếu trạng thái hiện tại là "Chờ Xử Lý" hoặc "Đã Hủy"
            if ($currentOrder['status_order_id'] != 1 && $currentOrder['status_order_id'] != 3) {
                echo "Không thể cập nhật đơn hàng đã 'Đã Xử Lý'.";
                return;
            }
    
            // Không cho phép cập nhật nếu đơn hàng đã bị hủy
            if ($currentOrder['status_order_id'] == 3) {
                echo "Đơn hàng đã hủy không thể thay đổi trạng thái.";
                return;
            }
    
            // Lấy trạng thái mới từ form
            $status_order_id = $_POST['status_order_id']; // Đảm bảo form có trường này
    
            // Lấy tên người dùng từ session
            $username = $_SESSION['user_session']['user']['username'];
    
            // Chuẩn bị dữ liệu để cập nhật
            $orderData = [
                'status_order_id' => $status_order_id,
                'employee_id' => $username  // Lưu tên người dùng làm employee_id
            ];
    
            // Thực hiện cập nhật thông qua model
            $result = $this->model->updateOrder($orderId, $orderData);
            if ($result) {
                // Chuyển hướng đến danh sách đơn hàng sau khi cập nhật thành công
                header('Location: ' . _WEB_ROOT . '/admin/order');
                exit;
            } else {
                // Hiển thị thông báo lỗi
                echo "Có lỗi khi cập nhật hóa đơn. Vui lòng thử lại.";
            }
        } else {
            // Xử lý trường hợp không phải POST request
            echo "Yêu cầu không hợp lệ.";
        }
    }
    



    // chi tiết hóa đơn
    public function getOrderProductDetails($orderId)
    {
        $productDetails = $this->model->getOrderDetails($orderId);

        // Kiểm tra xem có dữ liệu không
        if (!$productDetails) {
            // Xử lý trường hợp không lấy được dữ liệu
            echo "Không thể lấy chi tiết sản phẩm của hóa đơn.";
            return;
        }

        // Nếu có dữ liệu, gán nó vào mảng data và gọi view
        $this->data['product_details'] = $productDetails;
        $this->data['content'] = 'chitietsp';

        $this->render('blocks/admin/chitietsp', $this->data);
        // $this->render('layouts/admin_layout', $this->data); // đảm bảo bạn có layout này
    }
}
