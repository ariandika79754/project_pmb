<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Tambah </span> Jurusan</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/jurusan/save" method="post">
            <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" required>
            </div>
            <div class="mb-3">
                <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/kode/jurusan" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
