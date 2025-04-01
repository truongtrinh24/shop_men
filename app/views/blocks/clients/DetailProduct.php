<div class="product-container">
        <div class="product-images">
            <div class="main-image">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo $product['product_image']; ?>"
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

            <div class="discount-code">
                <input type="text" placeholder="Mã giảm giá">
                <button>Áp dụng</button>
            </div>

            <div class="color-size-selection">
                <div class="color-selection">
                    <span>Màu sắc:</span>
                    <div class="colors">
                        <!-- Thêm màu sắc nếu có -->
                    </div>
                </div>

                <div class="size-selection">
                    <span>Kích thước:</span>
                    <div class="sizes">
                        <!-- Thêm kích thước nếu có -->
                    </div>
                </div>
            </div>

            <div class="addtocart">
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