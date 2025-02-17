<?php

use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;

class ImportController extends Controller
{
    public $data = [];
    public function __construct()
    {
    }

    public function index()
    {
        // $pageSize=isset($_GET['pageSize']) ? $_GET['pageSize'] :5;
        // $page=isset($_GET['page']) ? $_GET['page'] : 1;
        // $good_receipt = $this->model('ImportModel');
        // $dataa = $good_receipt->getAllGoodReceipt($page,$pageSize);

        $this->data['content'] = 'blocks/admin/Import/index';
        $this->data['sub_content']['data'] = [];
        $this->render('layouts/admin_layout', $this->data);
        // require_once("app/views/blocks/admin/Import/index.php");
    }
    public function getAllGood()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllGoodReceipt($page, $pageSize);
        $total_data = $good_receipt->totalCount();
        $total_page = ceil($total_data / $pageSize);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "total_page" => $total_page,
                $page,
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function add_supplier()
    {
        $good_receipt = $this->model('ImportModel');
        // $name_supplier,$phone_supplier,$address_supplier,$email_supplier
        $name_supplier = $_POST["name_supplier"];
        $phone_supplier = $_POST["phone_supplier"];
        $address_supplier = $_POST["address_supplier"];
        $email_supplier = $_POST["email_supplier"];
        $data = $good_receipt->add_supplier($name_supplier, $phone_supplier, $address_supplier, $email_supplier);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message" => "thêm nhà cung cấp thành công"
            ), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array(
                "message" => "thêm nhà cung cấp thất bại"
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    public function add_category()
    {
        $good_receipt = $this->model('ImportModel');
        $category_name = $_POST["name_category"];
        $data = $good_receipt->add_category($category_name);

        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message" => "thêm loại sản phẩm thành công"
            ), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array(
                "message" => "thêm loại sản phẩm thất bại"
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    // public function addNewProduct($category_id, $name, $date_insurance, $ram, $rom, $battery, $screen, $made_in, $year_produce, $image)
    public function addNewProduct()
    {
        $category_id = $_POST["category_id"];
        $product_name = $_POST["product_name"];
        $date_insurance = $_POST["date_insurance"];
        $ram = $_POST["ram"];
        $rom = $_POST["rom"];
        $battery = $_POST["battery"];
        $screen = $_POST["screen"];
        $made_in = $_POST["made_in"];
        $year_produce = $_POST["year_produce"];
        $img = $_POST["img"];
        $good_receipt = $this->model('ImportModel');
        $product_id = $good_receipt->addNewProduct($category_id, $product_name, $date_insurance, $ram, $rom, $battery, $screen, $made_in, $year_produce, $img);
        if ($product_id) {
            echo json_encode(array(
                "data" => $product_id,
                "message" => "thêm sản phẩm thành công"
            ), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array(
                "message" => "thêm sản phẩm thất bại"
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    public function getAllSupplier()
    {
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllSupplier();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function getAllCategory()
    {
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllCategories();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message" => "thành công"
            ));
        } else {
            echo "Error";
        }
    }
    public function searchGoodReceipt()
    {
        $keyword = $_POST['searchInput'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->searchGoodReceipt($keyword);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "not found!";
        }
    }
    public function searchGoodReceiptByDate()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->searchGoodReceiptByDate($startDate, $endDate);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "not found!";
        }
    }

    public function ImportGoodReceipt()
    {
        $good_receipt = $this->model('ImportModel');
        $dataSupplier = $good_receipt->getAllSupplier();
        $dataCategory = $good_receipt->getAllCategories();
        $this->data['content'] = 'blocks/admin/Import/ImportGoodReceipt';
        $this->data['sub_content']['dataSupplier'] = $dataSupplier;
        $this->data['sub_content']['dataCategory'] = $dataCategory;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function getAllProducts()
    {
        $keyword = $_POST['searchInput'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllProducts($keyword);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function getAllGoodReceptDetail()
    {
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllGoodReceptDetail();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    //  detail good_receipt
    public function getAllDetailGoodById()
    {
        $id = $_POST["id"];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllDetailGoodById($id);
        $data_good = $good_receipt->getGoodReceipt($id);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "data_good" => $data_good
            ));
        } else {
            echo "Error";
        }
    }
    public function insertGoodReceipt()
    {
        $good_receipt = $this->model('ImportModel');
        $price_percent=$_POST["price_percent"];
        $supplier_id = $_POST["supplier_id"];
        $employee_id = $_POST["employee_id"];
        $date_good_receipt = $_POST["date_good_receipt"];
        $total = $_POST["total"];
        $product_details = $_POST["product_details"];
        $good_receipt_id = $good_receipt->insertGoodReceipt($supplier_id, $employee_id, $date_good_receipt, $total, $product_details,$price_percent);
        if ($good_receipt_id) {
            header('Content-Type: application/json');
            echo json_encode(["success" => "thêm phiếu nhập thành công: " . $good_receipt_id], JSON_UNESCAPED_UNICODE);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "có lỗi khi thêm phiếu nhập: "], JSON_UNESCAPED_UNICODE);
        }
    }
    // header('Content-Type: application/json');
    // echo json_encode(["error" => "Các mã sản phẩm sau không tồn tại trong cơ sở dữ liệu: " . implode(', ', $errorProducts)]);
    public function importExcel()
    {
        $good_receipt = $this->model('ImportModel');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES["excelFile"])) {
                require __DIR__ . '/../../vendor/autoload.php';
                $excelFilePath = $_FILES["excelFile"]["tmp_name"];
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFilePath);
                $worksheet = $spreadsheet->getActiveSheet();

