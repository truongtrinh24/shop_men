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
<?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert-message alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<!-- Section: Design Block -->
<section class="text-center text-lg-start">
`
  <!-- Jumbotron -->
  <div class="container py-4">
    <div class="row g-0 align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            "> 
          <div class="card-body p-5 shadow-5 text-center">
            <h2 class="fw-bold mb-5">Đăng nhập </h2>
            <form>
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="username">Tên đăng nhập</label>
                <input type="text" id="username" class="form-control" />
                <div class="error error-message-username"></div>
              </div>

              <!-- Password input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="password">Mật khẩu</label>
                <input type="password" id="password" class="form-control" />
                <div class="error error-message-password"></div>
              </div>

              <!-- Submit button -->
              <button class="btn btn-primary btn-block mb-4" onclick="signIn()">
                Đăng nhập ngay
              </button>
              <p class="fw-lighter">Bạn chưa có tài khoản? <a href="<?php echo _WEB_ROOT; ?>/authenticate/signup">Đăng ký</a></p>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/node_modules/toastr/toastr.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/login.js"></script>
</body>
</html>