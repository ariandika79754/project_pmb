<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><a href="/admin/mahasiswa"><span class="text-muted fw-light">Data Mahasiswa Baru</span></a></h4>
<div class="row">
    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="text-warning">Informasi Data Mahasiswa Baru</h4>
                <ol>
                    <li>Halaman ini menampilkan data mahasiswa baru yang telah mendaftar.</li>
                    <li>Admin dapat mengelola data mahasiswa seperti mengedit atau menghapus informasi mahasiswa.</li>
                    <li>Pastikan data yang ditampilkan sesuai dengan data pendaftaran yang masuk.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Daftar Mahasiswa Baru</h5>
                </div>
                <div class="col-lg-11 d-flex justify-content-end gap-2 mt-3 me-3">
                    <a href="/admin/cmshbaru/add" class="btn btn-primary">
                        <i class='bx bxs-message-alt-add'></i> Tambah
                    </a>
                    <a href="/admin/cmshbaru/formImport" class="btn btn-warning">
                        <i class='bx bxs-file-import'></i> Import
                    </a>
                </div>

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table p-4" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Jurusan</th>
                                    <th>Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($cmshbaru as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= esc($row['nama']); ?></td>
                                        <td><?= esc($row['kode_tahun'] ?? '-') ?: '-' ?></td>
                                        <td><?= esc($row['nama_jurusan'] ?? '-') ?: '-' ?></td>
                                        <td><?= esc($row['nama_prodi'] ?? '-') ?: '-' ?></td>
                                        <td>
                                            <a href="/admin/cmshbaru/edit/<?= encrypt_url($row['id']); ?>" class="btn btn-sm btn-success"><i class='bx bx-edit-alt'></i></a>
                                            <a href="#" onclick="confirmDeleteMahasiswa('<?= encrypt_url($row['id']); ?>')" class="btn btn-sm btn-danger"><i class='bx bx-trash'></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> <!-- Tambahkan pembungkus table-responsive di sini -->
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>