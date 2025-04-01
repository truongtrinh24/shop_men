<div class="container-register">
    <h1>ĐĂNG KÝ TÀI KHOẢN</h1>
    <p>Bạn đã có tài khoản? <a href="<?php echo _WEB_ROOT; ?>/login">Đăng nhập tại đây</a></p>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="<?php echo _WEB_ROOT; ?>/register/handle">
        <h3>THÔNG TIN CÁ NHÂN</h3>
        <div class="form-group">
            <label for="ho">Họ *</label>
            <input type="text" id="ho" name="ho" required>
        </div>
        <div class="form-group">
            <label for="ten">Tên *</label>
            <input type="text" id="ten" name="ten" required>
        </div>
        <div class="form-group">
            <label for="sdt">Số điện thoại *</label>
            <input type="tel" id="sdt" name="sdt" required>
        </div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu *</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-register">Đăng ký</button>
        <p class="alternative-login">Hoặc đăng nhập bằng</p>
        <div class="social-login">
            <button class="btn-google">Đăng nhập Google</button>
            <button class="btn-facebook">Đăng nhập Facebook</button>
        </div>
    </form>
</div>
<div class="support-icon">
    <img src="support-icon.png" alt="Hỗ trợ">
</div>