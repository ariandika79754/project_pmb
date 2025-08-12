<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Tahun</span></h4>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Daftar Kode Tahun</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/kode/tahun/add" class="btn btn-primary me-3 mt-3">
                        <i class='bx bxs-message-alt-add'></i> Tambah
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive p-3">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($tahun as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['kode_tahun']) ?></td>
                                    <td>
                                        <a href="/admin/kode/tahun/edit/<?= $row['id'] ?>" class="btn btn-sm btn-success">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <a href="/admin/kode/tahun/delete/<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
