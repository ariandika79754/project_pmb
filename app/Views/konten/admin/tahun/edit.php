<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Edit Tahun</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/tahun/update/<?= $tahun['id'] ?>" method="post">
            <div class="mb-3">
                <label for="kode_tahun" class="form-label">Kode Tahun</label>
                <input type="text" class="form-control" name="kode_tahun" id="kode_tahun" value="<?= esc($tahun['kode_tahun']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/admin/kode/tahun" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
