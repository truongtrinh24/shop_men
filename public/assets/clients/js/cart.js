$(document).ready(function() {
    var updateTotalDebounced = debounce(updateTotalOnServer, 500);

    $('.btn-up, .btn-down').on('click', function() {
        var cartItem = $(this).closest('.cart-items');
        var cart_id = cartItem.data('cart-id');
        var product_id = cartItem.data('product-id');
        var price = cartItem.data('price');
        var quantityInput = cartItem.find('input[name="quantity"]');
        var quantity = parseInt(quantityInput.val());
        var nameProduct = cartItem.find('.text-muted').html();
    
        var cartElement = $('.order-col[data-cart-id="' + cart_id + '"]');
        var priceEachItem = cartElement.find('.price-each-item');
        var totalMoneyOfProduct = cartElement.find('.price-product');
        console.log(priceEachItem)
        priceEachItem.text(quantity + ' ' + nameProduct);
        totalMoneyOfProduct.text((price * quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
    
        updateTotal(quantity, price, cartItem);
        updateTotalPrice();
        updateTotalDebounced(product_id, cart_id, quantity, quantityInput);
    }); 
    

    $('.input-quantity').on('change', function() {
        var cartItem = $(this).closest('.cart-items');
        var cart_id = cartItem.data('cart-id');
        var product_id = cartItem.data('product-id');
        var price = cartItem.data('price');
        var quantityInput = cartItem.find('input[name="quantity"]');
        var quantity = parseInt(quantityInput.val());
        var nameProduct = cartItem.find('.text-muted').html();

        var cartElement = $('.order-col[data-cart-id="' + cart_id + '"]');
        var priceEachItem = cartElement.find('.price-each-item');
        var totalMoneyOfProduct = cartElement.find('.price-product');
        priceEachItem.text(quantity + ' ' + nameProduct);
        totalMoneyOfProduct.text((price * quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        updateTotal(quantity, price, cartItem);
        updateTotalPrice();
        updateTotalDebounced(product_id, cart_id, quantity);
    });

    function updateTotalPrice() {
        var totalPrice = 0;
        $('.price-product').each(function() {
            var priceString = $(this).text().replace('đ', '').replace(/[.,]/g, '').trim();
            
            var price = parseFloat(priceString);
            totalPrice += price;
        });
        $('.order-total').text(totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
    }    

    function debounce(callback, delay) {
        var timer;
        return function() {
            var context = this;
            var args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, delay);
        };
    }
    
    function updateTotal(quantity, price, cartItem) {
        var totalAmount = quantity * price;
        cartItem.find('.total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

    }
    
    function updateTotalOnServer(product_id, cart_id, quantity) {
        $.ajax({
            url: 'http://localhost/shop/carts/updateQuantity',
            type: 'POST',
            data: {
                product_id: product_id,
                cart_id: cart_id,
                quantity: quantity 
            },
            success: function(data) {
                if (!data.success) {
                    alert('Số lượng sản phẩm không đủ trong kho');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + ", " + error);
            }
        });
    } 

    $('.dlt-product-in-the-cart').on('click',function(){
        alert('bạn có chắc muốn xoá')
    })

});
