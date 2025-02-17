
        <!-- Single Page Header start -->

        <!-- Single Page Header End -->
        <div class="alert-message"></div>

        <!-- Single Product Start -->
        <div class="container-fluid">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 col-xl-12">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="">
                                        <img src="<?php echo _WEB_ROOT; ?>/public/assets/clients/img/<?php echo $dataProduct['product_image'];?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo ucfirst($dataProduct['product_name']);?></h4>
                                <h5 class="fw-bold mb-3"><?php echo $dataProduct['product_price'];?>đ</h5>
                                <p class="mb-4"><?php echo $dataProduct['product_description'];?></p>
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" id="quantity" class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <a id="btn-add-to-cart" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary" data-product-id=<?php echo $dataProduct['product_id'];?>><i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ hàng</a>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Mô tả</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <div class="px-2">
                                            <div class="row g-4">
                                                <div class="col-6">
                                                    <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Màn hình</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_screen'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Dung lượng pin</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_battery'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Ram</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_ram'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Rom</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_rom'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Nơi sản xuất</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_made_in'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Năm sản xuất</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_year_produce'];?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Thời gian bảo hành</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0"><?php echo $dataProduct['product_time_insurance'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Single Product End -->