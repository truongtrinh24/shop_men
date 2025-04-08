<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Menu with Search Bar</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Header chính -->
    <header id="header">
        <div class="logo">
            <a href="<?php echo _WEB_ROOT; ?>/">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/logo.png" alt="Logo">
            </a>
        </div>

        <!-- Menu -->
        <nav>
            <ul class="menu">
                <li><a href="<?php echo _WEB_ROOT; ?>/">Trang chủ</a></li>
                <li class="dropdown">
                    <a href="<?php echo _WEB_ROOT; ?>/product">Sản phẩm</a>
                    <!-- <ul class="dropdown-menu">
                        <li><a href="#">Áo nam</a></li>
                        <li><a href="#">Quần nam</a></li>
                        <li><a href="#">Phụ kiện</a></li>
                    </ul> -->
                </li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Địa chỉ cửa hàng</a></li>
            </ul>
        </nav>

        <!-- Biểu tượng tìm kiếm, tài khoản, giỏ hàng -->
        <div class="icons">
            <i class="fas fa-search" id="search-icon"></i>
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
            <a href="<?php echo _WEB_ROOT; ?>/carts" class="cart-icon">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count">0</span>
            </a>
        </div>
    </header>

    <!-- Lớp phủ mờ -->
    <div class="search-overlay" id="search-overlay"></div>

    <!-- Thanh tìm kiếm -->
    <div class="search-bar" id="search-bar">
        <!-- Logo -->
        <div class="logo">
            <a href="<?php echo _WEB_ROOT; ?>/">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/logo.png" alt="Logo">
            </a>
        </div>

        <!-- Container chứa ô tìm kiếm và gợi ý -->
        <div class="search-content">
            <!-- Ô tìm kiếm -->
            <div class="search-input-container">
                <input type="text" id="search-input" placeholder="Tìm theo thương hiệu...">
                <i class="fas fa-search"></i>
            </div>

            <!-- Container hiển thị kết quả tìm kiếm -->
            <div class="search-results" id="search-results" style="display: none;">
                <!-- Kết quả tìm kiếm sẽ được thêm động bằng JavaScript -->
            </div>

            <!-- Gợi ý tìm kiếm -->
            <!-- <div class="search-suggestions">
                <a href="#">Áo sơ mi</a>
                <a href="#">Áo polo</a>
                <a href="#">Áo khoác</a>
                <a href="#">Quần dài</a>
                <a href="#">Quần thể thao</a>
            </div> -->
        </div>

        <!-- Biểu tượng -->
        <div class="icons">
            <i class="fas fa-search" id="search-icon-close"></i>
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
    </div>

    <script src="<?php echo _WEB_ROOT; ?>/public/js/search.js"></script>
    <script>
        // Đảm bảo thanh tìm kiếm ẩn khi trang tải
        document.addEventListener('DOMContentLoaded', function () {
            const searchBar = document.querySelector('#search-bar');
            const searchOverlay = document.querySelector('#search-overlay');
            searchBar.style.display = 'none';
            searchOverlay.style.display = 'none';
        });

        // JavaScript cho dropdown tài khoản
        const userIcons = document.querySelectorAll('.user-icon');
        userIcons.forEach(userIcon => {
            const dropdown = userIcon.querySelector('.dropdown-login');

            userIcon.addEventListener('mouseenter', function () {
                dropdown.style.display = 'block';
            });

            userIcon.addEventListener('mouseleave', function () {
                setTimeout(() => {
                    if (!userIcon.matches(':hover') && !dropdown.matches(':hover')) {
                        dropdown.style.display = 'none';
                    }
                }, 100);
            });

            dropdown.addEventListener('mouseenter', function () {
                dropdown.style.display = 'block';
            });

            dropdown.addEventListener('mouseleave', function () {
                dropdown.style.display = 'none';
            });
        });

        // JavaScript cho thanh tìm kiếm
        const searchIcon = document.querySelector('#search-icon');
        const searchIconClose = document.querySelector('#search-icon-close');
        const searchBar = document.querySelector('#search-bar');
        const searchOverlay = document.querySelector('#search-overlay');
        const header = document.querySelector('#header');
        const topBanner = document.querySelector('.top-banner');
        const mainContent = document.querySelector('#main-content');

        function toggleSearchBar() {
            if (searchBar.style.display === 'flex') {
                searchBar.style.display = 'none';
                searchOverlay.style.display = 'none';
                header.classList.remove('blur');
                if (topBanner) topBanner.classList.remove('blur');
                if (mainContent) mainContent.classList.remove('blur');
            } else {
                searchBar.style.display = 'flex';
                searchOverlay.style.display = 'block';
                header.classList.add('blur');
                if (topBanner) topBanner.classList.add('blur');
                if (mainContent) mainContent.classList.add('blur');
            }
        }

        searchIcon.addEventListener('click', function (event) {
            event.stopPropagation();
            toggleSearchBar();
        });

        searchIconClose.addEventListener('click', function (event) {
            event.stopPropagation();
            toggleSearchBar();
        });

        document.addEventListener('click', function (event) {
            if (!searchIcon.contains(event.target) && !searchBar.contains(event.target)) {
                searchBar.style.display = 'none';
                searchOverlay.style.display = 'none';
                header.classList.remove('blur');
                if (topBanner) topBanner.classList.remove('blur');
                if (mainContent) mainContent.classList.remove('blur');
            }
        });

        searchBar.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        searchOverlay.addEventListener('click', function (event) {
            event.stopPropagation();
            searchBar.style.display = 'none';
            searchOverlay.style.display = 'none';
            header.classList.remove('blur');
            if (topBanner) topBanner.classList.remove('blur');
            if (mainContent) mainContent.classList.remove('blur');
        });
        document.addEventListener('DOMContentLoaded', function () {
            console.log("alo");
            const searchInput = document.querySelector('#search-input');
            const searchResults = document.querySelector('#search-results');

            searchInput.addEventListener('input', function () {
                const keyword = this.value.trim();
                if (keyword.length > 0) {
                    // Gửi yêu cầu AJAX
                    fetch(`<?php echo _WEB_ROOT; ?>/search?keyword=${encodeURIComponent(keyword)}`)
                        .then(response => response.json())
                        .then(data => {
                            // Xử lý kết quả tìm kiếm
                            if (data.length > 0) {
                                let html = '';
                                data.forEach(product => {
                                    // Tạo đường dẫn hình ảnh từ image_folder và product_image
                                    const imagePath = product.image_folder && product.product_image
                                        ? `<?php echo _WEB_ROOT; ?>/public/assets/clients/img/${product.image_folder}/${product.product_image}`
                                        : '<?php echo _WEB_ROOT; ?>/public/assets/clients/img/default-product.jpg'; // Hình ảnh mặc định nếu không có

                                    html += `
                                <div class="search-result-item">
                                    <img src="${imagePath}" alt="${product.name}">
                                    <div class="search-result-info">
                                        <p class="product-name">${product.name}</p>
                                        <p class="price">${new Intl.NumberFormat('vi-VN').format(product.price)}đ</p>
                                    </div>
                                </div>
                            `;
                                });
                                searchResults.innerHTML = html;
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML = '<p>Không tìm thấy sản phẩm</p>';
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            searchResults.innerHTML = '<p>Có lỗi xảy ra, vui lòng thử lại</p>';
                            searchResults.style.display = 'block';
                        });
                } else {
                    searchResults.style.display = 'none';
                }
            });

            // Ẩn kết quả tìm kiếm khi click ra ngoài
            document.addEventListener('click', function (event) {
                if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>