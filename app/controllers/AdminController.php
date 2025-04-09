<?php
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/account.php';

class AdminController extends Controller
{
    // Trang tổng quan
    public function dashboard()
    {
        AuthMiddleware::handleStaffAndAdmin();

        $stats = [
            'total_products' => ProductModel::countAll(),
            'total_orders' => OrderModel::countAll(),
            'total_customers' => Account::countByRole(3),
            'total_revenue' => OrderModel::getConfirmedRevenue()
        ];

        $monthlyRevenue = OrderModel::getMonthlyRevenue(); // thêm mới

        
        $this->render('blocks/admin/dashboard', [
            'stats' => $stats,
            'monthlyRevenue' => $monthlyRevenue
        ]);
    }

    // Quản lý sản phẩm
    public function products()
    {
        AuthMiddleware::handleStaffAndAdmin();

        $category_id = $_GET['category_id'] ?? null;
        $keyword = $_GET['keyword'] ?? '';
        $min_price = $_GET['min_price'] ?? null;
        $max_price = $_GET['max_price'] ?? null;

        $currentPage = $_GET['page'] ?? 1;
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;

        $categories = CategoryModel::getAll();

        $products = ProductModel::getFiltered($category_id, $keyword, $min_price, $max_price, $perPage, $offset);
        $total = ProductModel::countFiltered($category_id, $keyword, $min_price, $max_price);

        $this->render('blocks/admin/products', [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => ceil($total / $perPage),
            'selectedCategory' => $category_id,
            'keyword' => $keyword,
            'min_price' => $min_price,
            'max_price' => $max_price
        ], 'admin_layout');
    }

    // Quản lý đơn hàng
    public function orders()
    {
        AuthMiddleware::handleAdmin();
        $orders = OrderModel::getAll();
        $this->render('blocks/admin/orders', ['orders' => $orders]);
    }

    // Quản lý tài khoản khách hàng
    public function users()
    {
        AuthMiddleware::handleAdmin();
        $users = AccountModel::getAll();
        $this->render('blocks/admin/users', ['users' => $users]);
    }

    // Tạo thêm, sửa, xóa sản phẩm sẽ bổ sung sau
    // Thêm sản phẩm - form
    public function createProduct()
    {
        AuthMiddleware::handleAdmin();
        $categories = CategoryModel::getAll();
        $this->render('blocks/admin/product_create', ['categories' => $categories], 'admin_layout');
    }


    // Thêm sản phẩm - xử lý form
    public function storeProduct()
    {
        AuthMiddleware::handleAdmin();

        // Xử lý ảnh upload
        $imageName = null;
        if (!empty($_FILES['image_file']['name'])) {
            $imageName = time() . '_' . basename($_FILES['image_file']['name']);
            $uploadPath = 'public/images/' . $imageName;
            move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadPath);
        }

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'product_image' => $imageName, // lưu tên file vào DB
            'category_id' => $_POST['category_id']
        ];

        ProductModel::insert($data);
        (new Response())->redirect('admin/products');
    }

    public function editProduct($id)
    {
        AuthMiddleware::handleAdmin();
        $product = ProductModel::getById($id);
        $categories = CategoryModel::getAll();
        $this->render('blocks/admin/product_edit', ['product' => $product, 'categories' => $categories], 'admin_layout');
    }


    public function updateProduct($id)
    {
        AuthMiddleware::handleAdmin();

        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'image' => $_POST['image'] ?? '',
            'category' => $_POST['category'] ?? ''
        ];

        ProductModel::update($id, $data);

        $response = new Response();
        $response->redirect('admin/products');
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        AuthMiddleware::handleAdmin();
        ProductModel::delete($id);

        $response = new Response();
        $response->redirect('admin/products');
    }

    public function confirmOrder($id)
    {
        AuthMiddleware::handleAdmin();
        OrderModel::updateStatus($id, 'confirmed');

        $response = new Response();
        $response->redirect('admin/orders');
    }

    public function cancelOrder($id)
    {
        AuthMiddleware::handleAdmin();
        OrderModel::updateStatus($id, 'cancelled');

        $response = new Response();
        $response->redirect('admin/orders');
    }

    public function lockUser($id)
    {
        AuthMiddleware::handleAdmin();
        AccountModel::updateStatus($id, 0); // 0 = khóa

        $response = new Response();
        $response->redirect('admin/users');
    }

    public function unlockUser($id)
    {
        AuthMiddleware::handleAdmin();
        AccountModel::updateStatus($id, 1); // 1 = mở
        $response = new Response();
        $response->redirect('admin/users');
    }

    public function categories()
    {
        AuthMiddleware::handleAdmin();
        $categories = CategoryModel::getAll();
        $this->render('blocks/admin/categories', ['categories' => $categories], 'admin_layout');
    }

    public function createCategory()
    {
        AuthMiddleware::handleAdmin();
        $this->render('blocks/admin/category_create', [], 'admin_layout');
    }

    public function storeCategory()
    {
        AuthMiddleware::handleAdmin();
        $data = ['name' => $_POST['name']];
        CategoryModel::insert($data);
        (new Response())->redirect('admin/categories');
    }

    public function editCategory($id)
    {
        AuthMiddleware::handleAdmin();
        $category = CategoryModel::getById($id);
        $this->render('blocks/admin/category_edit', ['category' => $category], 'admin_layout');
    }

    public function updateCategory($id)
    {
        AuthMiddleware::handleAdmin();
        $data = ['name' => $_POST['name']];
        CategoryModel::update($id, $data);
        (new Response())->redirect('admin/categories');
    }

    public function deleteCategory($id)
    {
        AuthMiddleware::handleAdmin();
        CategoryModel::delete($id);
        (new Response())->redirect('admin/categories');
    }


}
