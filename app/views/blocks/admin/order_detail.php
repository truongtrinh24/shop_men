<h2>📋 Chi tiết đơn hàng</h2>
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
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orderDetails)): ?>
            <?php foreach ($orderDetails as $detail): ?>
                <tr>
                    <!-- Sử dụng đúng khóa tương ứng với alias trong SQL -->
                    <td><?= isset($detail['order_detail_id']) ? $detail['order_detail_id'] : 'N/A' ?></td>
                    <td><?= isset($detail['product_name']) ? $detail['product_name'] : 'N/A' ?></td>
                    <td><?= isset($detail['order_quantity']) ? $detail['order_quantity'] : 'N/A' ?></td>
                    <td><?= isset($detail['product_price']) ? number_format($detail['product_price']) . ' đ' : 'N/A' ?></td>
                    <td><?= isset($detail['product_price'], $detail['order_quantity']) ? number_format($detail['product_price'] * $detail['order_quantity']) . ' đ' : 'N/A' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Không có chi tiết đơn hàng.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
