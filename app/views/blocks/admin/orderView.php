<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đơn Hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #0a0a23;
        }

        /* Style cải thiện bảng với kích thước chữ to hơn */
        table {
            width: 100%;
            /* Chiều rộng bảng chiếm 90% vùng hiển thị */
            margin: 20px auto;
            /* Canh giữa bảng với phần còn lại */
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            /* Nền trắng */
        }

        thead {
            background-color: #f4f4f4;
            /* Nền xám nhạt cho tiêu đề */
            border-bottom: 2px solid #ddd;
        }

        thead th {
            padding: 14px;
            /* Tăng padding để tăng khoảng cách giữa chữ và đường viền */
            text-align: left;
            font-size: 16px;
            /* Tăng kích thước chữ cho tiêu đề */
            font-weight: bold;
            color: #333;
        }

        tbody tr {
            border-bottom: 1px solid #e2e2e2;
            /* Đường viền giữa các hàng */
        }

        tbody tr:hover {
            background-color: #f9f9f9;
            /* Đổi nền khi hover qua */
        }

        tbody td {
            padding: 14px;
            /* Tăng padding để tạo khoảng trống thoải mái */
            text-align: left;
            font-size: 15px;
            /* Tăng kích thước chữ trong các hàng */
            color: #555;
        }

        .action-column {
            text-align: center;
        }

        .btn-edit,
        .btn-delete,
        .btn-view {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            /* Tăng kích thước chữ cho các nút */
            margin: 0 4px;
            cursor: pointer;
            color: #fff;
        }

        .btn-edit {
            background-color: #ffc107;
            /* Màu vàng */
        }

        .btn-delete {
            background-color: #dc3545;
            /* Màu đỏ */
        }

        .btn-view {
            background-color: #28a745;
            /* Màu xanh lá cây */
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-view:hover {
            background-color: #218838;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-container form {
            display: inline-block;
        }

        .search-container input[type="text"] {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container input[type="submit"] {
            padding: 5px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .btn-add {
            display: inline-block;
            text-decoration: none;
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
        }

        /* css cho form chi tiết  */
        #orderDetails {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            max-width: 600px;
            /* Giới hạn chiều rộng tối đa */
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            /* Bo góc cho khung */
            z-index: 1000;
            display: none;
            /* Ẩn div cho đến khi được gọi */

            /* Đặt giá trị này cao hơn các phần tử khác */
            overflow: visible;

            overflow: auto;
            /* cho phép scroll nếu nội dung quá dài */
            padding-top: 30px;
            /* Thêm đủ không gian cho nút đóng */
        }

        #orderDetails>div {
            margin-bottom: 10px;
            /* Khoảng cách giữa các thông tin */
        }

        /* nút xem chi tiết */
        .btn-view {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            background-color: #f0ad4e;
            /* Màu cam cho nút Xem Chi Tiết */
            color: #fff;
            margin-left: 8px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            /* Đảm bảo văn bản trong nút không bị xuống dòng */
        }

        .btn-view:hover {
            background-color: #ec971f;
            /* Màu sẫm hơn khi hover */
        }


        /* nút đóng chi tiết */
        #orderDetails button {
            padding: 5px 10px;
            border: none;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            font-size: 0.9rem;
            position: relative;
            /* hoặc `absolute` tùy thuộc vào cấu trúc của bạn */
            z-index: 1001;
            /* Giá trị phải lớn hơn z-index của các phần tử khác */

        }

        #orderDetails button:hover {
            background-color: #c82333;
        }


        /* CSS cho phân trang */
        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            margin: 2px;
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            background-color: #f4f4f4;
            color: #007bff;
            cursor: pointer;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }

        .pagination a:hover {
            background-color: #0056b3;
            color: #fff;
        }

        /* Tạo thêm khoảng cách cho phần sidebar */
        .sidebar {
            padding: 20px;
            background-color: #f8f9fa;
            border-right: 2px solid #ddd;
            min-height: 100vh;
        }

        .sidebar a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            color: #007bff;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar h2 {
            text-align: left;
            color: #333;
            margin-bottom: 20px;
        }

    @media print {
   

    .btn-edit, .btn-delete, .btn-view, .search-container, #deleteConfirmationDialog {
        display: none;
    
    }

   

}

        
    </style>
