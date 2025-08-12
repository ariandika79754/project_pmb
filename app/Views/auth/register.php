<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Login - PMB Polinela</title>

  <!-- Favicons -->
  <link href="/template/assets/img/logo/panglinela.png" rel="icon" />
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
          <li><a href="/">Home</a></li>
          <li><a href="/login">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main py-5" style="min-height: 85vh; background-color: rgb(233, 243, 232);">
  <div class="container">
    <div class="row justify-content-center">

      <!-- FORM REGISTRASI -->
      <div class="col-lg-7">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 bg-white rounded">
            <h4 class="text-center mb-2">Registrasi User Akun Pendaftar</h4>
            <p class="text-center text-muted mb-4">Registrasi User Akun pendaftaran online.</p>

            <form action="<?= base_url('/pendaftar/save') ?>" method="post">
              <div class="card p-4 shadow-sm">
                <p>Isilah data dengan lengkap dan benar. Kami tidak bertanggung jawab atas kesalahan data.</p>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label>NISN *</label>
                    <input type="text" name="nisn" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="tgl_lahir" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>Nama Sekolah *</label>
                    <input type="text" name="nama_sekolah" class="form-control" required>
                  </div>

                  <!-- Tipe Sekolah -->
                    <div class="col-md-6 mb-3">
                    <label>Tipe Sekolah *</label>
                    <select name="tipe_sekolah" id="tipe_sekolah" class="form-select" required>
                        <option value="">-</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="MA">MA</option>
                    </select>
                    </div>

                    <!-- Jurusan Otomatis -->
                    <div class="col-md-6 mb-3">
                    <label>Keahlian/Jurusan *</label>
                    <select name="jurusan" id="jurusan" class="form-select" required>
                        <option value="">-</option>
                        <!-- Akan terisi otomatis -->
                    </select>
                    </div>



                  <div class="col-md-6 mb-3">
                    <label>Lulus Tahun *</label>
                    <select name="tahun_lulus" class="form-select" required>
                      <?php for ($i = date('Y'); $i >= 2015; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>Konfirmasi Email *</label>
                    <input type="email" name="konfirmasi_email" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label>No. Handphone *</label>
                    <input type="text" name="no_hp" class="form-control" required>
                  </div>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-success">REGISTRASIKAN</button>
                  <a href="/" class="btn btn-warning">BATAL</a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

      <!-- INFO CARD -->
      <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="card shadow-sm border-start border-success border-3 h-100">
          <div class="card-body">
            <h5 class="card-title text-success">Validitas Data</h5>
            <p class="card-text">
              Bagi Pendaftar, wajib untuk mengisi data yang sebenar-benarnya dan dapat dipertanggung-jawabkan.
              Administrator sistem berhak menerima ataupun membatalkan aktifasi Akun Anda, jika ditemukan pelanggaran
              ataupun data tidak ditemukan kesesuaian dengan data sebenarnya.
            </p>

            <hr>

            <h5 class="card-title text-success">Email Wajib Memiliki</h5>
            <p class="card-text">
              Anda wajib membuka email Anda untuk melihat email konfirmasi pendaftaran akun dari sistem kami. Setelah
              itu lakukan pembayaran pendaftaran ke BANK, dengan mengikuti tata cara yang ada.
            </p>
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

  <!-- Vendor JS -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tipeSekolah = document.getElementById('tipe_sekolah');
    const jurusan = document.getElementById('jurusan');

    const optionsByTipe = {
      SMA: ['IPA', 'IPS', 'Bahasa'],
      SMK: ['Teknik Komputer dan Jaringan',
            'Rekayasa Perangkat Lunak',
            'Akuntansi dan Keuangan Lembaga',
            'Teknik dan Bisnis Sepeda Motor',
            'Agribisnis Tanaman Pangan',
            'Agribisnis Tanaman Pangan dan Hortikultura',
            'Agribisnis Pengolahan Hasil Pertanian'],
      MA: ['IPA', 'IPS', 'Agama']
    };

    tipeSekolah.addEventListener('change', function () {
      const selected = this.value;
      jurusan.innerHTML = '<option value="">-</option>'; // kosongkan dulu

      if (optionsByTipe[selected]) {
        optionsByTipe[selected].forEach(function (item) {
          const opt = document.createElement('option');
          opt.value = item;
          opt.textContent = item;
          jurusan.appendChild(opt);
        });
      }
    });
  });
</script>


  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

</body>
</html>
