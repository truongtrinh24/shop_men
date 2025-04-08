<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
</head>

<body class="checkout-page">
    <div class="container-payment">
        <!-- Phần bên trái: Thông tin giao hàng và thanh toán -->
        <div class="left-section">
            <h1>VTTQ SHOP</h1>
            <div class="section">
                <h2>THÔNG TIN GIAO HÀNG</h2>
                <div class="user-info">
                    <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/icon_checkout.png" alt="User Avatar"
                        class="avatar">
                    <span>
                        <?php
                        $customer_name = isset($sub_content['customer_name']) ? $sub_content['customer_name'] : 'Khách';
                        $customer_email = isset($sub_content['customer_email']) ? $sub_content['customer_email'] : 'Chưa đăng nhập';
                        echo htmlspecialchars($customer_name) . " (" . htmlspecialchars($customer_email) . ")";
                        ?>
                    </span>
                </div>
                <p class="status"><a href="<?php echo _WEB_ROOT; ?>/logout">Đăng Xuất</a></p>

                <form id="checkout-form" method="POST">
                    <label>Họ và tên</label>
                    <input type="text" name="customer_name" placeholder="Họ và tên"
                        value="<?php echo htmlspecialchars($customer_name); ?>" required>

                    <label>Số điện thoại</label>
                    <input type="text" name="customer_phone" placeholder="Số điện thoại" required>

                    <label>Địa chỉ</label>
                    <input type="text" name="customer_address" placeholder="Địa chỉ" required>

                    <h3>PHƯƠNG THỨC THANH TOÁN</h3>
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input class="input_checkout" type="radio" name="payment_method" value="COD" checked>
                            <img src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=6"
                                class="payment-icon">
                            <span>Thanh toán khi giao hàng (COD)</span>
                        </label>
                        <label class="payment-option">
                            <input class="input_checkout" type="radio" name="payment_method" value="VietQR">
                            <img src="https://hstatic.net/0/0/global/design/seller/image/payment/other.svg?v=6"
                                class="payment-icon">
                            <span>Chuyển khoản qua VietQR</span>
                        </label>
                        <label class="payment-option">
                            <input class="input_checkout" type="radio" name="payment_method" value="MoMo">
                            <img src="https://hstatic.net/0/0/global/design/seller/image/payment/momo.svg?v=6"
                                class="payment-icon">
                            <span>Ví MoMo</span>
                        </label>
                        <label class="payment-option">
                            <input class="input_checkout" type="radio" name="payment_method" value="ShopeePay">
                            <img src="https://omni-static.haravan.app/omni/shopee_pay.png?v=6" class="payment-icon">
                            <span>Ví ShopeePay</span>
                        </label>
                    </div>

                    <button type="submit" id="complete-order-btn" class="complete-order">Hoàn tất đơn hàng</button>
                </form>
                <a href="<?php echo _WEB_ROOT; ?>/carts" style="text-decoration: none;">
                    <p style="padding-top: 5px; font-size: 15px;">
                        <i class="fas fa-arrow-left me-2"></i> quay lại
                    </p>
                </a>
            </div>
        </div>

        <!-- Phần bên phải: Chi tiết đơn hàng -->
        <div class="right-section">
            <h2>Đơn hàng</h2>
            <div class="order-items">
                <?php if (!empty($sub_content['order_items'])): ?>
                    <?php foreach ($sub_content['order_items'] as $item): ?>
                        <div class="item">
                            <div class="item-image-wrapper">
                                <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($item['image_folder']); ?>/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="Product" style="width: 50px; height: 50px;">
                                <span class="item-quantity"><?php echo htmlspecialchars($item['quantity']); ?></span>
                            </div>
                            <div class="item-details">
                                <p><?php echo htmlspecialchars($item['name']); ?></p>
                                <p><?php echo htmlspecialchars($item['color']) . " / " . htmlspecialchars($item['size']); ?></p>
                            </div>
                            <span class="price"><?php echo htmlspecialchars($item['price']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Giỏ hàng trống.</p>
                <?php endif; ?>
            </div>

            <div class="discount-code">
                <div class="discount-input">
                    <input type="text" placeholder="Mã giảm giá">
                    <button>Sử dụng</button>
                </div>
                <a href="#" class="view-more-discount">
                    <i class="fas fa-chevron-down"></i> Xem thêm mã giảm giá
                </a>
                <div class="discount-options">
                    <button>Giảm 7%</button>
                    <button>Giảm 5%</button>
                    <button>Giảm 10%</button>
                    <button>Giảm Ship 22,000đ</button>
                </div>
            </div>

            <div class="order-summary">
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span><?php echo htmlspecialchars($sub_content['subtotal']); ?></span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span><?php echo htmlspecialchars($sub_content['shipping_fee']); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng</span>
                    <span>VND <?php echo htmlspecialchars($sub_content['total']); ?></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>