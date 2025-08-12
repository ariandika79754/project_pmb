<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Tambah Prodi</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/prodi/save" method="post">
            <div class="row">
                <div class="col-lg-6 md-3">
                    <label for="kode_prodi" class="form-label">Kode Prodi</label>
                    <input type="text" class="form-control" name="kode_prodi" id="kode_prodi" required>
                </div>
                <div class="col-lg-6 md-3">
                    <label for="nama_prodi" class="form-label">Nama Prodi</label>
                    <input type="text" class="form-control" name="nama_prodi" id="nama_prodi" required>
                </div>
                <div class="col-lg-6 md-3">
                    <label for="jurusan_id" class="form-label">Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="form-select" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php foreach ($jurusan as $j): ?>
                            <option value="<?= $j['id'] ?>"><?= $j['nama_jurusan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-6 md-3">
                    <label for="total_kelas" class="form-label">Total Kelas</label>
                    <input type="number" class="form-control" name="total_kelas" id="total_kelas" required>
                </div>
            </div> <br>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/kode/prodi" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>