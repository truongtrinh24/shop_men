<?php
class Product_Admin extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 4;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $products = $this->model("ProductAdminModel");
        $Products = $products->getAllProducts($page, $pageSize);
        $this->data['content'] = 'blocks/admin/product';
        $this->data['sub_content']['dataProduct'] = $Products;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function loadDataProduct()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 4;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $products = $this->model("ProductAdminModel");
        $Products = $products->getAllProducts($page, $pageSize);
        $products->updateProductQuantity();
        header('Content-Type: application/json');
        echo json_encode($Products, $page);
    }

    public function detailProductId()
    {
        $product_id = $_GET['product_id'];
        $productModel = $this->model("ProductAdminModel");
        $product = $productModel->getProductById($product_id);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $product));
    }

    public function deleteProduct()
    {
        $product_id = $_POST['product_id'];
        $productModel = $this->model("ProductAdminModel");
        $product = $productModel->deleteProduct($product_id);
        $productModel->updateProductQuantity();
        if ($product) {
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => "Product updated successfully"
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Failed to update product"
                )
            );
        }
    }
    public function updateProductId()
    {
        $product_id = $_GET['product_id'];
        $productModel = $this->model("ProductAdminModel");
        $product = $productModel->getProductById($product_id);

        header('Content-Type: application/json');
        echo json_encode(array("data" => $product));
    }
    public function softProduct()
    {
        $sizePage = 4;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;

        if (isset($_POST['columnProduct']) && isset($_POST['sortOrderProduct'])) {
            $column = $_POST['columnProduct'];
            $sortOrder = $_POST['sortOrderProduct'];

            // Call model to perform sorting
            $productModel = $this->model("ProductAdminModel");
            if ($sortOrder == 'asc') {
                $products = $productModel->softProducIncreasing($column, $page, $sizePage);
            } else if ($sortOrder == 'desc') {
                $products = $productModel->softProducDescreasing($column, $page, $sizePage);
            }

            if ($products !== false) {
                // Return sorted data as JSON
                header('Content-Type: application/json');
                echo json_encode(array("data" => $products, "current_page" => $page)); // Thay "10" bằng số trang thực tế
            } else {
                // Output JSON response if no products found
                header('Content-Type: application/json');
                echo json_encode(array("error" => "No products found"));
            }
        } else {
            // Output JSON response for missing parameters
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Missing parameters"));
        }
    }

    public function updateProduct()
    {
        $product_id = $_POST['product_id'] ?? null;
        if ($product_id != null) {
            // Lấy dữ liệu từ form gửi lên
            $product_image = $_POST['product_image'];
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_ram = $_POST['product_ram'];
            $product_rom = $_POST['product_rom'];
            $product_battery = $_POST['product_battery'];
            $product_screen = $_POST['product_screen'];
            $product_made_in = $_POST['product_made_in'];
            $product_year_produce = $_POST['product_year_produce'];
            $product_time_insurance = $_POST['product_time_insurance'];
            $product_price = $_POST['product_price'];

            // Tiến hành cập nhật sản phẩm
            $productModel = $this->model("ProductAdminModel");
            $result = $productModel->updateProduct($product_id, $product_name, $product_description, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price,$product_image);
            $productModel->updateProductQuantity();

            // Kiểm tra kết quả và trả về JSON response
            if ($result) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "message" => "Product updated successfully"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "message" => "Failed to update product"
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Product ID not provided"
                )
            );
        }
    }

    public function searchProduct()
    {
        $keyword = $_POST['keyword'] ?? '';
        $sizePage = 4;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        if ($keyword != null) {
            $productModel = $this->model("ProductAdminModel");
            $products = $productModel->searchProduct($keyword, $page, $sizePage);

            if ($products !== false) {
                // Count total products
                $totalProducts = $productModel->countProductBySearch($keyword); // Change to countProductBySearch
            
                // Calculate total pages
                $totalPages = ceil($totalProducts / $sizePage);
            
                // Return JSON response
                header('Content-Type: application/json');
                echo json_encode(array("data" => $products, "current_page" => $page, "total_page" => $totalPages));
            } else {
                // Return JSON response if no products found
                header('Content-Type: application/json');
                echo json_encode("No products found");
            }
            
        } else {
            $productModel = $this->model("ProductAdminModel");
            $Products = $productModel->getAllProducts($page, $sizePage);
            header('Content-Type: application/json');
            echo json_encode($Products, $page);
        }
    }


}