
<?php
$routes['default_controller'] = 'home';

// Route clients
$routes['chi-tiet-san-pham'] = 'product/detailProduct';
$routes['san-pham'] = 'product/detailProduct';
$routes['register'] = 'DangkyCtl/index';
$routes['login'] = 'LoginCtl/index';
$routes['register/handle'] = 'DangkyCtl/HandleRegister';
$routes['detail/([0-9]+)'] = 'DetailProduct/detail/$1';
$routes['product'] = 'Product/getAllProducts';
//xử lý đăng xuất
$routes['logout'] = 'LogoutCtl/index';
$routes['product/getProductsByPage'] = 'Product/getProductsByPage'; // Thêm dòng này
$routes['account'] = 'UserCtl/account';
$routes['shop/order-detail/([0-9]+)'] = 'UserCtl/orderDetail/$1';

//xử lý tìm kiếm theo tên sản phẩm
$routes['search'] = 'Product/search';

//xử lý lọc linh động
$routes['product/getFilteredProducts'] = 'Product/getFilteredProducts';

//xử lý giỏ hàng
$routes['carts'] = 'Carts/index';
//xử lý số lượng sản phẩm tron giỏ hàng
$routes['carts/update_quantity'] = 'Carts/update_quantity';
//thêm vào giỏ
$routes['addCart'] = 'Carts/add_to_cart';
// xóa sản phẩm trong giỏ
$routes['carts/delete_product'] = 'Carts/delete_product';

//hiển thị giao diện payment
$routes['payment'] = 'Payment/index';
//xử lý chốt đơn
$routes['payment/complete_order'] = 'Payment/complete_order';
//phan quyen
//account
$routes['admin/account'] = 'AccountController';


$routes['admin/customer'] = 'CustomerController';


// Route admin      
// $routes['admin/dashboard'] = 'AdminController/index';
$routes['admin/dashboard'] = 'AdminController/dashboard';
$routes['admin/product'] = 'Product_Admin/index';
$routes['admin/orders'] = 'AdminController/orders';
$routes['admin/order-detail/([0-9]+)'] = 'AdminController/orderDetail/$1';

//phan quyen
$routes['admin/role'] =  'RoleController';

$routes['admin/insurance'] = 'Insurance_Admin/index';
$routes['admin/employee'] = 'Employee_Admin/index';
$routes['admin/import'] = 'ImportController';
//phần hóa đơn

// $routes['admin/order'] = 'OrderController/index';
$routes['xoa-hoa-don/([0-9]+)'] = 'OrderController/delete/$1';
//$routes['them-hoa-don'] = 'OrderController/showAddForm';
$routes['xu-ly-them-hoa-don'] = 'OrderController/add'; 
$routes['sua-hoa-don/([0-9]+)'] = 'OrderController/edit/$1';
$routes['cap-nhat-hoa-don/([0-9]+)'] = 'OrderController/update/$1';
$routes['get-order-products/([0-9]+)'] = 'OrderController/getOrderProductDetails/$1';
//end hóa đơn 


//thống kê

$routes['admin/statistical'] = 'ThongKeController/index';


// nhập hàng
// $routes['admin/import'] = 'ImportController';

//customer
// Admin - sản phẩm
$routes['admin/products'] = 'AdminController@products';

$routes['admin/products/create'] = 'AdminController@createProduct';
$routes['admin/products/store'] = 'AdminController@storeProduct';
$routes['admin/products/edit/{id}'] = 'AdminController@editProduct';
$routes['admin/products/update/{id}'] = 'AdminController@updateProduct';
$routes['admin/products/delete/{id}'] = 'AdminController@deleteProduct';
// $routes['admin/orders/confirm/{id}'] = 'AdminController@confirmOrder';
// $routes['admin/orders/cancel/{id}'] = 'AdminController@cancelOrder';
$routes['admin/users/lock/{id}'] = 'AdminController@lockUser';
$routes['admin/users/unlock/{id}'] = 'AdminController@unlockUser';
$routes['admin/categories'] = 'AdminController@categories';
$routes['admin/categories/create'] = 'AdminController@createCategory';
$routes['admin/categories/store'] = 'AdminController@storeCategory';
$routes['admin/categories/edit/{id}'] = 'AdminController@editCategory';
$routes['admin/categories/update/{id}'] = 'AdminController@updateCategory';
$routes['admin/categories/delete/{id}'] = 'AdminController@deleteCategory';

?>
