<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Tambah Tahun</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/tahun/save" method="post">
            <div class="mb-3">
                <label for="kode_tahun" class="form-label">Kode Tahun</label>
                <input type="text" class="form-control" name="kode_tahun" id="kode_tahun" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/kode/tahun" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
