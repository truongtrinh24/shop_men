<?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert-message alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['warning_message'])): ?>
    <div class="alert-message alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['warning_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['warning_message']); ?>
<?php endif; ?>
<section class="h-100 h-custom" style="margin-top: 10px;">
  <div class="container py-5 h-100">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="card">
          <div class="card-header" style="background: #81c408;">
            <h1 class="card-title fw-bold mb-0" style="color: white;">Giỏ hàng</h1>
          </div>
          <div class="card-body">
          <?php if(!isset($_SESSION['user_session']['user'])) {
            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Bạn cần đăng nhập để xem giỏ hàng!</strong>'
            .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          }?> 
            <?php foreach ($dataCart as $cartItem): ?>
              <div class="row cart-items" data-cart-id="<?= $cartItem['cart_id'] ?>" data-product-id="<?= $cartItem['product_id'] ?>" data-price="<?= $cartItem['product_price'] ?>">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex align-items-center justify-content-center">
                  <img src="public/assets/clients/img/<?= $cartItem['product_image'] ?>" class="img-fluid rounded-3" alt="">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 d-flex align-items-center justify-content-center">
                  <h5 class="text-muted"><?= $cartItem['product_name'] ?></h5>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 d-flex align-items-center justify-content-center">
                  <div class="input-group">
                    <button id="btn-up" class="btn btn-default btn-up" type="button" onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"><i class="fas fa-minus"></i></button>
                    <input id="form1" min="1" name="quantity" value="<?= $cartItem['quantity'] ?>" type="number" class="form-control text-center input-quantity">
                    <button id="btn-down" class="btn btn-default btn-down" type="button" onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 d-flex align-items-center justify-content-center">
                  <h5 class="mb-0 total-amount"><?= number_format($cartItem['product_price'] * $cartItem['quantity'], 0, ',', '.') ?> đ</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 d-flex align-items-center justify-content-center">
                  <a class="dlt-product-in-the-cart" href="http://localhost/shop/carts/deleteProductInTheCartById?cart_id=<?= $cartItem['cart_id'] ?>" style="font-size: 25px"><i class="fas fa-times"></i></a>
                </div>
              </div>
              <hr class="my-4">
            <?php endforeach; ?>
            <div class="pt-5">
              <h5 class="mb-0"><a href="<?php echo _WEB_ROOT;?>/dien-thoai" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Trở lại mua hàng</a></h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Details -->
      <div class="order-details col-lg-4">
        <div class="section-title text-center">
          <h3 class="title">Đơn hàng của bạn</h3>
        </div>
        <div class="order-summary">
          <div class="order-col">
            <div><strong>SẢN PHẨM</strong></div>
          </div>
          <div class="order-products">
              <?php foreach ($dataCart as $cartItem): ?>
                <div class="order-col d-flex justify-content-between" data-cart-id="<?= $cartItem['cart_id'] ?>">
                  <div class="price-each-item"><?= $cartItem['quantity'] ?> <?= $cartItem['product_name'] ?></div>
                  <div class="price-product"><?= number_format($cartItem['product_price'] * $cartItem['quantity'], 0, ',', '.') ?> đ</div>
                </div>
              <?php endforeach; ?>
          </div>
          <div class="order-col mt-2">
            <div><strong>TỔNG TIỀN</strong></div>
            <div><strong class="order-total">
              <?php
              $total = 0;
              foreach ($dataCart as $cartItem) {
                $total += $cartItem['product_price'] * $cartItem['quantity'];
              }
              echo number_format($total, 0, ',', '.') . 'đ';
              ?>  
            </strong></div>
          </div>
        </div>
        <a href="http://localhost/shop/order/placeOrder" class="btn btn-primary order-submit mt-2">Đặt hàng</a>
      </div>
      <!-- /Order Details -->
    </div>
  </div>
</section>
