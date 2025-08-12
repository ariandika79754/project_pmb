<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-header">Import Data Mahasiswa dari Excel</h5>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="/admin/cmshbaru" class="btn btn-dark me-3 mt-3">
                        <i class='bx bx-arrow-back'></i> Kembali
                    </a>
                </div>

                <div class="col-lg-12 p-5">
                    <!-- Alert Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class='bx bx-check-circle'></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class='bx bx-error-circle'></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class='bx bx-error'></i>
                            <strong>Kesalahan Validasi:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('validation') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Instruksi -->
                    <div class="alert alert-info mb-4">
                        <h6><i class='bx bx-info-circle'></i> Panduan Upload Excel:</h6>
                        <ul class="mb-2">
                            <li>File harus dalam format <strong>.xlsx</strong> atau <strong>.xls</strong></li>
                            <li>Pastikan kolom Excel sesuai urutan yang ditentukan di bawah</li>
                            <li>Data wajib: <strong>KODE PESERTA, NAMA PESERTA, NISN</strong></li>
                            <li>Format tanggal: <strong>DD/MM/YYYY</strong> atau gunakan format Excel date</li>
                            <li>Email harus format yang valid (contoh: nama@domain.com)</li>
                            <li>NIK harus 16 digit angka</li>
                            <li>NISN harus 10 digit angka</li>
                        </ul>
                        <small class="text-muted">
                            <strong>Tips:</strong> Baris pertama adalah header, data dimulai dari baris kedua. Pastikan tidak ada baris kosong di tengah data.
                        </small>
                    </div>

                    <!-- Form Upload -->
                    <form method="POST" action="/admin/cmshbaru/importExcel" enctype="multipart/form-data" id="importForm">
                        <?= csrf_field() ?>

                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <label for="file_excel" class="form-label fw-bold">
                                    <i class='bx bx-file-blank'></i> Pilih File Excel (.xlsx/.xls)
                                </label>
                                <input type="file"
                                    class="form-control"
                                    name="file_excel"
                                    id="file_excel"
                                    accept=".xlsx,.xls"
                                    required>
                                <div class="form-text">
                                    Maksimal ukuran file: <strong>10MB</strong>. Format yang didukung: .xlsx, .xls
                                </div>
                            </div>
                        </div>

                        <!-- Options -->
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skip_duplicates" id="skip_duplicates" checked>
                                    <label class="form-check-label" for="skip_duplicates">
                                        <i class='bx bx-shield-check'></i> Skip data duplikat (berdasarkan NISN)
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="validate_strict" id="validate_strict">
                                    <label class="form-check-label" for="validate_strict">
                                        <i class='bx bx-check-shield'></i> Validasi ketat (stop jika ada error)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- File Info (akan muncul setelah pilih file) -->
                        <div id="fileInfo" style="display: none;">
                            <div class="alert alert-light border">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-file-blank text-success fs-2 me-3'></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1" id="fileName"></h6>
                                        <small class="text-muted" id="fileSize"></small>
                                        <div class="mt-1">
                                            <span class="badge bg-info" id="fileType"></span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFile()">
                                        <i class='bx bx-x'></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div id="uploadProgress" style="display: none;">
                            <div class="mb-2 d-flex justify-content-between">
                                <span>Mengupload dan memproses file...</span>
                                <span id="progressText">0%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                    style="width: 0%" id="progressBar"></div>
                            </div>
                            <small class="text-muted" id="progressStatus">Mempersiapkan upload...</small>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <button type="submit" class="btn btn-primary me-2" id="submitBtn">
                                <i class='bx bx-upload'></i> Import Data
                            </button>
                            <button type="button" class="btn btn-secondary me-2" onclick="resetForm()">
                                <i class='bx bx-reset'></i> Reset
                            </button>
                            <a href="/admin/cmshbaru/downloadTemplate" class="btn btn-outline-success">
                                <i class='bx bx-download'></i> Download Template
                            </a>
                        </div>
                    </form>

                    <!-- Contoh Format Excel -->
                    <div class="mt-5">
                        <h6><i class='bx bx-table'></i> Format Excel yang Diperlukan:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NO</th>
                                        <th>NIK</th>
                                        <th>NISN</th>
                                        <th>REGIST</th>
                                        <th>KODE PESERTA</th>
                                        <th>NAMA PESERTA</th>
                                        <th>tempat_lahir</th>
                                        <th>tanggal_lahir</th>
                                        <th>jenis_kelamin</th>
                                        <th>agama</th>
                                        <th>alamat</th>
                                        <th>telepon</th>
                                        <th>email</th>
                                        <th>nama_ayah</th>
                                        <th>nama_ibu</th>
                                        <th>pekerjaan_ayah</th>
                                        <th>pekerjaan_ibu</th>
                                        <th>asal_sekolah</th>
                                        <th>jurusan</th>
                                        <th>keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-light">
                                        <td class="text-center">1</td>
                                        <td>1234567890123456</td>
                                        <td>1234567890</td>
                                        <td>REG001</td>
                                        <td>PST001</td>
                                        <td>Ari Andika</td>
                                        <td>Jakarta</td>
                                        <td>01/01/2000</td>
                                        <td>L</td>
                                        <td>Islam</td>
                                        <td>Jl. Contoh No.1</td>
                                        <td>081234567890</td>
                                        <td>ari@example.com</td>
                                        <td>Bapak Ari</td>
                                        <td>Ibu Ari</td>
                                        <td>Pegawai</td>
                                        <td>Ibu Rumah Tangga</td>
                                        <td>SMK Negeri 1</td>
                                        <td>TKJ</td>
                                        <td>Aktif</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Keterangan Kolom -->
                        <div class="mt-3">
                            <h6><i class='bx bx-info-circle'></i> Keterangan Kolom:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><strong>NIK:</strong> 16 digit angka</li>
                                        <li><strong>NISN:</strong> 10 digit angka</li>
                                        <li><strong>tanggal_lahir:</strong> DD/MM/YYYY</li>
                                        <li><strong>jenis_kelamin:</strong> L/P</li>
                                        <li><strong>agama:</strong> Islam, Kristen, Katolik, Hindu, Buddha, Konghucu</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><strong>telepon:</strong> Format: 081234567890</li>
                                        <li><strong>email:</strong> Format valid: nama@domain.com</li>
                                        <li><strong>Kolom Wajib:</strong> KODE PESERTA, NAMA PESERTA, NISN</li>
                                        <li><strong>Kolom Opsional:</strong> Yang lainnya boleh kosong</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics (jika ada) -->
                    <?php if (session()->getFlashdata('import_stats')): ?>
                        <?php $stats = session()->getFlashdata('import_stats'); ?>
                        <div class="mt-4">
                            <div class="alert alert-success">
                                <h6><i class='bx bx-chart'></i> Hasil Import:</h6>
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="border rounded p-2">
                                            <h4 class="text-primary mb-0"><?= $stats['total'] ?? 0 ?></h4>
                                            <small>Total Baris</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-2">
                                            <h4 class="text-success mb-0"><?= $stats['success'] ?? 0 ?></h4>
                                            <small>Berhasil</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-2">
                                            <h4 class="text-warning mb-0"><?= $stats['skipped'] ?? 0 ?></h4>
                                            <small>Dilewati</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-2">
                                            <h4 class="text-danger mb-0"><?= $stats['failed'] ?? 0 ?></h4>
                                            <small>Gagal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_excel');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileType = document.getElementById('fileType');
        const submitBtn = document.getElementById('submitBtn');
        const importForm = document.getElementById('importForm');
        const uploadProgress = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const progressStatus = document.getElementById('progressStatus');

        // File input change handler
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                const allowedTypes = ['.xlsx', '.xls'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

                if (!allowedTypes.includes(fileExtension)) {
                    alert('File harus berformat .xlsx atau .xls');
                    fileInput.value = '';
                    fileInfo.style.display = 'none';
                    return;
                }

                // Validate file size (10MB = 10 * 1024 * 1024 bytes)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file tidak boleh lebih dari 10MB');
                    fileInput.value = '';
                    fileInfo.style.display = 'none';
                    return;
                }

                // Show file info
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileType.textContent = fileExtension.toUpperCase();
                fileInfo.style.display = 'block';
            } else {
                fileInfo.style.display = 'none';
            }
        });

        // Form submit handler
        importForm.addEventListener('submit', function(e) {
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Silakan pilih file Excel terlebih dahulu');
                return;
            }

            // Show progress
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Memproses...';
            uploadProgress.style.display = 'block';

            // Simulate progress (you can replace this with actual progress tracking)
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90;

                progressBar.style.width = progress + '%';
                progressText.textContent = Math.round(progress) + '%';

                if (progress < 30) {
                    progressStatus.textContent = 'Mengupload file...';
                } else if (progress < 60) {
                    progressStatus.textContent = 'Memvalidasi data...';
                } else {
                    progressStatus.textContent = 'Menyimpan ke database...';
                }
            }, 200);

            // Clear interval when form actually submits
            setTimeout(() => {
                clearInterval(progressInterval);
                progressBar.style.width = '100%';
                progressText.textContent = '100%';
                progressStatus.textContent = 'Menyelesaikan...';
            }, 3000);
        });

        // Helper functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        window.removeFile = function() {
            fileInput.value = '';
            fileInfo.style.display = 'none';
        };

        window.resetForm = function() {
            importForm.reset();
            fileInfo.style.display = 'none';
            uploadProgress.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bx-upload"></i> Import Data';
        };
    });

    // Auto dismiss alerts after 10 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            if (alert.querySelector('.btn-close')) {
                alert.querySelector('.btn-close').click();
            }
        }, 10000);
    });
</script>

<style>
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }

    .table th {
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .table td {
        font-size: 0.8rem;
    }

    .form-check-label {
        font-size: 0.9rem;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 1.2rem;
    }

    .border {
        border-color: #dee2e6 !important;
    }

    #fileInfo .alert {
        margin-bottom: 0;
    }

    .badge {
        font-size: 0.7rem;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.7rem;
        }

        .col-lg-6.text-end {
            text-align: left !important;
            margin-top: 10px;
        }
    }
</style>

<?= $this->endSection() ?>