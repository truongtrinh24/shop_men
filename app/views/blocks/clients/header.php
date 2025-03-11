<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Menu</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Header chính -->
    <header>
        <div class="logo">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/logo.png" alt="Logo">
        </div>

        <!-- Menu -->
        <nav>
            <ul class="menu">
                <li><a href="#">SALE</a></li>
                <li class="dropdown">
                    <a href="#">ÁO NAM ▼</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Áo sơ mi</a></li>
                        <li><a href="#">Áo thun</a></li>
                        <li><a href="#">Áo khoác</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">QUẦN NAM ▼</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Quần jeans</a></li>
                        <li><a href="#">Quần kaki</a></li>
                        <li><a href="#">Quần short</a></li>
                    </ul>
                </li>
                <li><a href="#">PHỤ KIỆN</a></li>
                <li><a href="#">ĐỊA CHỈ CỬA HÀNG</a></li>
                <li class="dropdown">
                    <a href="#">HỖ TRỢ ▼</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </li>
                <li><a href="#">ÁO BA LỖ</a></li>
            </ul>
        </nav>

        <!-- Biểu tượng tìm kiếm, tài khoản, giỏ hàng -->
        <div class="icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-user"></i>
            <i class="fas fa-shopping-bag"><span class="cart-count">0</span></i>
        </div>
    </header>
    <!-- phần voucher khuyến mãi -->
    <section class="voucher-section">
        <div class="voucher-card">
            <h3>FREESHIP</h3>
            <p>Miễn phí ship cho đơn hàng từ 350K</p>
            <p><strong>Mã:</strong> <span class="voucher-code">D2SFREESHIP</span></p>
            <button class="copy-btn" onclick="copyCode(this)">Sao chép</button>
        </div>

        <div class="voucher-card expired">
            <h3>GIẢM 5%</h3>
            <p>Giảm giá 5% cho đơn hàng từ 1TR</p>
            <p><strong>Mã:</strong> <span class="voucher-code">D2SOMD5</span></p>
            <p><strong>HSD:</strong> 10/1/2024</p>
            <div class="expired-label">ĐÃ HẾT HẠN</div>
        </div>

        <div class="voucher-card expired">
            <h3>GIẢM 7%</h3>
            <p>Giảm giá 7% cho đơn hàng từ 1.5TR</p>
            <p><strong>Mã:</strong> <span class="voucher-code">D2SOMD7</span></p>
            <p><strong>HSD:</strong> 10/1/2024</p>
            <div class="expired-label">ĐÃ HẾT HẠN</div>
        </div>

        <div class="voucher-card expired">
            <h3>GIẢM 10%</h3>
            <p>Giảm giá 10% cho đơn hàng từ 2TR</p>
            <p><strong>Mã:</strong> <span class="voucher-code">D2SOMD10</span></p>
            <p><strong>HSD:</strong> 10/1/2024</p>
            <div class="expired-label">ĐÃ HẾT HẠN</div>
        </div>
    </section>

</body>

</html>