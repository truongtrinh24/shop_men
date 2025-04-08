document.addEventListener("DOMContentLoaded", function () {
    // Giả lập số lượng sản phẩm trong giỏ hàng
    let cartCount = 0;
    const cartIcon = document.querySelector(".cart-count");

    // Cập nhật giỏ hàng mỗi khi thêm sản phẩm
    function updateCartCount() {
        cartCount++;
        cartIcon.textContent = cartCount;
    }

    // Gán sự kiện (giả lập thêm sản phẩm)
    document.querySelector(".fas.fa-shopping-bag").addEventListener("click", function () {
        updateCartCount();
    });
    // Sao chép mã giảm giá vào clipboard
    function copyCode(btn) {
        const code = btn.previousElementSibling.textContent;
        navigator.clipboard.writeText(code).then(() => {
            alert("Đã sao chép mã: " + code);
        });
    }

});
let slideIndex = 0;
let slides;
let slideInterval;

function showSlides() {
    slides = document.querySelectorAll(".slide");

    if (slides.length < 2) return; // Nếu không có đủ 2 slide, dừng

    slides.forEach((slide, index) => {
        slide.style.opacity = "0";
        slide.style.zIndex = "0";
    });

    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    let currentSlide = slides[slideIndex - 1];
    currentSlide.style.opacity = "1";
    currentSlide.style.zIndex = "1";
}

// Khởi động slider
function startSlider() {
    slideInterval = setInterval(showSlides, 4000);
}

// Dừng slider khi hover vào
function stopSlider() {
    clearInterval(slideInterval);
}

// Khi tải trang, chạy slider
document.addEventListener("DOMContentLoaded", () => {
    let sliderContainer = document.querySelector(".slider-container");

    if (!sliderContainer) return; // Nếu slider không tồn tại, thoát

    showSlides(); // Hiển thị ảnh đầu tiên
    startSlider(); // Bắt đầu chạy

    sliderContainer.addEventListener("mouseenter", stopSlider);
    sliderContainer.addEventListener("mouseleave", startSlider);
});

// Chuyển ảnh bằng nút prev/next
function changeSlide(n) {
    clearInterval(slideInterval); // Dừng auto slide khi click

    slideIndex += n;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    if (slideIndex < 1) {
        slideIndex = slides.length;
    }

    slides.forEach((slide) => {
        slide.style.opacity = "0";
        slide.style.zIndex = "0";
    });

    slides[slideIndex - 1].style.opacity = "1";
    slides[slideIndex - 1].style.zIndex = "1";

    startSlider(); // Chạy lại sau khi click
}

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

