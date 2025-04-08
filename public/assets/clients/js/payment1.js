// public/assets/clients/js/checkout.js
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const completeBtn = document.getElementById('complete-order-btn');

    if (form && completeBtn) {
        completeBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            fetch(`http://localhost/shop/payment/complete_order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || 'Đặt hàng thành công!');
                    setTimeout(() => {
                        window.location.href = 'http://localhost/shop/'; // Chuyển về trang chủ
                    }, 2000);
                } else {
                    toastr.error(data.message || 'Có lỗi xảy ra khi đặt hàng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Có lỗi xảy ra: ' + error.message);
            });
        });
    }
});