                // Lấy số hàng và cột
                $highestRow = $worksheet->getHighestRow();
                // Bắt đầu từ hàng thứ hai và bỏ qua hàng đầu tiên
                $rowCount = 0;
                $result = [];
                $headers = ["product_id", "product_name", "product_quantity", "price", "seri"];
                $errorProducts = []; // Danh sách các sản phẩm bị lỗi

                foreach ($worksheet->getRowIterator(2, $highestRow) as $row) {
                    $rowData = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $rowData[] = $cell->getValue();
                    }

                    // Kiểm tra nếu mã sản phẩm không tồn tại trong cơ sở dữ liệu
                    $productId = $rowData[0];
                    $id_db = $good_receipt->isProductIdExists($productId);
                    if (!$id_db) {
                        $errorProducts[] = $productId;
                        continue;
                    }
                    $seri = $rowData[4];
                    $seriArray = explode(',', $seri);
                    $seriArray = array_map('trim', $seriArray);
                    $rowData[4] = $seriArray;
                    $result[] = array_combine($headers, $rowData);
                    $rowCount++;
                }
                if (!empty($errorProducts)) {
                    header('Content-Type: application/json');
                    echo json_encode(["error" => "Các mã sản phẩm sau không tồn tại trong cơ sở dữ liệu: " . implode(', ', $errorProducts)]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(["data" => $result]);
                }
            }
        }
    }

    public function exportToPDF()
    {
        // Make sure the invoice data is received from the client
        if (isset($_POST["invoiceData"])) {
            // Include PhpSpreadsheet library
            require __DIR__ . '/../../vendor/autoload.php';

            // Create new instance of PhpSpreadsheet Spreadsheet
            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Your Name')
                ->setTitle('Your Title');

            // Add a new worksheet
            $sheet = $spreadsheet->getActiveSheet();

            // Get invoice data from POST request
            $invoiceData = json_decode($_POST["invoiceData"], true);

            // Set content dynamically using invoice data
            $sheet->setCellValue('A1', 'Invoice ID: ' . $invoiceData['goodId']);
            $sheet->setCellValue('A2', 'Date: ' . $invoiceData['goodDate']);
            $sheet->setCellValue('A3', 'Person: ' . $invoiceData['person']);

            // Set product details
            $row = 5; // Start row for product details
            foreach ($invoiceData['products'] as $product) {
                $sheet->setCellValue('A' . $row, $product['productId']);
                $sheet->setCellValue('B' . $row, $product['productName']);
                $sheet->setCellValue('C' . $row, $product['quantity']);
                $sheet->setCellValue('D' . $row, $product['price']);
                $sheet->setCellValue('E' . $row, $product['total']);
                $row++;
            }

            // Set total quantity, total price, and total products
            $sheet->setCellValue('A' . $row, 'Total Quantity: ' . $invoiceData['totalQuantity']);
            $sheet->setCellValue('A' . ($row + 1), 'Total Price: ' . $invoiceData['totalPrice']);
            $sheet->setCellValue('A' . ($row + 2), 'Total Products: ' . $invoiceData['total_product']);

            // Set up the PDF writer
            $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Tcpdf');

            // Set headers for PDF download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="invoice.pdf"');

            // Save PDF to a variable
            ob_start();
            $writer->save('php://output');
            $pdfData = ob_get_clean();

            // Output PDF content to browser
            echo $pdfData;
        } else {
            // If invoice data is not received, handle the error
            echo "Error: Invoice data not received.";
        }
    }
}

// "product_id" => $rowData[0],
// "product_name" => $rowData[1],
// "product_quantity" => $rowData[2],
// "price" => $rowData[3],
// "seri"=>$rowData[4]

// {
//     data:[
//        {
//         "product_id" :"1",
//         "product_name": "iphone"
//         "product_quantity":"5" ,
//         "price":"5000", 
//         "seri": [
//             TEST1,TEST2,TEST3,TEST4,TEST5
//         ]
//        },
//        {
//         "product_id" :"3",
//         "product_name": "iphone"
//         "product_quantity":"5" ,
//         "price":"5000", 
//         "seri": [
//             TEST3,TEST3,TEST4,TEST5,TEST3
//         ]
//        }

//     ]
// }