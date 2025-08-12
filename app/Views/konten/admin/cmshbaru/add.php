<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Mahasiswa Baru /</span> Tambah</h4>

<div class="row">
    <div class="col-lg-12">
        <div class="card p-4">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/admin/cmshbaru/save" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <label>Kode Peserta</label>
                        <input type="text" name="kode_peserta" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Tipe Sekolah</label>
                        <input type="text" name="tipe_sekolah" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Jurusan Asal</label>
                        <input type="text" name="jurusan_asal" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control">
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan</button>
                        <a href="/admin/cmshbaru" class="btn btn-secondary"><i class='bx bx-arrow-back'></i> Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
