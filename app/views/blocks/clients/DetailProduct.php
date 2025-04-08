<div class="product-container">
    <div class="product-images">
        <div class="main-image">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($product['image_folder']); ?>/<?php echo htmlspecialchars($product['product_image']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="thumbnail-images">
            <?php if (isset($images) && is_array($images)): ?>
                <?php foreach ($images as $image): ?>
                    <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($image['image_url']); ?>"
                        alt="Thumbnail">
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có hình ảnh nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="product-details">
        <div class="product-header">
            <span class="new-label">New</span>
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <span class="product-code">Mã sản phẩm: <?php echo htmlspecialchars($product['id']); ?></span>
        </div>

        <div class="price-section">
            <span class="price"><?php echo number_format($product['price'], 0, ',', '.') . '₫'; ?></span>
        </div>

        <div class="discount-input">
            <input type="text" placeholder="Mã giảm giá">
            <button>Áp dụng</button>
        </div>

        <div class="color-size-selection">
            <!-- Dòng text hiển thị thông tin lựa chọn -->
            <div class="selection-info">
                <span id="selected-info">Vui lòng chọn màu và kích thước</span>
            </div>

            <div class="color-selection">
                <span>Màu sắc:</span>
                <div class="colors">
                    <?php if (!empty($colors)): ?>
                        <?php foreach ($colors as $color): ?>
                            <label class="color-option">
                                <input type="radio" name="color" value="<?php echo htmlspecialchars($color['description']); ?>"
                                    data-color="<?php echo htmlspecialchars($color['description']); ?>">
                                <span class="color-circle"
                                    style="background-color: <?php echo $color['description'] === 'Trắng' ? '#FFFFFF' : ($color['description'] === 'Đen' ? '#000000' : ($color['description'] === 'Kem' ? '#FFEFD5' : '#000000')); ?>; border: 1px solid #ddd;"></span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có màu sắc nào.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="size-selection">
                <span>Kích thước:</span>
                <div class="sizes">
                    <?php if (!empty($sizes)): ?>
                        <?php foreach ($sizes as $size): ?>
                            <label class="size-option">
                                <input type="radio" name="size" value="<?php echo htmlspecialchars($size['description']); ?>"
                                    data-size="<?php echo htmlspecialchars($size['description']); ?>">
                                <span class="size-circle"><?php echo htmlspecialchars($size['description']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có kích thước nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="addtocart" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
            <div class="quantity">
                <button id="decrease-btn">-</button>
                <span id="quantity-value">1</span>
                <button id="increase-btn">+</button>
            </div>
            <button class="add-to-cart-btn">THÊM VÀO GIỎ</button>
            <button class="buy-now-btn">MUA NGAY</button>
        </div>

        <div class="shipping-info">
            <p>Miễn phí vận chuyển đơn hàng từ 350K</p>
            <p>Đổi trả nhanh chóng</p>
            <p>Thanh toán dễ dàng</p>
        </div>
    </div>
</div>

<!-- Thêm JavaScript vào cuối file HTML -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorInputs = document.querySelectorAll('input[name="color"]');
        const sizeInputs = document.querySelectorAll('input[name="size"]');
        const selectedInfo = document.getElementById('selected-info');
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const quantityValue = document.getElementById('quantity-value');
        const increaseBtn = document.getElementById('increase-btn');
        const decreaseBtn = document.getElementById('decrease-btn');
        const productId = <?php echo json_encode($product['id']); ?>;

        let selectedColor = '';
        let selectedSize = '';
        let quantity = parseInt(quantityValue.textContent) || 1;

        // Hàm cập nhật thông tin lựa chọn
        function updateSelectionInfo() {
            if (selectedColor && selectedSize) {
                selectedInfo.textContent = `Màu: ${selectedColor}, Kích thước: ${selectedSize}`;
            } else if (selectedColor) {
                selectedInfo.textContent = `Màu: ${selectedColor}, Vui lòng chọn kích thước`;
            } else if (selectedSize) {
                selectedInfo.textContent = `Kích thước: ${selectedSize}, Vui lòng chọn màu`;
            } else {
                selectedInfo.textContent = 'Vui lòng chọn màu và kích thước';
            }
        }

        // Xử lý khi chọn màu
        colorInputs.forEach(input => {
            input.addEventListener('change', function () {
                selectedColor = this.getAttribute('data-color');
                updateSelectionInfo();
            });
        });

        // Xử lý khi chọn kích thước
        sizeInputs.forEach(input => {
            input.addEventListener('change', function () {
                selectedSize = this.getAttribute('data-size');
                updateSelectionInfo();
            });
        });

        // Hàm xử lý tăng số lượng
        function increaseHandler() {
    console.log('Before increase - quantityValue.textContent:', quantityValue.textContent);
    let currentQuantity = parseInt(quantityValue.textContent, 10);
    quantity = currentQuantity + 1;
    quantityValue.textContent = quantity;
    console.log('After increase - quantity:', quantity);
}

        // Hàm xử lý giảm số lượng
        function decreaseHandler() {
            console.log('Decrease button clicked'); // Debug
            quantity = parseInt(quantityValue.textContent);
            if (quantity > 1) {
                quantity--;
                quantityValue.textContent = quantity;
            }
        }

        // Gắn sự kiện
        increaseBtn.onclick = increaseHandler; // Sử dụng onclick để tránh trùng lặp
        decreaseBtn.onclick = decreaseHandler;

        // Xử lý khi nhấn nút "Thêm vào giỏ"
        addToCartBtn.addEventListener('click', function () {
            if (!selectedColor || !selectedSize) {
                alert('Vui lòng chọn màu sắc và kích thước!');
                return;
            }

            console.log('Sending data:', { product_id: productId, quantity: quantity, color: selectedColor, size: selectedSize });

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/shop/addCart', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    console.log('Response:', xhr.status, xhr.responseText);
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Sản phẩm đã được thêm vào giỏ hàng!');
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    } else {
                        alert('Lỗi server: ' + xhr.status + ' - ' + xhr.statusText);
                        console.log('Full response:', xhr.responseText);
                    }
                }
            };

            const data = JSON.stringify({
                product_id: productId,
                quantity: quantity,
                color: selectedColor,
                size: selectedSize
            });

            xhr.send(data);
        });
    });
</script> -->