</head>

<body>
    <h2>Danh Sách Hóa Đơn</h2>
    <!-- Trong orderView.php -->

    <div class="search-container">
        <form action="<?php echo _WEB_ROOT; ?>/admin/order" method="get">
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" id="end_date" name="end_date" required>
            <input type="submit" value="Tìm Kiếm">
        </form>
        <!-- <a href="<?php echo _WEB_ROOT; ?>/them-hoa-don" class="btn-add">Thêm Hóa Đơn</a>  -->
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Mã Tài Khoản</th>
                    <th>Mã Nhân Viên</th>
                    <th>Trạng Thái</th> <!-- Tiêu đề cột mới -->
                    <th>Tổng Cộng</th>
                    <th>Ngày Mua</th>
                    <th class="action-column">Hành động</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $dataorders = $data['dataorders'] ?? [];
                $totalPages = $data['totalPages'] ?? 1;
                $currentPage = $data['currentPage'] ?? 1;
                ?>

                <?php


                // Đảm bảo rằng biến $order được truyền vào từ Controller đúng cách
                if (!empty($dataorders)) {

                    foreach ($dataorders as $row) {
                        $employee_id = !empty($row['employee_id']) ? htmlspecialchars($row['employee_id'], ENT_QUOTES, 'UTF-8') : 'IDAuto';
                        $jsonData = htmlspecialchars(json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                        echo "<tr onclick='showDetails($jsonData)'>"; // Thêm sự kiện onclick vào đây
                        echo "<tr>";
                        echo "<td >" . htmlspecialchars($row['order_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['account_id']) . "</td>";
                        echo "<td>" . $employee_id . "</td>";  // "Auto" nếu mã nhân viên trống
                        // Cột trạng thái
                        echo "<td>";
                        switch ($row['status_order_id']) {
                            case 1:
                                echo 'Chờ Xử Lý';
                                break;
                            case 2:
                                echo 'Đã Xử Lý';
                                break;
                            case 3:
                                echo 'Đã Hủy';
                                break;
                            default:
                                echo 'Không xác định'; // Đối với trạng thái không xác định
                        }
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_buy']) . "</td>";

                        // Trong file view, thêm vào cột Hành động cho mỗi dòng hóa đơn
                        echo "<td >";
                        // Thêm nút sửa
                        echo "<a href='" . _WEB_ROOT . "/sua-hoa-don/" . $row['order_id'] . "' class='btn-edit'>Cập nhật</a>";
                        echo "<a href='javascript:void(0);' class='btn-delete' onclick='confirmDeletion(" . $row['order_id'] . "," . $row['status_order_id'] . ")'>Xóa</a>";
                        echo "<a href='javascript:void(0);' class='btn-view' onclick='showDetails(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ")'>Chi Tiết</a>";
                        echo "</td>";

                        // Thêm nút sửa

                    }
                } else {
                    echo "<tr><td colspan='6'>Không có hóa đơn nào.</td></tr>";
                }


                ?>

            </tbody>
        </table>
        <div class="pagination">
            <?php
            // Trang Trước
            if ($currentPage > 1) {
                $previousPage = $currentPage - 1;
                echo "<a href='?page=$previousPage'>&laquo; Trang Trước</a>";
            }

            // Số trang với tên rõ ràng
            for ($page = 1; $page <= $totalPages; $page++) {
                $isActive = $page == $currentPage ? 'class="active"' : '';
                echo "<a href='?page=$page' $isActive>Trang $page</a>";
            }

            // Trang Sau
            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo "<a href='?page=$nextPage'>Trang Sau &raquo;</a>";
            }
            ?>
        </div>

    </div>

    <!---  show chi tiết hóa đơn --->
    <div id="orderDetails" style="display: none; padding: 20px; background-color: white; border: 1px solid #ccc; margin-top: 20px;">
        <!-- Thông tin chi tiết sẽ được thêm vào đây bởi JavaScript -->
        <button onclick="closeDetails()" style="position: absolute; top: 5px; right: 10px; cursor: pointer;">Đóng</button>
        <button onclick="printOrderDetails()" style="position: absolute; top: 5px; right: 10px; cursor: pointer;">In</button>
        <!-- Trong file view, thêm vào cột Hành động cho mỗi dòng hóa đơn -->
    </div>

    <!-- Dialog xác nhận xóa -->
    <div id="deleteConfirmationDialog" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; background-color: white; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); z-index: 1000;">
        <h3 style="margin: 0; padding: 0; text-align: center;">Xác Nhận Xóa</h3>
        <p style="text-align: center;">Bạn có chắc chắn muốn xóa hóa đơn này không?</p>
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <button id="confirmDeleteButton" style="padding: 5px 15px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Yes</button>
            <button onclick="closeDeleteDialog()" style="padding: 5px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">No</button>
        </div>
    </div>



