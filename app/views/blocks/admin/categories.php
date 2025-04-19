<!-- app/views/blocks/admin/order_detail.php -->
<h2>📋 Chi tiết đơn hàng</h2>
<hr>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
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
