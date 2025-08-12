<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Login - PMB Polinela</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  <!-- Vendor CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />

  <!-- Main CSS -->
  <link href="assets/css/main.css" rel="stylesheet" />
</head>

<body class="index-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex justify-content-between align-items-center">
      <a href="/" class="logo d-flex align-items-center">
        <h1 class="sitename">PMB Polinela</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="/login">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main py-5" style="min-height: 85vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card shadow-sm border-0">
            <div class="card-body p-4">
              <!-- Logo -->
              <div class="text-center mb-3">
                <img src="/template/assets/img/logo/logo.png" alt="Logo" class="img-fluid" style="max-width: 120px;">
              </div>

              <h4 class="text-center mb-2">Toko Ari Andika</h4>
              <p class="text-center text-muted mb-4">Masukkan username dan password dengan benar.</p>

              <!-- Login Form -->
              <form action="/auth/check-auth" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Username</label>
                  <input type="text" name="username" id="email"
                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                    placeholder="Masukkan email atau username" autofocus>
                  <?php if (isset($errors['username'])): ?>
                    <div class="invalid-feedback"><?= $errors['username'] ?></div>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" id="password"
                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                    placeholder="************">
                  <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                  <?php endif; ?>
                </div>

                <div class="d-grid mb-3">
                  <button type="submit" class="btn btn-primary">Masuk</button>
                </div>

                <div class="text-center">
                  <small>Belum punya akun? <a href="/auth/register">Daftar sekarang</a></small>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer id="footer" class="footer light-background mt-5">
    <div class="container">
      <div class="copyright text-center">
        <p>© 2025 Aplikasi PMB Polinela</p>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

</body>
</html>
