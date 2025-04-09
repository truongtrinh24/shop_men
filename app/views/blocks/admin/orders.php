<h2>📋 Quản lý đơn hàng</h2>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
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
                    <td><?= $order['customer_name'] ?? 'Ẩn' ?></td>
                    <td><?= $order['product_name'] ?? '[dữ liệu]' ?></td>
                    <td><?= number_format($order['total_price']) ?> đ</td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <?php
                            if ($order['status'] == 'pending') echo '<span class="text-warning">Chờ xử lý</span>';
                            elseif ($order['status'] == 'confirmed') echo '<span class="text-success">Đã xác nhận</span>';
                            elseif ($order['status'] == 'cancelled') echo '<span class="text-danger">Đã hủy</span>';
                        ?>
                    </td>
                    <td>
                        <?php if ($order['status'] == 'pending'): ?>
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
