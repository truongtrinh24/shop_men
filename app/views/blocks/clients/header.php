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
            <a href="<?php echo _WEB_ROOT; ?>/">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/logo.png" alt="Logo">
            </a>
        </div>

        <!-- Menu -->
        <nav>
            <ul class="menu">
                <li><a href="#">SALE</a></li>
                <li class="dropdown">
                    <a href="#">ÁO NAM ▼</a>
                    <ul class="dropdown-menu">
                        <?php if (isset($clothesCategories) && is_array($clothesCategories) && count($clothesCategories) > 0): ?>
                            <?php foreach ($clothesCategories as $category): ?>
                                <li><a href="#"><?php echo htmlspecialchars($category['name']); ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="#">Không có danh mục</a></li> <!-- Thêm thông báo nếu không có danh mục -->
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">QUẦN NAM ▼</a>
                    <ul class="dropdown-menu">
                        <?php if (isset($pantsCategories) && is_array($pantsCategories) && count($pantsCategories) > 0): ?>
                            <?php foreach ($pantsCategories as $category): ?>
                                <li><a href="#"><?php echo htmlspecialchars($category['name']); ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="#">Không có danh mục</a></li> <!-- Thêm thông báo nếu không có danh mục -->
                        <?php endif; ?>
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
            <div class="user-icon">
                <i class="fas fa-user"></i>
                <div class="dropdown-login">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?php echo _WEB_ROOT; ?>/account">Tài khoản</a>
                        <a href="<?php echo _WEB_ROOT; ?>/logout">Đăng xuất</a>
                    <?php else: ?>
                        <a href="<?php echo _WEB_ROOT; ?>/login">Đăng nhập</a>
                        <a href="<?php echo _WEB_ROOT; ?>/register">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
            <i class="fas fa-shopping-bag"><span class="cart-count">0</span></i>
        </div>
    </header>
    <script>
        const userIcon = document.querySelector('.user-icon');
        const dropdown = document.querySelector('.dropdown-login');

        userIcon.addEventListener('mouseenter', function () {
            dropdown.style.display = 'block';
        });

        userIcon.addEventListener('mouseleave', function () {
            // Đặt timeout để cho phép thời gian di chuyển chuột vào dropdown
            setTimeout(() => {
                if (!userIcon.matches(':hover') && !dropdown.matches(':hover')) {
                    dropdown.style.display = 'none';
                }
            }, 100); // Thay đổi thời gian nếu cần
        });

        dropdown.addEventListener('mouseenter', function () {
            dropdown.style.display = 'block'; // Giữ dropdown hiển thị khi chuột ở trong
        });

        dropdown.addEventListener('mouseleave', function () {
            dropdown.style.display = 'none'; // Ẩn dropdown khi chuột rời khỏi
        });
    </script>
</body>

</html>