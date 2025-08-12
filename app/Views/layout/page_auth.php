<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Halaman Login - Aplikasi Ari Andika</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/template/assets/img/logo/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/template/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/template/assets/vendor/css/core.css" class="/template-customizer-core-css" />
    <link rel="stylesheet" href="/template/assets/vendor/css/theme-default.css" class="/template-customizer-theme-css" />
    <link rel="stylesheet" href="/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />


    <!-- Toastify -->
    <link rel="stylesheet" href="/template/assets/toastify/script.css">
    <link rel="stylesheet" href="/template/assets/toastify/toastify.css">
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/template/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="/template/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/template/assets/js/config.js"></script>
</head>
<body>

  <!-- Tambahkan HEADER dari template Bootstrap -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <h1 class="sitename">PMB Polinela</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="login">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <!-- /Content -->

  <!-- Tambahkan FOOTER dari template Bootstrap -->
  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="copyright text-center">
        <p>© 2025 Aplikasi PMB Polinela</p>
      </div>
    </div>
  </footer>


    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="/template/assets/vendor/js/bootstrap.js"></script>
    <script src="/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/template/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="/template/assets/js/main.js"></script>

    <!-- Page JS -->
    <!-- Toastify -->
    <script src="/template/assets/toastify/toastify-es.js"></script>
    <script src="/template/assets/toastify/toastify.js"></script>
    <script src="/template/assets/toastify/script.js"></script>
    <script>
        <?php if (session()->getFlashData('success')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('success') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#00FF7F'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('primary')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('primary') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#6495ED'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('warning')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('warning') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#F4A460'
                }
            }).showToast();

        <?php endif; ?>
        <?php if (session()->getFlashData('error')) : ?>
            Toastify({
                text: "<?php echo session()->getFlashData('error') ?>",
                gravity: "top",
                position: 'right',
                style: {
                    background: '#FF4500'
                }
            }).showToast();

        <?php endif; ?>
    </script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

</body>

</html>