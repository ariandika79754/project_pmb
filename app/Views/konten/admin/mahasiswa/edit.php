<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Edit Mahasiswa</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/npm/update/<?= $mahasiswa['id'] ?>" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?= esc($mahasiswa['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="npm" class="form-label">NPM</label>
                <input type="text" class="form-control" name="npm" id="npm" value="<?= esc($mahasiswa['npm']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/admin/npm" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
