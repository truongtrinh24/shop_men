<h2>👤 Quản lý tài khoản người dùng</h2>
<hr>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['fullname'] ?? 'Ẩn' ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= ($user['role_id'] == 1) ? 'Admin' : 'Khách hàng' ?></td>
                    <td>
                        <?php
                            if ($user['is_active'] == 1)
                                echo '<span class="text-success">Đang hoạt động</span>';
                            else
                                echo '<span class="text-danger">Đã khóa</span>';
                        ?>
                    </td>
                    <td><?= $user['created_at'] ?></td>
                    <td>
                        <?php if ($user['role_id'] != 1): // chỉ cho phép khóa khách hàng ?>
                            <?php if ($user['is_active'] == 1): ?>
                                <a href="/admin/users/lock/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Khoá</a>
                            <?php else: ?>
                                <a href="/admin/users/unlock/<?= $user['id'] ?>" class="btn btn-sm btn-success">Mở khoá</a>
                            <?php endif ?>
                        <?php else: ?>
                            <em>Admin</em>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr><td colspan="7">Không có người dùng nào.</td></tr>
        <?php endif ?>
    </tbody>
</table>
