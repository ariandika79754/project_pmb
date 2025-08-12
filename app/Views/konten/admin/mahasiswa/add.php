<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Tambah Mahasiswa</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/npm/save" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="nama" id="nama" required>
            </div>
            <div class="mb-3">
                <label for="npm" class="form-label">NPM</label>
                <input type="text" class="form-control" name="npm" id="npm" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/npm" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
