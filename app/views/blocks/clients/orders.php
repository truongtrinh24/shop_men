<?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert-message alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<section class="">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12">
      <?php
        if(isset($dataOrders) && !empty($dataOrders)) {
            foreach ($dataOrders as $dataOrder): ?>
                <div class="card card-stepper mb-2" style="border-radius: 16px;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-3">Đơn hàng <span class="text-primary font-weight-bold">#<?php echo $dataOrder['order_id']; ?></span></h5>
                                <button type="button" class="btn btn-light btn-lg view-detail-btn" data-mdb-modal-init data-mdb-target="#exampleModal" data-order-id="<?php echo $dataOrder['order_id']; ?>">
                                    <i class="fas fa-info me-2"></i> Xem chi tiết
                                </button>
                            </div>
                            <div>
                              <?php
                                if($dataOrder['status_order_id'] == 1) {
                                   ?>
                                    <p class="mb-3">Trạng thái: Chờ xử lý</span></p>
                                    <a class="btn btn-danger" onclick="confirmCancellation(event, <?= $dataOrder['order_id']; ?>)" href="#">Huỷ đơn hàng</a>
                                  <?php
                                } elseif($dataOrder['status_order_id'] == 2) {
                                  ?>
                                    <p class="mb-3">Trạng thái: Đã xử lý</span></p>
                                  <?php
                                } else {
                                  ?>
                                    <p class="mb-3">Trạng thái: Đã huỷ</span></p>
                                  <?php
                                }
                              ?>
                            </div>
                            <div class="text-end">
                                <p class="mb-3">Ngày đặt hàng: <span><?php echo date('d/m/y', strtotime($dataOrder['date_buy'])); ?></span></p>
                                <p class="mb-0">Tổng tiền: <span class="font-weight-bold"><?php echo number_format($dataOrder['total']); ?>đ</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
        } elseif(!isset($_SESSION['user_session']['user'])) {
          echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
          <strong>Bạn cần đăng nhập để xem đơn hàng!</strong>'
          .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else {
          echo '<p class="text-center">Bạn chưa có đơn hàng nào.</p>';
        }
        ?>
        
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body text-start p-4">
        <h5 class="modal-title text-uppercase mb-5" id="exampleModalLabel">Chi tiết đơn hàng</h5>
        <h4 class="mb-5">Cảm ơn vì đã đặt hàng</h4>
        <p class="mb-0">Chi tiết thanh toán</p>
        <hr class="mt-2 mb-4"
          style="height: 0; background-color: transparent; opacity: .75; border-top: 2px dashed #9e9e9e;">

        <div class="d-flex justify-content-between">
          <p class="fw-bold mb-0">ten san pham - Thoi gian bao hanh</p>
          <p class="text-muted mb-0">gia </p>
        </div>

        <div class="d-flex justify-content-between">
          <p class="small mb-0">product seri cua san pham</p>
        </div>

        <div class="d-flex justify-content-between pb-1">
          <p class="small mb-0">product seri cua san pham</p>
        </div>

        <div class="d-flex justify-content-between">
          <p class="fw-bold">Total</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Cart Page End -->