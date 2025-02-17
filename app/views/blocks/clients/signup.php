<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/signup.css"/>
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
            <h2 class="fw-bold mb-5">Đăng Ký </h2>
            <form>
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="name" >Họ và tên</label>
                <input type="text" id="name" class="form-control" required/>
                <div class="error error-message-name"></div>
              </div>
              <!-- Email input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" class="form-control" required/>
                <div class="error error-message-email"></div>
              </div>

              <!-- Adress input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="address">Địa chỉ</label>
                <input type="text" id="address" class="form-control" required/>
                <div class="error error-message-address"></div>
              </div>

            <!-- Phone input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="phone">Số điện thoại</label>
                <input type="text" id="phone" class="form-control" required/>
                <div class="error error-message-phone"></div>
              </div>

              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                <label class="form-check-label" for="form2Example33">
                  Đăng ký để nhận thông báo mới nhất
                </label>
              </div>

              <!-- Submit button -->
              <button onclick="signUp()" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                Đăng ký ngay
              </button>
              <p class="fw-lighter">Bạn đã có tài khoản? <a href="<?php echo _WEB_ROOT; ?>/authenticate/signin">Đăng nhập</a></p>
              <p class="fw-lighter"><a href="<?php echo _WEB_ROOT; ?>/dien-thoai">Về trang chủ</a></p>
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
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/signup.js"></script>
    </script>
</body>
</html>