<h2>📦 Quản lý sản phẩm</h2>
<hr>

<!-- Nút thêm sản phẩm mới -->
<p><a href="/admin/products/create" style="color: green;">+ Thêm sản phẩm mới</a></p>

<!-- ✅ Bộ lọc theo danh mục -->
<form method="GET" action="/admin/products" class="mb-3">
    <label>Lọc theo danh mục:</label>
    <select name="category_id" onchange="this.form.submit()" class="form-select" style="width: 300px">
        <option value="">-- Tất cả --</option>
        <?php foreach ($categories as $cate): ?>
            <option value="<?= $cate['id'] ?>" <?= isset($_GET['category_id']) && $_GET['category_id'] == $cate['id'] ? 'selected' : '' ?>>
                <?= $cate['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>
<!-- ✅ PHÂN TRANG -->
<?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination mt-4">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="/admin/products?page=<?= $i ?>
                       <?= $selectedCategory ? '&category_id=' . $selectedCategory : '' ?>
                       <?= $keyword ? '&keyword=' . urlencode($keyword) : '' ?>
                       <?= $min_price ? '&min_price=' . $min_price : '' ?>
                       <?= $max_price ? '&max_price=' . $max_price : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<!-- 🔍 Tìm kiếm + Lọc giá -->
<form method="GET" action="/admin/products" class="mb-3">
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <label>Tên:</label>
        <input type="text" name="keyword" placeholder="Tên sản phẩm" class="form-control" style="width: 200px" value="<?= htmlspecialchars($keyword ?? '') ?>">

        <label>Giá từ:</label>
        <input type="number" name="min_price" class="form-control" style="width: 120px" value="<?= $min_price ?? '' ?>">

        <label>đến</label>
        <input type="number" name="max_price" class="form-control" style="width: 120px" value="<?= $max_price ?? '' ?>">

        <input type="hidden" name="category_id" value="<?= $selectedCategory ?>">
        <button type="submit" class="btn btn-primary">Lọc</button>
    </div>
</form>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= number_format($product['price']) ?> đ</td>
                    <td>
                    <?php if (!empty($product['product_image'])): ?>
    <img src="/public/images/<?= $product['product_image'] ?>" alt="" width="80">
<?php else: ?>
    <em>Không có ảnh</em>
<?php endif; ?>

                    </td>
                    <td><?= $product['category_name'] ?? 'Chưa có' ?></td>
                    <td>
                        <a href="/admin/products/edit/<?= $product['id'] ?>">Sửa</a> |
                        <a href="/admin/products/delete/<?= $product['id'] ?>" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có sản phẩm nào.</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
