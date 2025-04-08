<!-- slider shop -->
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
<section class="slider">
    <div class="slider-container">
        <div class="slide fade">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/slider1.png" alt="Banner 1">
        </div>
        <div class="slide fade">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/slider2.png" alt="Banner 2">
        </div>

        <!-- Nút điều hướng -->
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>
</section>
<section class="new-products">
    <div class="container">
        <div class="section-header">
            <h2>SẢN PHẨM MỚI</h2>
            <a href="#" class="view-all">Xem tất cả</a>
        </div>

        <div class="product-list">
            <?php if (!empty($this->data['sub_content']['latestProducts'])): ?>
                <?php foreach ($this->data['sub_content']['latestProducts'] as $product): ?>
                    <div class="product-card">
                        <a href="<?php echo _WEB_ROOT; ?>/detail/<?php echo $product['id']; ?>" class="product-link">
                            <!-- Thêm thẻ a bao quanh -->
                            <div class="product-image">
                                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($product['image_folder']); ?>/<?php echo htmlspecialchars($product['product_image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <span class="badge new">New</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="price"><?php echo number_format($product['price'], 0, ',', '.') . '₫'; ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="intro_products">
    <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/productGT.png" alt="">
</section>

<section class="new-products">
    <div class="container">
        <div class="section-header">
            <h2>Quần Shorts</h2>
            <a href="#" class="view-all">Xem tất cả</a>
        </div>

        <div class="product-list">
            <?php if (!empty($latestShorts)): ?>
                <?php foreach ($latestShorts as $short): ?>
                    <div class="product-card">
                        <a href="<?php echo _WEB_ROOT; ?>/detail/<?php echo $short['id']; ?>" class="product-link">
                            <!-- Thêm thẻ a bao quanh -->
                            <div class="product-image">
                                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($short['image_folder']); ?>/<?php echo htmlspecialchars($short['product_image']); ?>"
                                    alt="<?php echo htmlspecialchars($short['name']); ?>">
                                <span class="badge new">New</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo htmlspecialchars($short['name']); ?></h3>
                                <p class="price"><?php echo number_format($short['price'], 0, ',', '.') . '₫'; ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="product-category-container">
    <h2 class="category-title">DANH MỤC SẢN PHẨM</h2>
    <div class="product-category">
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/somi_category.png" alt="Áo Sơ Mi">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/polo_category.png" alt="Áo Polo">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aothun_category.png" alt="Áo Thun">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aoni_category.png" alt="Áo Nỉ">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aoni_category.png" alt="Áo Nỉ">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aoni_category.png" alt="Áo Nỉ">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aoni_category.png" alt="Áo Nỉ">
        </div>
        <div class="category-item">
            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/aoni_category.png" alt="Áo Nỉ">
        </div>

    </div>
</div>

<div class="additional-info">
    <div class="info-item">
        <img src="path_to_icon1.png" alt="Miễn phí vận chuyển">
        <p>Miễn phí vận chuyển</p>
    </div>
    <div class="info-item">
        <img src="path_to_icon2.png" alt="Quà tặng hấp dẫn">
        <p>Quà tặng hấp dẫn</p>
    </div>
    <div class="info-item">
        <img src="path_to_icon3.png" alt="Bảo đảm chất lượng">
        <p>Bảo đảm chất lượng</p>
    </div>
    <div class="info-item">
        <img src="path_to_icon4.png" alt="Hotline">
        <p>Hotline: 0936119483</p>
    </div>
</div>