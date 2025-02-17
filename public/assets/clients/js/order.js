$(document).ready(function() {
    $('.view-detail-btn').click(function() {
        var orderId = $(this).data('order-id');
    
        // Gửi yêu cầu AJAX để lấy dữ liệu chi tiết đơn hàng
        $.ajax({
            url: 'http://localhost/shop/order/viewDetailOrder', 
            method: 'GET', 
            data: {orderId: orderId}, 
            success: function(response) {
                // Cập nhật nội dung của modal với dữ liệu đã nhận được
                var modalBody = $('#exampleModal').find('.modal-body');
                modalBody.empty(); // Xóa nội dung cũ trong modal body
        
                // Tạo một đối tượng để lưu trữ các nhóm sản phẩm dựa trên tên sản phẩm
                var productGroups = {};
        
                // Duyệt qua mỗi sản phẩm trong dữ liệu nhận được
                $.each(response, function(index, product) {
                    var productName = product.product_name;
                    var productWarranty = product.product_time_insurance;
                    var productPrice = product.product_price;
                    var productDescription = product.product_description;
                    var productSeri = product.product_seri;
        
                    // Nếu sản phẩm chưa có trong danh sách, thêm vào và khởi tạo số seri
                    if (!productGroups.hasOwnProperty(productName)) {
                        productGroups[productName] = {
                            count: 1,
                            warranty: productWarranty,
                            totalPrice: productPrice,
                            description: productDescription,
                            seri: [productSeri] // Lưu số seri vào một mảng
                        };
                    } else {
                        // Nếu sản phẩm đã có trong danh sách, tăng số lượng lên 1 và thêm seri vào mảng
                        productGroups[productName].count++;
                        productGroups[productName].totalPrice += productPrice;
                        productGroups[productName].seri.push(productSeri);
                    }
                });
                
                // Thêm tiêu đề và phần cảm ơn vào modal
                var productInfoHtml = '<div class="modal-header border-bottom-0">';
                productInfoHtml += '<button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button></div>';
                productInfoHtml += '<div class="modal-body text-start p-4">';
                productInfoHtml += '<h5 class="modal-title text-uppercase mb-5" id="exampleModalLabel">Chi tiết đơn hàng</h5>';
                productInfoHtml += '<h4 class="mb-5">Cảm ơn vì đã đặt hàng</h4>';
                productInfoHtml += '<p class="mb-0">Chi tiết thanh toán</p>';
                productInfoHtml += '<hr class="mt-2 mb-4" style="height: 0; background-color: transparent; opacity: .75; border-top: 2px dashed #9e9e9e;">';
                var totalPrice = 0;
                // Hiển thị thông tin sản phẩm từng nhóm
                $.each(productGroups, function(productName, productInfo) {
                    var productCount = productInfo.count;   
                    var productWarranty = productInfo.warranty;
                    var totalPriceProduct = productInfo.totalPrice;
                    var productSeris = productInfo.seri.join(' - '); // Nối tất cả seri thành một chuỗi
                    
                    totalPrice += totalPriceProduct;
        
                    // Tạo các phần tử HTML để hiển thị thông tin sản phẩm
                    productInfoHtml += '<div class="d-flex justify-content-between">';
                    productInfoHtml += '<p class="fw-bold mb-0">' + productName + ' (' + productCount + ' sản phẩm)';
                    productInfoHtml += '<p class="text-muted mb-0">' + totalPriceProduct.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })  + ' </p></div>'; 
                    productInfoHtml += '<div class="d-flex justify-content-between">';
                    productInfoHtml += '<p class="fw-bold mb-0">' + 'Thời gian bảo hành ' + productWarranty + ' tháng</p></div>';
                    productInfoHtml += '<div class="d-flex justify-content-between">';
                    productInfoHtml += '<p class="small mb-0">' + productSeris + '</p></div>';
                    productInfoHtml += '<div class="d-flex justify-content-between pb-1"></div>'; // Đóng thẻ div này
                    productInfoHtml += '<br>';
                });
                productInfoHtml += '<p class="fw-bold mb-0"> TỔNG TIỀN: ' + totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }) + '</p></div>';
                // Đóng thẻ div modal-body và modal-content
                productInfoHtml += '</div></div></div>';
                
                modalBody.append(productInfoHtml);
                // Hiển thị modal
                $('#exampleModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
        

        
    });

});
