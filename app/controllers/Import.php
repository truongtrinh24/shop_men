<?php
class Import extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {

    }

    // Trang danh sách phiếu nhập
    public function index()
    {
        $this->data['content'] = 'blocks/admin/import';
        $this->data['sub_content'] = [];
        $this->render('layouts/admin_layout', $this->data);
    }

    // Lấy tất cả phiếu nhập
    public function getAllImports()
    {
        $model = $this->model('ImportModel');

        $totalImports = $model->getTotalImports();
        $perPage = 10;
        $totalPages = ceil($totalImports / $perPage);

        $imports = $model->getImportsByPage(1, $perPage);

        $this->data['sub_content']['imports'] = $imports;
        $this->data['sub_content']['total_pages'] = $totalPages;
        $this->data['content'] = 'blocks/admin/import';
        $this->render('layouts/admin_layout', $this->data);
    }

    // Lọc phiếu nhập theo ngày, nhà cung cấp, trạng thái
    public function getFilteredImports()
    {
        $model = $this->model('ImportModel');
        $supplierIds = isset($_POST['supplierIds']) ? $_POST['supplierIds'] : [];
        $dateRange = isset($_POST['dateRange']) ? $_POST['dateRange'] : [];
        $status = isset($_POST['status']) ? $_POST['status'] : [];
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $perPage = 10;

        $result = $model->getFiltered
