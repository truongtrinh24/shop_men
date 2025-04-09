<h2>➕ Thêm sản phẩm mới</h2>
<form action="/admin/products/store" method="post" enctype="multipart/form-data">
    <label>Tên sản phẩm:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Giá:</label><br>
    <input type="number" name="price" required><br><br>

    <label>Ảnh sản phẩm (upload):</label><br>
<input type="file" name="image_file" accept="image/*"><br><br>

    <label>Danh mục:</label><br>
    <select name="category_id" class="form-select" required>
        <?php foreach ($categories as $cate): ?>
            <option value="<?= $cate['id'] ?>"><?= $cate['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Lưu</button>
</form>
