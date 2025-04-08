document.addEventListener('DOMContentLoaded', function () {
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    const increaseButtons = document.querySelectorAll('.increase-quantity');
    const quantityInputs = document.querySelectorAll('.quantity input');
    const totalAmountElement = document.querySelector('.total-amount');
    const deleteButtons = document.querySelectorAll('.delete-item');

    // Hàm gửi yêu cầu cập nhật số lượng lên server
    function updateQuantity(cartId, quantity) {
        console.log('Sending AJAX request to update quantity:', { cart_id: cartId, quantity: quantity });
        fetch(WEB_ROOT + '/carts/update_quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                cart_id: cartId,
                quantity: quantity
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                toastr.success(data.message || 'Cập nhật số lượng thành công');
                updateTotal(); // Cập nhật lại tổng tiền sau khi thành công
            } else {
                toastr.error(data.message || 'Có lỗi xảy ra khi cập nhật số lượng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Có lỗi xảy ra khi cập nhật số lượng: ' + error.message);
        });
    }

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
        button.addEventListener('click', function () {
            const input = this.nextElementSibling;
            const cartId = input.getAttribute('data-cart-id'); // Lấy cart_id từ input
            let quantity = parseInt(input.value);
            if (quantity > 1) {
                quantity -= 1;
                input.value = quantity;
                updateQuantity(cartId, quantity); // Gọi hàm cập nhật số lượng
            }
        });
    });

    // Xử lý nút tăng
    increaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const input = this.previousElementSibling;
            const cartId = input.getAttribute('data-cart-id'); // Lấy cart_id từ input
            let quantity = parseInt(input.value);
            quantity += 1;
            input.value = quantity;
            updateQuantity(cartId, quantity); // Gọi hàm cập nhật số lượng
        });
    });

    // Xử lý nhập tay
    quantityInputs.forEach(input => {
        input.addEventListener('input', function () {
            const cartId = this.getAttribute('data-cart-id'); // Lấy cart_id từ input
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
                value = 1;
            }
            updateQuantity(cartId, value); // Gọi hàm cập nhật số lượng
        });
    });

    // Xử lý nút xóa sản phẩm (đã hoạt động tốt, không cần sửa)
    // Xử lý nút xóa sản phẩm
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const cartId = this.getAttribute('data-cart-id');
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                fetch(`${WEB_ROOT}/carts/delete_product`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ cart_id: cartId }),
                    credentials: 'include' // Thêm để gửi session
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            throw new Error('Expected JSON but received HTML: ' + text.substring(0, 100));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        this.closest('.cart-item').remove();
                        updateTotal();
                        toastr.success(data.message || 'Xóa sản phẩm thành công');
                    } else {
                        toastr.error(data.message || 'Có lỗi khi xóa sản phẩm');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Có lỗi xảy ra khi xóa sản phẩm: ' + error.message);
                });
            }
        });
    });
});