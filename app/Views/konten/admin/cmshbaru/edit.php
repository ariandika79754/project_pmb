<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Tambah Data Tahun Akademik</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/kategori/" class="btn btn-dark me-3 mt-3"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <div class="col-lg-12 p-5">
                    <form method="POST" action="/admin/kategori/edit/<?= encrypt_url($kategori->id) ?>">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="nama_kategori">Nama Kategori</label>
                                <input type="text" class="form-control <?= isset($errors['nama_kategori']) ? 'is-invalid ' : ''; ?>" name="nama_kategori" id="nama_kategori" placeholder="Ex. 2023/2024" value="<?= isset($errors['nama_kategori']) ? old('nama_kategori') : $kategori->nama_kategori ?>">
                                <?php if (isset($errors['nama_kategori'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['nama_kategori'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>