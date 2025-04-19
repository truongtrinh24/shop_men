<h2>📋 Quản lý đơn hàng</h2>
<hr>

<!-- Internal CSS -->
<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    h2 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #495057;
    }

    table {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    table th, table td {
        padding: 12px;
        text-align: center;
    }

    table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
    }

    table td {
        background-color: #ffffff;
        color: #495057;
    }

    table td a {
        text-decoration: none;
        color: #007bff;
    }

    table td a:hover {
        text-decoration: underline;
    }

    table .text-warning {
        font-weight: bold;
    }

    table .text-success {
        font-weight: bold;
    }

    table .text-danger {
        font-weight: bold;
    }

    table .text-secondary {
        font-weight: bold;
    }

    table .btn {
        margin-right: 10px;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
    }

    table .btn-success {
        background-color: #28a745;
        color: white;
    }

    table .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    table .btn-sm {
        font-size: 12px;
    }

    table em {
        color: #6c757d;
        font-style: italic;
    }

    table tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    hr {
        border-top: 1px solid #ddd;
        margin: 20px 0;
    }
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td>
                        <!-- Liên kết tới trang chi tiết đơn hàng khi bấm vào tên khách hàng -->
                        <a href="/shop/admin/order-detail/<?= $order['id'] ?>"><?= $order['customer_name'] ?? 'Ẩn' ?></a>
                    </td>
                    <td><?= number_format($order['total_price']) ?> đ</td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <?php
                            if ($order['status_order_id'] == 1) {
                                echo '<span class="text-warning">Chờ xử lý</span>';
                            } elseif ($order['status_order_id'] == 2) {
                                echo '<span class="text-success">Đã xác nhận</span>';
                            } elseif ($order['status_order_id'] == 3) {
                                echo '<span class="text-danger">Đã hủy</span>';
                            } else {
                                echo '<span class="text-secondary">Không xác định</span>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php if ($order['status_order_id'] == 1): ?>
                            <a href="/admin/orders/confirm/<?= $order['id'] ?>" class="btn btn-sm btn-success">Xác nhận</a>
                            <a href="/admin/orders/cancel/<?= $order['id'] ?>" class="btn btn-sm btn-danger">Hủy</a>
                        <?php else: ?>
                            <em>Đã xử lý</em>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Không có đơn hàng nào.</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
