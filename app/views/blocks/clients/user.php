<div class="container-user">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>TRANG TÀI KHOẢN</h2>
        <p>Xin chào,
            <strong><?php echo htmlspecialchars($this->data['sub_content']['customerInfo']['customer_name']); ?></strong>
        </p>
        <ul>
            <a href="<?php echo _WEB_ROOT; ?>/logout">Đăng xuất</a>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>TÀI KHOẢN</h2>
        <p>Tên tài khoản:
            <strong><?php echo htmlspecialchars($this->data['sub_content']['customerInfo']['customer_name']); ?></strong>
        </p>
        <div class="info">
            <p><span class="icon">🏠</span> Địa chỉ:
                <?php echo htmlspecialchars($this->data['sub_content']['customerInfo']['customer_address']); ?>
            </p>
            <p><span class="icon">📞</span> Điện thoại:
                <?php echo htmlspecialchars($this->data['sub_content']['customerInfo']['customer_phone']); ?>
            </p>
        </div>

        <h3>ĐƠN HÀNG CỦA BẠN</h3>
        <div class="tabs">
            <span class="tab active">Mã đơn hàng</span>
            <span class="tab">Ngày đặt</span>
            <span class="tab">Thành tiền</span>
            <span class="tab">TT thanh toán</span>
            <span class="tab">TT vận chuyển</span>
            <span class="tab">Hành động</span>
        </div>

        <?php if (empty($this->data['sub_content']['orders'])): ?>
            <p>Không có đơn hàng nào.</p>
        <?php else: ?>
            <div class="order-list">
                <?php foreach ($this->data['sub_content']['orders'] as $order): ?>
                    <div class="order-row" data-order-id="<?php echo $order['id']; ?>">
                        <span><?php echo htmlspecialchars($order['id']); ?></span>
                        <span><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></span>
                        <span><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VNĐ</span>
                        <span><?php echo htmlspecialchars($order['status_order_name'] ?? 'Chưa xác định'); ?></span>
                        <span><?php echo htmlspecialchars($order['shipping_status_name'] ?? 'Chưa xác định'); ?></span>
                        <span>
                            <button class="view-details-btn">Xem chi tiết</button>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal để hiển thị chi tiết đơn hàng -->
<div id="orderDetailModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">×</span>
        <div id="modal-body"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
        const modal = document.getElementById('orderDetailModal');
        const modalBody = document.getElementById('modal-body');
        const closeBtn = document.querySelector('.modal .close');

        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function () {
                const orderRow = this.closest('.order-row');
                const orderId = orderRow.getAttribute('data-order-id');

                // Hiển thị thông báo đang tải
                modalBody.innerHTML = '<p style="text-align: center;">Đang tải dữ liệu...</p>';
                modal.style.display = 'flex'; // Sử dụng display: flex thay vì block

                // Lấy dữ liệu chi tiết từ server
                fetch(`<?php echo _WEB_ROOT; ?>/shop/order-detail/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Lỗi HTTP: ${response.status} - ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            modalBody.innerHTML = `<p style="text-align: center; color: red;">${data.error}</p>`;
                            return;
                        }

                        // Định dạng ngày thành DD.MM.YYYY
                        const orderDate = new Date(data.order_date);
                        const formattedDate = `${orderDate.getDate().toString().padStart(2, '0')}.${(orderDate.getMonth() + 1).toString().padStart(2, '0')}.${orderDate.getFullYear()}`;

                        // Hiển thị dữ liệu trong modal
                        modalBody.innerHTML = `
                        <h2 class="modal-title">HÓA ĐƠN</h2>
                        <div class="modal-info">
                            <div class="info-left">
                                <p><strong>KHÁCH HÀNG:</strong> ${data.customer_name}</p>
                                <p><strong>SDT:</strong> ${data.customer_phone}</p>
                            </div>
                            <div class="info-right">
                                <p><strong>MÃ HÓA ĐƠN:</strong> ${data.order_id}</p>
                                <p><strong>NGÀY ĐẶT:</strong> ${formattedDate}</p>
                            </div>
                        </div>
                        <p class="modal-address"><strong>ĐỊA CHỈ GIAO HÀNG:</strong> ${data.customer_address}</p>
                        <table class="modal-table">
                            <thead>
                                <tr>
                                    <th>SẢN PHẨM</th>
                                    <th>GIÁ</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>TỔNG</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.products.map(product => `
                                    <tr>
                                        <td>${product.name}</td>
                                        <td>${product.price.toLocaleString('vi-VN')}VNĐ</td>
                                        <td>${product.quantity}</td>
                                        <td>${(product.price * product.quantity).toLocaleString('vi-VN')}VNĐ</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        <p class="modal-total"><strong>THÀNH TIỀN:</strong> ${data.total_price.toLocaleString('vi-VN')}VNĐ</p>
                    `;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        modalBody.innerHTML = `<p style="text-align: center; color: red;">Đã có lỗi xảy ra: ${error.message}</p>`;
                    });
            });
        });

        // Đóng modal khi bấm nút đóng
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Đóng modal khi bấm bên ngoài
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
</body>

</html>