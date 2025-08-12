<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Login - PMB Polinela</title>

  <!-- Favicons -->
  <link href="/template/assets/img/logo/panglinela.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />

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
        <h1 class="sitename" style= "color: rgb(55, 128, 48);">PMB Polinela</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="/login" class="active">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); background-color: rgb(233, 243, 232);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 bg-white rounded">
            <!-- Logo -->
            <!-- <div class="text-center mb-3">
              <img src="/template/assets/img/logo/logo.png" alt="Logo" class="img-fluid" style="max-width: 120px;">
            </div> -->


            <h4 class="text-center text-muted mb-4">Masukkan username dan password dengan benar.</h4>
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show position-relative px-3 py-2" role="alert" style="font-size: 0.925rem;">
              <div class="pe-4"><?= session()->getFlashdata('error') ?></div>
              <button type="button" class="btn-close position-absolute end-0 p-2" style="top: 0.25rem; font-size: 0.7rem;" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

            <!-- Login Form -->
           <form action="/auth/check-auth" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label" style="font-size: 1.0rem;">Username</label>
                <input type="text" name="username" id="email"
                  class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                  placeholder="Masukkan email atau username" autofocus>
                <?php if (isset($errors['username'])): ?>
                  <div class="invalid-feedback"><?= $errors['username'] ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label" style="font-size: 1.0rem;">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="password"
                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                    placeholder="************">
                  <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                  </span>
                  <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback d-block"><?= $errors['password'] ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-success">Masuk</button>
              </div>

              <div class="text-center">
                <small><a href="/auth/register" style="font-size: 0.85rem;">Lupa Password</a></small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

  <!-- Section Informasi Kontak -->
  <section class="footer-top py-5 text-light" style="background-color: #2d2d2d;">
    <div class="container">
      <div class="row gy-4">

        <!-- Kiri: Info SPOMB -->
        <div class="col-lg-4">
          <h6 class="text-uppercase fw-bold mb-3" style="color: #b0b0b0;">SPOMB / JADMISSION V.12</h6>
          <p class="mb-2">Sistem Pendaftaran Online Mahasiswa Baru (SPOMB) adalah layanan resmi sistem pendaftaran online pada penerimaan mahasiswa baru khusus jalur penerimaan lokal Politeknik Negeri Lampung. Aplikasi Jaraka admission (Jadmission) V.12.</p>
          <a href="https://pmb.polinela.ac.id" class="text-success d-block mb-3">pmb.polinela.ac.id</a>
          <div class="d-flex gap-3">
            <a href="#" class="text-success"><i class="bi bi-twitter fs-5"></i></a>
            <a href="#" class="text-success"><i class="bi bi-facebook fs-5"></i></a>
            <a href="#" class="text-success"><i class="bi bi-instagram fs-5"></i></a>
            <a href="#" class="text-success fw-bold fs-6">TikTok</a>
            <a href="#" class="text-success"><i class="bi bi-linkedin fs-5"></i></a>
          </div>
        </div>

        <!-- Tengah: Info Polinela -->
        <div class="col-lg-4">
          <h6 class="text-uppercase fw-bold mb-3" style="color: #b0b0b0;">Politeknik Negeri Lampung</h6>
          <p>Jalan Soekarno–Hatta No.10, Rajabasa<br>Bandar Lampung, Lampung, Indonesia. 35141.</p>
          <p class="mb-1"><i class="bi bi-phone me-2"></i>0721 703 995</p>
          <p class="mb-1"><i class="bi bi-envelope me-2"></i>humas@polinela.ac.id</p>
          <p class="mb-1"><i class="bi bi-globe me-2"></i><a href="https://www.polinela.ac.id" class="text-light">www.polinela.ac.id</a></p>
        </div>

        <!-- Kanan: Panitia PMB -->
        <div class="col-lg-4">
          <h6 class="text-uppercase fw-bold mb-3" style="color: #b0b0b0;">Panitia PMB</h6>
          <p>Sekretariat PMB, Lantai 1, Gedung A<br>Kampus Utama Politeknik Negeri Lampung.</p>
          <p class="mb-1"><i class="bi bi-phone me-2"></i>0812 7893 3860</p>
          <p class="mb-1"><i class="bi bi-envelope me-2"></i>pmb@polinela.ac.id</p>
          <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><a href="https://pmb.polinela.ac.id" class="text-light">pmb.polinela.ac.id</a></p>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="footer" class="footer light-background mt-0">
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
<script>
function togglePassword() {
  const password = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');
  if (password.type === "password") {
    password.type = "text";
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");
  } else {
    password.type = "password";
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  }
}
</script>

  <!-- Vendor JS -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

</body>
</html>
