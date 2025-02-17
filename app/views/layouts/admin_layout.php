<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  

 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <link rel="shortcut icon" type="image/png" href="<?php echo _WEB_ROOT; ?>/public/assets/admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/admin/css/styles.min.css" />
</head>

<body>


    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php
        // Kiểm tra xem biến $content tồn tại và không rỗng
        if (isset($content) && !empty($sub_content)) {
            $this->render('blocks/admin/navAdmin');
            echo '<div class="body-wrapper">';
            $this->render('blocks/admin/headerAdmin', $sub_content);
            echo '<div class="container-fluid">';
            // include('app/views/blocks/admin/orderView.php');
            $this->render($content, $sub_content);
           // $this->render('blocks/admin/footerAdmin');

            echo '</div>';
            echo '</div>';
        } else {
            $this->render('blocks/admin/navAdmin');
            echo '<div class="body-wrapper">';
            $this->render('blocks/admin/headerAdmin');
            echo '<div class="container-fluid">';
           // $this->render('home/homeAdmin');
             include('app/views/blocks/admin/thongke.php');
            $this->render('blocks/admin/footerAdmin');
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/node_modules/toastr/toastr.js"></script> 
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/sidebarmenu.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/app.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/libs/simplebar/dist/simplebar.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/productAddmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/employeeeAdmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/insuranceAddmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/dashboard.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/roleAdmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/accountAdmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/loadAdmin.js"></script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/admin/js/customerAdmin.js"></script>

    <script src="<?php echo _WEB_ROOT; ?>/node_modules/toastr/toastr.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>