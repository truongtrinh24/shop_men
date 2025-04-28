<h2>📦 Quản lý phiếu nhập</h2>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nhà cung cấp</th>
            <th>Nhân viên nhập</th>
            <th>Tổng tiền</th>
            <th>Ngày nhập</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($imports)): ?>
            <?php foreach ($imports as $import): ?>
                <tr>
                    <td><?= $import['id'] ?></td>
                    <td><?= $import['supplier_name'] ?? '[Chưa có]' ?></td>
                    <td><?= $import['employee_name'] ?? '[Chưa có]' ?></td>
                    <td><?= number_format($import['total']) ?> đ</td>
                    <td><?= $import['date_import'] ?></td>
                    <td>
                        <a href="/admin/imports/view/<?= $import['id'] ?>" class="btn btn-sm btn-primary">Xem chi tiết</a>
                        <a href="/admin/imports/delete/<?= $import['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phiếu nhập này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có phiếu nhập nào.</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
