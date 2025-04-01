document.addEventListener('DOMContentLoaded', function() {
    const quantityValue = document.getElementById('quantity-value');
    const increaseBtn = document.getElementById('increase-btn');
    const decreaseBtn = document.getElementById('decrease-btn');

    // Xử lý sự kiện click cho nút tăng
    increaseBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityValue.textContent);
        quantityValue.textContent = currentValue + 1; // Tăng giá trị lên 1
    });

    // Xử lý sự kiện click cho nút giảm
    decreaseBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityValue.textContent);
        if (currentValue > 1) {
            quantityValue.textContent = currentValue - 1; // Giảm giá trị xuống 1
        }
    });
});