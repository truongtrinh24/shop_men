<div class="container-login">
    <h2 class="text-center mt-5">ĐĂNG NHẬP TÀI KHOẢN</h2>
    <p class="text-center">Bạn chưa có tài khoản? <a href="#">Đăng ký tại đây</a></p>
    <!-- Ngay trên hoặc dưới phần thông báo lỗi -->
    <div class="debug-log">
        <?php if (isset($sub_content['debug'])): ?>
            <pre><?php echo htmlspecialchars($sub_content['debug']); ?></pre>
        <?php endif; ?>
    </div>
    <?php if (isset($sub_content['error'])): ?>
        <p class="text-center text-danger"><?php echo htmlspecialchars($sub_content['error']); ?></p>
    <?php endif; ?>
    <form class="mt-4" method="POST" action="/shop/login">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu *</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        <p class="text-center mt-2">Hoặc đăng nhập bằng</p>
        <div class="text-center">
            <button type="button" class="btn btn-danger">Đăng nhập Google</button>
            <button type="button" class="btn btn-primary">Đăng nhập Facebook</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>