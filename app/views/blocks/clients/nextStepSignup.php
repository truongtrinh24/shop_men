<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/signin.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_ROOT; ?>/node_modules/toastr/build/toastr.css" >
</head>
<body>

<!-- Section: Design Block -->
<section class="text-center text-lg-start">

  <!-- Jumbotron -->
  <div class="container py-4">
    <div class="row g-0 align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            "> 
          <div class="card-body p-5 shadow-5 text-center">
            <h2 class="fw-bold mb-5">Đăng ký tài khoản</h2>
            <form>
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="username-text">Tên đăng nhập</label>
                <input type="text" id="username-text" value="<?php echo $customer_id;?>" class="form-control" readonly />
                <input type="hidden" id="username" value="<?php echo $customer_id;?>">
                <div class="error error-message-username"></div>
              </div>

              <!-- Password input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="password">Mật khẩu</label>
                <input type="password" id="password" class="form-control" />
                <div class="error error-message-password"></div>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="confirm-password">Nhập lại mật khẩu</label>
                <input type="password" id="confirm-password" class="form-control" />
                <div class="error error-message-comfirm-password"></div>
              </div>

              <!-- Submit button -->
              <button class="btn btn-primary btn-block mb-4" onclick="processSignUp()">
                Tạo tài khoản ngay
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0">
        <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" class="w-100 rounded-4 shadow-4"
          alt="" />
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->

    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/node_modules/toastr/toastr.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/nextStepSignUp.js"></script>
</body>
</html>