// $(document).ready(function(){
//     var currentPage = 1;
//     var itemsPerPage = 9; 
//     var debounceTimer;
//     function fetchData(page) {
//         $.ajax({
//             url: 'http://localhost/shop/product/getAllProducts',
//             type: 'GET',
//             dataType: 'json',
//             success: function(response) {
//                 displayProducts(response);
//             },
//             error: function(xhr, status, error) {
//                 console.error(xhr.responseText);
//             }
//         });
//     }

//     $('.category-checkbox, #price-range-start, #price-range-end').on('change', function () {
//         getFilteredData(); 
//     });

//     $('#name-search').on('keyup', function () {
//         clearTimeout(debounceTimer);
//         debounceTimer = setTimeout(getFilteredData, 300); // Adjust the delay time (in milliseconds) as needed
//     });

//     function getFilteredData() {
//         var nameQuery = $('#name-search').val();
//         var categories = [];
//         $('.category-checkbox:checked').each(function() {
//             categories.push($(this).val());
//         });
//         var priceRangeStart = $('#price-range-start').val();
//         var priceRangeEnd = $('#price-range-end').val();
//         console.log(nameQuery);
//         console.log(categories);
//         console.log(priceRangeStart);
//         console.log(priceRangeEnd);
//         $.ajax({
//             url: 'http://localhost/shop/product/getFilteredProducts',
//             type: 'GET',
//             dataType: 'json',
//             data: {
//                 name: nameQuery,
//                 categories: categories,
//                 priceRangeStart: priceRangeStart,
//                 priceRangeEnd: priceRangeEnd
//             },
//             success: function (response) {
//                 if(response) {
//                     displayProducts(response);
//                 } else {
//                     $('#show-product').html('');
//                     $('#store-pagination').html('');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error(xhr.responseText);
//             }
//         });
//     }

//     function displayProducts(products) {
//         var productLength = products.length;
//         var startIndex = currentPage * itemsPerPage - itemsPerPage ;

//         var endIndex = startIndex + itemsPerPage;

//         const currentProducts = products.slice(startIndex, endIndex);
//         $('#show-product').html(''); 

//         currentProducts.forEach(function(product) {
//             var productHtml = '<div class="col-md-6 col-lg-6 col-xl-4">';
//             productHtml += '<div class="rounded position-relative fruite-item">';
//             productHtml += '<div class="fruite-img">';
//             productHtml += '<img src="public/assets/clients/img/'+ product.product_image +'" class="img-fluid w-100 rounded-top" style="width:306px; height:306px"; alt="">';
//             productHtml += '</div>';
//             productHtml += '<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">News</div>';
//             productHtml += '<div class="p-4 border border-secondary border-top-0 rounded-bottom">';
//             productHtml += '<h4>'+ product.product_name +'</h4>';
//             productHtml += '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>';
//             productHtml += '<div class="d-flex justify-content-between flex-lg-wrap">';
//             productHtml += '<p class="text-dark fs-5 fw-bold mb-0">'+ product.product_price +'</p>';
//             productHtml += '<a href="" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ hàng </a>';
//             productHtml += '</div>';
//             productHtml += '</div>';
//             productHtml += '</div>';
//             productHtml += '</div>';    
            
//             $('#show-product').append(productHtml);
//         });

//         displayPagination(productLength);
//     }

//     function displayPagination(productLength) {
//         var totalPages = Math.ceil(productLength/itemsPerPage);
//         var paginationHTML = '';
//         for(var i = 1; i <= totalPages; i++) {
//             if(i == currentPage) {
//                 paginationHTML += '<li class="page-item"><a class="page-link active" aria-current="page">' + i + '</a></li>';
//             }
//             else {
//                 paginationHTML += '<li class="page-item"><a class="page-link">' + i + '</a></li>';
//             }
//         }
//         $('#store-pagination').html(paginationHTML);
//     }
//     function updatePagination(newPage) {
//         currentPage = newPage; 
//         getFilteredData(currentPage);
//     }

//     $(document).on('click', '#store-pagination li', function() {
//         var newPage = parseInt($(this).text());
//         updatePagination(newPage); 
//     });

//     fetchData(currentPage);
// });
