<div class="cart-container">
    <div class="freeship-notice">
        🚚 Freeship với đơn hàng trên 350.000đ. Mua sắm ngay nào!!!
    </div>
    <div class="cart-content">
        <?php if (empty($dataCart)) : ?>
            <!-- Hiển thị khi giỏ hàng trống -->
            <div class="empty-cart">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/cart.png" alt="Empty Cart">
                <h2>"Hổng" có gì trong giỏ hết</h2>
                <p>Về trang cửa hàng để chọn mua sản phẩm bạn nhé!!</p>
                <a href="#" class="btn-shop-now">Mua sắm ngay</a>
            </div>
        <?php else : ?>
            <!-- Hiển thị khi có sản phẩm trong giỏ hàng -->
            <div class="cart-items">
                <?php foreach ($dataCart as $item) : ?>
                    <div class="cart-item">
                        <div class="product-image">
                            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>">
                        </div>
                        <div class="product-info">
                            <h3><?php echo $item['product_name']; ?></h3>
                            <div class="price"><?php echo number_format($item['product_price'], 0, ',', '.'); ?>đ</div>
                            <div class="quantity">
                                <button class="decrease-quantity" data-cart-id="<?php echo $item['id']; ?>">-</button>
                                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" 
                                       data-cart-id="<?php echo $item['id']; ?>"
                                       data-product-id="<?php echo $item['product_id']; ?>">
                                <button class="increase-quantity" data-cart-id="<?php echo $item['id']; ?>">+</button>
                            </div>
                            <button class="remove-item" data-cart-id="<?php echo $item['id']; ?>">Xóa</button>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Tổng tiền -->
                <div class="cart-summary">
                    <div class="total">
                        <span>Tổng tiền:</span>
                        <span class="total-amount">
                            <?php 
                            $total = 0;
                            foreach ($dataCart as $item) {
                                $total += $item['product_price'] * $item['quantity'];
                            }
                            echo number_format($total, 0, ',', '.'); 
                            ?>đ
                        </span>
                    </div>
                    <button class="checkout-button">Thanh toán</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>