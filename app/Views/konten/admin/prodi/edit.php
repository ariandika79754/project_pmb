<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4">Edit Prodi</h4>

<div class="card">
    <div class="card-body">
        <form action="/admin/kode/prodi/update/<?= $prodi['id'] ?>" method="post">
            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                <input type="text" class="form-control" name="kode_prodi" id="kode_prodi" value="<?= esc($prodi['kode_prodi']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                <input type="text" class="form-control" name="nama_prodi" id="nama_prodi" value="<?= esc($prodi['nama_prodi']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="jurusan_id" class="form-label">Jurusan</label>
                <select class="form-select" name="jurusan_id" id="jurusan_id" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?= $j['id'] ?>" <?= $prodi['jurusan_id'] == $j['id'] ? 'selected' : '' ?>>
                            <?= esc($j['nama_jurusan']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="total_kelas" class="form-label">Total Kelas</label>
                <input type="number" class="form-control" name="total_kelas" id="total_kelas" value="<?= esc($prodi['total_kelas']) ?>" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="/admin/kode/prodi" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>