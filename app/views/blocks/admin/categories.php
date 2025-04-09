<h2>📚 Quản lý danh mục sản phẩm</h2>
<p><a href="/admin/categories/create" class="btn btn-success btn-sm">+ Thêm danh mục</a></p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cate): ?>
            <tr>
                <td><?= $cate['id'] ?></td>
                <td><?= $cate['name'] ?></td>
                <td><?= $cate['created_at'] ?></td>
                <td>
                    <a href="/admin/categories/edit/<?= $cate['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                    <a href="/admin/categories/delete/<?= $cate['id'] ?>" onclick="return confirm('Xoá danh mục này?')" class="btn btn-sm btn-danger">Xoá</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
