<h2>✏️ Sửa sản phẩm</h2>
<form action="/admin/products/update/<?= $product['id'] ?>" method="post">
    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" name="name" value="<?= $product['name'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" class="form-control" name="price" value="<?= $product['price'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="text" class="form-control" name="image" value="<?= $product['image'] ?>">
    </div>

    <div class="mb-3">
    <label>Danh mục:</label><br>
<select name="category_id" class="form-select">
    <?php foreach ($categories as $cate): ?>
        <option value="<?= $cate['id'] ?>" <?= $product['category_id'] == $cate['id'] ? 'selected' : '' ?>>
            <?= $cate['name'] ?>
        </option>
    <?php endforeach; ?>
</select>
<br>
        <input type="text" class="form-control" name="category" value="<?= $product['category'] ?>">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
