<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Edit </span> Jurusan</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/jurusan/update/<?= $jurusan['id'] ?>" method="post">
            <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" value="<?= esc($jurusan['kode_jurusan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="<?= esc($jurusan['nama_jurusan']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/admin/kode/jurusan" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
