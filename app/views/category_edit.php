<h2>✏️ Sửa danh mục</h2>
<form method="POST" action="/admin/categories/update/<?= $category['id'] ?>">
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control" value="<?= $category['name'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
