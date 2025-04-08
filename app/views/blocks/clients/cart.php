<script>
    const WEB_ROOT = '<?php echo _WEB_ROOT; ?>';
</script>
<div class="cart-container">
    <div class="freeship-notice">
        🚚 Freeship với đơn hàng trên 350.000đ. Mua sắm ngay nào!!!
    </div>
    <div class="cart-content">
        <?php if (empty($dataCart)): ?>
            <!-- Hiển thị khi giỏ hàng trống -->
            <div class="empty-cart">
                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/cart.png" alt="Empty Cart">
                <h2>"Hổng" có gì trong giỏ hết</h2>
                <p>Về trang cửa hàng để chọn mua sản phẩm bạn nhé!!</p>
                <a href="#" class="btn-shop-now">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <!-- Hiển thị khi có sản phẩm trong giỏ hàng -->
            <div class="cart-items">
                <?php foreach ($dataCart as $item): ?>
                    <div class="cart-item">
                        <div class="product-cart-image">
                            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo $item['image_folder']; ?>/<?php echo $item['product_image']; ?>"
                                alt="<?php echo $item['product_name']; ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-details">
                                <h3><?php echo $item['product_name']; ?></h3>
                                <div class="attributes">
                                    <?php
                                    $color = isset($item['color']) ? htmlspecialchars($item['color']) : 'N/A';
                                    $size = isset($item['size']) ? htmlspecialchars($item['size']) : 'N/A';
                                    echo $color . ' / ' . $size;
                                    ?>
                                </div>
                            </div>
                            <div class="price-quantity">
                                <div class="price"><?php echo number_format($item['product_price'], 0, ',', '.'); ?>đ</div>
                                <div class="quantity">
                                    <button class="decrease-quantity" data-cart-id="<?php echo $item['id']; ?>">-</button>
                                    <input type="number" value="<?php echo $item['quantity']; ?>" min="1"
                                        data-cart-id="<?php echo $item['id']; ?>"
                                        data-product-id="<?php echo $item['product_id']; ?>">
                                    <button class="increase-quantity" data-cart-id="<?php echo $item['id']; ?>">+</button>
                                </div>
                                <button class="delete-item" data-cart-id="<?php echo $item['id']; ?>">Xóa</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Tổng tiền -->
            <div class="cart-summary">
                <div class="total">
                    <span>Tổng cộng:</span>
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
                <a href="<?php echo _WEB_ROOT; ?>/payment">
                    <button class="checkout-button">Thanh toán</button>
                </a>
                
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    const increaseButtons = document.querySelectorAll('.increase-quantity');
    const quantityInputs = document.querySelectorAll('.quantity input');
    const totalAmountElement = document.querySelector('.total-amount');

    // Hàm tính lại tổng tiền
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseInt(item.querySelector('.price').textContent.replace(/[^0-9]/g, ''));
            const quantity = parseInt(item.querySelector('.quantity input').value);
            total += price * quantity;
        });
        totalAmountElement.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Xử lý nút giảm
    decreaseButtons.forEach(button => {
        // Xóa sự kiện cũ (nếu có) để tránh trùng lặp
        button.removeEventListener('click', handleDecrease);
        button.addEventListener('click', handleDecrease);
    });

    function handleDecrease(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định
        const input = this.nextElementSibling;
        let quantity = parseInt(input.value);
        if (quantity > 1) {
            input.value = quantity - 1;
            updateTotal();
        }
    }

    // Xử lý nút tăng
    increaseButtons.forEach(button => {
        // Xóa sự kiện cũ (nếu có) để tránh trùng lặp
        button.removeEventListener('click', handleIncrease);
        button.addEventListener('click', handleIncrease);
    });

    function handleIncrease(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định
        const input = this.previousElementSibling;
        let quantity = parseInt(input.value);
        input.value = quantity + 1;
        updateTotal();
    }

    // Xử lý nhập tay
    quantityInputs.forEach(input => {
        input.addEventListener('input', function () {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
                value = 1;
            }
            updateTotal();
        });
    });
});
</script> -->