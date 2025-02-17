<div class="col-auto d-flex mb-5 justify-content-around">
    <div class="d-flex">
        <input style="width: 300px; margin-right: 10px;" type="text" class="form-control" placeholder="Search Insurance"
            aria-label="Search Insurance" aria-describedby="search-insurance-icon" id="search-insurance-input"
            onkeyup="">
        <div class="input-group-append">
            <button class="btn btn-danger" onclick="openDetailInsuranceModal()">Search Product ID</button> <!-- Thêm onclick="openDetailModal()" -->
        </div>
    </div>
</div>


<!-- Show All Insurance -->
<div class="container" id="allInsurance">
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>Insurance ID</th>
                <th>Order ID</th>
                <th>Customer's Name</th>
                <th>Product Seri</th>
                <th>Equipment Replacement</th>
                <th>Status Insurance</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody id="contentDataInsurance">
        </tbody>
    </table>
    <nav aria-label="Page navigation example ">
        <ul class="pagination d-flex justify-content-center ">
            <li class="page-item">
                <a onclick="load_prev_pageInsurance()" class="page-link  text-dark fs-3" style="cursor: pointer;" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <span class="page-link text-dark fw-semibold"> <span id="current_pageInsurance"
                        class="text-primary"></span>/<span id="total_pagesInsurance"></span></span>
            </li>
            <li class="page-item">
                <a onclick="load_next_pageInsurance()" class="page-link  text-dark fs-3 " style="cursor: pointer;" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal for Insert Insurance -->
<div class="modal" id="formDetailProductforInsurance" tabindex="-1" aria-labelledby="detailProductforInsurance" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center d-flex justify-content-center" id="detailModalLabel">Detail Product For Insurance</h5> <!-- Thay đổi class để căn giữa tiêu đề -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailProductforInsurance" class="text-left mx-5"></div> <!-- Thay đổi class để tạo khoảng cách bên phải -->
                <input type="hidden" id="product_seri">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" id="createInsuranceBtn"onclick="createInsurance()">Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="formDetailInsuranceByID" tabindex="-1" aria-labelledby="detailInsuranceByID" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center d-flex justify-content-center" id="detailModalLabel">Detail Insurance ID</h5> <!-- Thay đổi class để căn giữa tiêu đề -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="insuranceDetail" class="text-left mx-5"></div>
                <input type="hidden" id="insuranceID">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>\
            </div>
        </div>
    </div>
</div>
