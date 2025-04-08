<div class="container-product">
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>NEW ARRIVAL</h3>
        <div class="filters">
            <h4>Màu sắc</h4>
            <ul>
                <li><input type="checkbox" id="black"><label for="black">Đen</label></li>
                <li><input type="checkbox" id="white"><label for="white">Trắng</label></li>
                <li><input type="checkbox" id="beige"><label for="beige">Kem</label></li>
            </ul>

            <h4>Mức giá</h4>
            <ul>
                <li><input type="checkbox" id="under200k"><label for="under200k">Giá dưới 200,000đ</label></li>
                <li><input type="checkbox" id="200kto300k"><label for="200kto300k">200,000đ - 300,000đ</label></li>
                <li><input type="checkbox" id="300kto400k"><label for="300kto400k">300,000đ - 400,000đ</label></li>
                <li><input type="checkbox" id="400kto600k"><label for="400kto600k">400,000đ - 600,000đ</label></li>
                <li><input type="checkbox" id="over800k"><label for="over800k">Giá trên 800,000đ</label></li>
            </ul>

            <h4>Sản phẩm</h4>
            <ul>
                <li><input type="checkbox" id="new"><label for="new">Áo Thun</label></li>
                <li><input type="checkbox" id="hot"><label for="hot">Áo sơ mi</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Áo polo</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Áo khoác</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Quần short</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Quần Tây</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Quần kaki</label></li>
                <li><input type="checkbox" id="sale"><label for="sale">Quần jean</label></li>
            </ul>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="products">
        <div class="product-grid" id="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <a href="<?php echo _WEB_ROOT; ?>/detail/<?php echo $product['id']; ?>">
                            <!-- Thêm liên kết đến trang chi tiết -->
                            <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo htmlspecialchars($product['image_folder']); ?>/<?php echo htmlspecialchars($product['product_image']); ?>"
                                alt="product image">
                            <span class="eye-icon">👁️</span>
                            <p class="product-title"><?php echo htmlspecialchars($product['name']); ?></p>
                            <p class="product-price"><?php echo number_format($product['price'], 0, ',', '.') . 'đ'; ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="#" class="<?php echo $i == 1 ? 'active' : ''; ?>"
                    data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- Thêm jQuery và script AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let currentFilters = {
            colors: [],
            priceRanges: [],
            productTypes: [],
            page: 1 // Trang mặc định
        };

        // Xử lý khi checkbox thay đổi
        $('.filters input[type="checkbox"]').change(function () {
            const $this = $(this);
            const group = $this.closest('ul').prev('h4').text(); // Xác định nhóm (Màu sắc, Mức giá, Sản phẩm)

            // Chỉ cho phép chọn 1 checkbox trong cùng nhóm
            if ($this.is(':checked')) {
                // Bỏ chọn tất cả checkbox khác trong cùng nhóm
                $this.closest('ul').find('input[type="checkbox"]').not(this).prop('checked', false);
            }

            currentFilters.page = 1; // Reset về trang 1 khi thay đổi bộ lọc
            updateFilters();
            fetchProducts();
        });

        // Xử lý khi nhấn phân trang
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            currentFilters.page = $(this).data('page');
            fetchProducts();
        });

        // Cập nhật bộ lọc từ checkbox
        function updateFilters() {
            // Màu sắc: chỉ lấy 1 giá trị
            currentFilters.colors = [];
            const checkedColor = $('.filters input[id^="black"]:checked, .filters input[id^="white"]:checked, .filters input[id^="beige"]:checked');
            if (checkedColor.length > 0) {
                currentFilters.colors.push(checkedColor.attr('id'));
            }

            // Mức giá: chỉ lấy 1 giá trị
            currentFilters.priceRanges = [];
            const checkedPrice = $('.filters input[id^="under200k"]:checked, .filters input[id^="200kto300k"]:checked, .filters input[id^="300kto400k"]:checked, .filters input[id^="400kto600k"]:checked, .filters input[id^="over800k"]:checked');
            if (checkedPrice.length > 0) {
                currentFilters.priceRanges.push(checkedPrice.attr('id'));
            }

            // Loại sản phẩm: chỉ lấy 1 giá trị
            currentFilters.productTypes = [];
            const checkedType = $('.filters input[id^="new"]:checked, .filters input[id^="hot"]:checked, .filters input[id^="sale"]:checked');
            if (checkedType.length > 0) {
                currentFilters.productTypes.push(checkedType.next('label').text());
            }
        }

        // Gửi AJAX lấy sản phẩm
        function fetchProducts() {
            $.ajax({
                url: '<?php echo _WEB_ROOT; ?>/product/getFilteredProducts',
                type: 'POST',
                data: currentFilters,
                dataType: 'json',
                success: function (response) {
                    $('#product-grid').empty();
                    if (response.products && response.products.length > 0) {
                        $.each(response.products, function (index, product) {
                            var productHtml = `
                            <div class="product">
                                <a href="<?php echo _WEB_ROOT; ?>/detail/${product.id}">
                                    <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/${product.image_folder}/${product.product_image}" alt="product image">
                                    <span class="eye-icon">👁️</span>
                                    <p class="product-title">${product.name}</p>
                                    <p class="product-price">${Number(product.price).toLocaleString('vi-VN')}đ</p>
                                </a>
                            </div>`;
                            $('#product-grid').append(productHtml);
                        });
                    } else {
                        $('#product-grid').html('<p>Không có sản phẩm nào phù hợp.</p>');
                    }

                    // Cập nhật phân trang
                    $('#pagination').empty();
                    if (response.total_pages > 1) {
                        for (let i = 1; i <= response.total_pages; i++) {
                            var pageHtml = `<a href="#" class="${i == currentFilters.page ? 'active' : ''}" data-page="${i}">${i}</a>`;
                            $('#pagination').append(pageHtml);
                        }
                    }

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },
                error: function (xhr, status, error) {
                    console.error("Status: " + status);
                    console.error("Error: " + error);
                    console.error("Response: " + xhr.responseText);
                    alert('Có lỗi xảy ra, kiểm tra console để biết chi tiết!');
                }
            });
        }

        // Tải sản phẩm mặc định khi trang load
        fetchProducts();
    });
</script>