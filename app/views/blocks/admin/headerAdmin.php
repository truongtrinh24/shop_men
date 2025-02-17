<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Page Title</title>
  <!-- Link Bootstrap CSS -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- Link Bootstrap Icons CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Custom CSS for enlarging icon and text */
    .navbar-nav #role_id {
      font-size: 20px;
      /* Adjust as needed */
      margin-top: 5px;
      /* Adjust as needed */
    }

    .navbar-nav .bi {
      font-size: 24px;
      /* Adjust as needed */
      margin-right: 5px;
      /* Adjust as needed */
    }

    .user-login {
      margin-left: 16px;

    }

    .announcement {
      text-align: center;
      /* Căn giữa nội dung */
    }

    .announcement h1 {
      margin-left: 245px;
    }
  </style>
</head>

<body>
  <header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="announcement" style="text-align: center;">
        <h1>Chúc <?php echo $_SESSION['user_session']['user']['username']; ?> một ngày tốt lành!</h1>
      </div>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">


          <li class="nav-item dropdown">
            <?php echo $_SESSION['user_session']['user']['username']; ?>
          </li>
          <input id="role_id" type="hidden" value="<?php echo $_SESSION['user_session']['user']['role_id']; ?>">
          <span class="user-login">
            <!-- Now use the Bootstrap icon class -->
            <i class="bi bi-person-circle"></i>
          </span>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Link Bootstrap JS (optional) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>