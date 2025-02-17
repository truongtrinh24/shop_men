<div class="d-flex mb-3 justify-content-center">
    <input style="width: 300px;" type="text" class="form-control" placeholder="Search Product"
        aria-label="Search Product" aria-describedby="search-product-icon" id="search-product-input"
        onkeyup="searchProduct()">
</div>



<div class="container" id="allProduct">
    <!-- Pagination -->
    <nav aria-label="Page navigation example ">
        <ul class="pagination d-flex justify-content-center ">
            <li class="page-item">
                <a onclick="load_prev_page()" class="page-link  text-dark fs-3" aria-label="Previous"
                    style="cursor:pointer;">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <span class="page-link text-dark fw-semibold"> <span id="current_page"
                        class="text-primary"></span>/<span id="total_pages"></span></span>
            </li>
            <li class="page-item">
                <a onclick="load_next_page()" class="page-link  text-dark fs-3" aria-label="Next"
                    style="cursor:pointer;">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>Image</th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none" onclick="softInfo('product_name', 'soft')"
                        style="background-color: #fff;color: black">Category Name</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none" onclick="softInfo('product_name', 'soft')"
                        style="background-color: #fff;color: black">Product Name</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none" onclick="softInfo('quantity', 'soft')"
                        style="background-color: #fff;color: black">Stock</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none" onclick="softInfo('product_made_in', 'soft')"
                        style="background-color: #fff;color: black">Made In</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none"
                        onclick="softInfo('product_year_produce', 'soft')"
                        style="background-color: #fff;color: black">Year
                        Produce</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none"
                        onclick="softInfo('product_time_insurance', 'soft')"
                        style="background-color: #fff; color: black">Time
                        Insurance(Month)</button>
                </th>
                <th>
                    <button class="btn btn-link p-0 text-decoration-none" onclick="softInfo('product_price', 'soft')"
                        style="background-color: #fff;color: black">Price</button>
                </th>

                <th>Operations</th>
            </tr>
        </thead>
        <tbody id="contentDataProduct">

        </tbody>
    </table>

    <!-- Pagination -->
    
</div>


<!-- Detail Modal -->
<div class="modal" id="formDetailProduct" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productDetails" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    loadProductTable()>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- COnfirm Delete Modal -->
<div class="modal" id="confirmDeleteProduct" tabindex="-1" aria-labelledby="confirmDeleteProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="content-confirm" class="text-center"></div>
                <input id="productId" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="deleteProduct_de()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal" id="formUpdateProduct" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <div id="productUpdates" class="text-center"></div>
                <input type="hidden" id="productId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="updateProduct()">Update</button>
            </div>
        </div>
    </div>
</div>