<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<section class="section dashboard">
  <div class="row">

    <!-- Mahasiswa Card -->
    <div class="col-12 col-md-4 mb-3">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Jumlah Mahasiswa</h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-people"></i>
            </div>
            <div class="ps-3">
              <h6><?= $jumlahMahasiswa ?></h6>
              <span class="text-muted small pt-2 ps-1">Mahasiswa Terdaftar</span>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Mahasiswa Card -->

  </div>
</section>

<?= $this->endSection() ?>
