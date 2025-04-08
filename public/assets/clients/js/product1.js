document.addEventListener('DOMContentLoaded', function () {
    const colorInputs = document.querySelectorAll('input[name="color"]');
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    const selectedInfo = document.getElementById('selected-info');
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const quantityValue = document.getElementById('quantity-value');
    const increaseBtn = document.getElementById('increase-btn');
    const decreaseBtn = document.getElementById('decrease-btn');
    const productId = document.querySelector('.addtocart').getAttribute('data-product-id');

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
    function increaseHandler(event) {
        event.stopPropagation();
        console.log('Before increase - quantityValue.textContent:', quantityValue.textContent);
        let currentQuantity = parseInt(quantityValue.textContent, 10) || 1;
        quantity = currentQuantity + 1;
        quantityValue.textContent = quantity;
        console.log('After increase - quantity:', quantity);
    }

    // Hàm xử lý giảm số lượng
    function decreaseHandler(event) {
        event.stopPropagation();
        console.log('Before decrease - quantityValue.textContent:', quantityValue.textContent);
        let currentQuantity = parseInt(quantityValue.textContent, 10);
        if (currentQuantity > 1) {
            quantity = currentQuantity - 1;
            quantityValue.textContent = quantity;
        }
        console.log('After decrease - quantity:', quantity);
    }

    // Gắn sự kiện
    increaseBtn.onclick = increaseHandler;
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