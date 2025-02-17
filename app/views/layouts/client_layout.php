<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <title>Fruitables - Vegetable Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <link rel="stylesheet" type="text/css" href="<?php echo _WEB_ROOT; ?>/node_modules/toastr/build/toastr.css" >

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/style1.css" rel="stylesheet">
    </head>
    <style>
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>

<body>

    <?php

    if (isset($content) && isset($sub_content)) {
        $this->render('blocks/clients/header', $sub_content);
        $this->render($content, $sub_content);
        $this->render('blocks/clients/footer');
    } else {
        $this->render('blocks/clients/header');
        $this->render('home/home');
        $this->render('blocks/clients/footer');
    }
    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/node_modules/toastr/toastr.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/easing/easing.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Template Javascript -->
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/main.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/products.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/cart.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/order.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/detail-product.js"></script>
    <script>
        $(document).ready(function(){
            var currentPage = 1;
            var itemsPerPage = 9; 
            var debounceTimer;
            getFilteredData();

            $('.category-checkbox, #price-range-start, #price-range-end').on('change', function () {
                getFilteredData(); 
            });

            $('#name-search').on('keyup', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(getFilteredData, 300); // Adjust the delay time (in milliseconds) as needed
            });

            $('.search-keywords').on('click', function() {  
                getFilteredData();
            });

            function getFilteredData() {
                var nameQuery = $('#name-search').val();
                var categories = [];
                $('.category-checkbox:checked').each(function() {
                    categories.push($(this).val());
                });
                var priceRangeStart = $('#price-range-start').val();
                var priceRangeEnd = $('#price-range-end').val();

                $.ajax({
                    url: 'http://localhost/shop/product/getFilteredProducts',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        name: nameQuery,
                        categories: categories,
                        priceRangeStart: priceRangeStart,
                        priceRangeEnd: priceRangeEnd
                    },
                    success: function (response) {
                        if(response) {
                            displayProducts(response);
                        } else {
                            $('#show-product').html('');
                            $('#store-pagination').html('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function displayProducts(products) {
                var productLength = products.length;
                var startIndex = currentPage * itemsPerPage - itemsPerPage ;

                var endIndex = startIndex + itemsPerPage;

                const currentProducts = products.slice(startIndex, endIndex);
                $('#show-product').html(''); 

                currentProducts.forEach(function(product) {
                    var productHtml = '<div class="col-md-6 col-lg-6 col-xl-4">';
                    productHtml += '<a href="<?php echo _WEB_ROOT; ?>/san-pham/'+product.product_url+'">';
                    productHtml += '<div class="rounded position-relative fruite-item" style="cursor: pointer;">';
                    productHtml += '<div class="fruite-img">';
                    productHtml += '<img src="public/assets/clients/img/'+ product.product_image +'" class="img-fluid w-100 rounded-top" style="width:306px; height:250px"; alt="">';
                    productHtml += '</div>';
                    productHtml += '<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">News</div>';
                    productHtml += '<div class="p-4 border border-secondary border-top-0 rounded-bottom">';
                    productHtml += '<h4>'+ product.product_name +'</h4>';
                    
                    // Giới hạn số từ của mô tả sản phẩm
                    var descriptionWords = product.product_description.split(' ');
                    var maxWords = 17; 
                    var truncatedDescription = descriptionWords.slice(0, maxWords).join(' ');
                    productHtml += '<p>'+ truncatedDescription + (descriptionWords.length > maxWords ? '...' : '') +'</p>';
                    
                    productHtml += '<div class="d-flex justify-content-around align-items-center">';
                    productHtml += '<p class="text-dark fs-5 fw-bold mb-0">'+ product.product_price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) +'</p>';
                    productHtml += '<a href="<?php echo _WEB_ROOT; ?>/carts/addToCart/'+product.product_id+'" class="add-to-cart btn border border-secondary rounded-pill px-3 text-primary" data-product-id="'+product.product_id+'"><i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm </a>';
                    productHtml += '</div>';
                    productHtml += '</div>';
                    productHtml += '</div>';
                    productHtml += '</a>';
                    productHtml += '</div>';    
                    
                    $('#show-product').append(productHtml);
                });


                displayPagination(productLength);
            }

            function displayPagination(productLength) {
                var totalPages = Math.ceil(productLength/itemsPerPage);
                var paginationHTML = '';
                for(var i = 1; i <= totalPages; i++) {
                    if(i == currentPage) {
                        paginationHTML += '<li class="page-item active" style="cursor: pointer;"><a class="page-link">' + i + '</a></li>';
                    }
                    else {
                        paginationHTML += '<li class="page-item" style="cursor: pointer;"><a class="page-link">' + i + '</a></li>';
                    }
                }
                $('#store-pagination').html(paginationHTML);
            }
            function updatePagination(newPage) {
                currentPage = newPage; 
                getFilteredData(currentPage);
            }

            $(document).on('click', '#store-pagination li', function() {
                event.preventDefault();
                var newPage = parseInt($(this).text());
                updatePagination(newPage); 
            });

            // add to cart

            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();
                var product_id = $(this).data('product-id'); 
                $.ajax({
                    url: '<?php echo _WEB_ROOT; ?>/carts/addToCart',
                    type: 'POST',
                    dataType: 'json',   
                    data: { product_id: product_id },
                    success: function(response) {
                        if (response.success) {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                        }else if (response.message_warning) {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">' + response.message_warning + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                        }else {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">' + 'vui lòng đăng nhập để mua hàng' + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                            setTimeout(() => {
                                window.location.href = '<?php echo _WEB_ROOT; ?>/authenticate/signin';
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '#btn-add-to-cart', function(e) {
                e.preventDefault();
                var product_id = $(this).data('product-id');
                var quantity = $('#quantity').val();

                $.ajax({
                    url: '<?php echo _WEB_ROOT; ?>/carts/addToCart',
                    type: 'POST',
                    data: {
                        product_id: product_id,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                        }else if (response.message_warning) {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">' + response.message_warning + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                        }else {
                            $('.alert-message').html();
                            var alertDiv = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">' + 'vui lòng đăng nhập để mua hàng' + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('.alert-message').append(alertDiv);
                            setTimeout(() => {
                                window.location.href = '<?php echo _WEB_ROOT; ?>/authenticate/signin';
                            }, 2000);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                })
            })
        });

    </script>

<script>
function confirmCancellation(event, orderId) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
    
    if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng này?")) {
        // Nếu người dùng xác nhận, chuyển hướng đến URL huỷ đơn hàng
        window.location.href = "<?php echo _WEB_ROOT; ?>/order/cancelOrder/" + orderId;
    } else {
        // Nếu người dùng không xác nhận, không làm gì cả
    }
}
</script>

</script>
</body>
</html>