</body>


<script>
    var _WEB_ROOT = '<?php echo _WEB_ROOT; ?>';



    function showOrderProducts(orderId) {
        window.location.href = _WEB_ROOT + '/get-order-products/' + orderId;
    }

    function showDetails(orderData) {
        var detailDiv = document.getElementById('orderDetails');
        var detailsHtml = '<div><strong>Mã Hóa Đơn:</strong> ' + orderData.order_id + '</div>' +
            '<div><strong>Mã Tài Khoản:</strong> ' + orderData.account_id + '</div>' +
            '<div><strong>Mã Nhân Viên:</strong> ' + orderData.employee_id + '</div>' +
            '<div><strong>Tổng Cộng:</strong> ' + orderData.total + '</div>' +
            '<div><strong>Ngày Mua:</strong> ' + orderData.date_buy + '</div>' +
            '<div><strong>Trạng Thái:</strong> ' + getStatusText(orderData.status_order_id) + '</div>';

        // Thêm nút in
        detailsHtml += '<button onclick="printOrderDetails(' + orderData.order_id + ')">In HĐ</button>';

        // Thêm nút Xem Sản Phẩm
        detailsHtml += '<button onclick="showOrderProducts(' + orderData.order_id + ')">Xem Sản Phẩm</button>';

        detailDiv.innerHTML = detailsHtml;
        detailDiv.style.display = 'block';


        // Đảm bảo nút đóng được thêm vào div chi tiết
        var closeButton = document.createElement('button');
        closeButton.textContent = 'Đóng';
        closeButton.onclick = closeDetails;
        closeButton.style = 'position: absolute; top: 5px; right: 10px; cursor: pointer;';
        detailDiv.appendChild(closeButton);

    }


    function printOrderDetails(orderId) {
        var printWindow = window.open('', '', 'height=400,width=600');
        printWindow.document.write('<html><head><title>In Hóa Đơn</title>');
        printWindow.document.write('<link rel="stylesheet" type="text/css" href="your-stylesheet.css">'); // Đảm bảo liên kết với tệp CSS nếu cần
        printWindow.document.write('</head><body>');
        printWindow.document.write(document.getElementById('orderDetails').innerHTML.replace(/<button.*?>.*?<\/button>/g, '')); // Xóa các nút
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }




    // Đảm bảo rằng giá trị trạng thái được xử lý đúng cách
    function getStatusText(statusId) {
        switch (parseInt(statusId)) {
            case 1:
                return 'Chờ Xử Lý';
            case 2:
                return 'Đã Xử Lý';
            case 3:
                return 'Đã Hủy';
            default:
                return 'Không xác định';
        }
    }

    function closeDetails() {
        var detailDiv = document.getElementById('orderDetails');
        detailDiv.style.display = 'none';


    }



    function confirmDeletion(orderId, statusId) {
        if (statusId === 3) { // Assuming 3 is the status ID for "Đã Hủy"
            // Show the confirmation dialog for a canceled order
            deleteUrl = _WEB_ROOT + '/xoa-hoa-don/' + orderId;
            document.getElementById('deleteConfirmationDialog').style.display = 'block';
        } else {
            // Provide other conditions or warnings as necessary
            alert("Chỉ có thể xóa các hóa đơn đã bị hủy.");
        }
    }

    // JavaScript function to close the confirmation dialog
    function closeDeleteDialog() {
        // Hide the confirmation dialog
        document.getElementById('deleteConfirmationDialog').style.display = 'none';
    }

    // JavaScript function to actually perform the deletion
    document.getElementById('confirmDeleteButton').onclick = function() {
        // Redirect to the deletion URL
        window.location.href = deleteUrl;
    };
</script>


</html>