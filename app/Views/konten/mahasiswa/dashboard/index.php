<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<!-- Include Select2 dan jQuery -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<h4 class="py-3">Generate NPM Mahasiswa</h4>

<?php if ($disableForm): ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        Profil Anda belum lengkap. Silakan lengkapi jurusan, prodi, tahun, dan tanggal lahir di halaman profil.
    </div>
<?php endif; ?>

<div class="card p-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <select id="nama" class="form-control" style="width: 100%" <?= $disableForm ? 'disabled' : '' ?>></select>
            <div class="form-text">Ketik minimal 3 huruf untuk mencari nama</div>
        </div>
        <div class="col-md-6">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" id="tgl_lahir" class="form-control" <?= $disableForm ? 'disabled' : '' ?> />
            <div class="form-text">Pastikan tanggal lahir sesuai dengan data profil Anda</div>
        </div>
    </div>

    <button id="generate" class="btn btn-primary" disabled <?= $disableForm ? 'disabled' : '' ?>>
        <i class="fas fa-cog"></i> Generate NPM
    </button>

    <div class="mt-4">
        <h5>Hasil:</h5>
        <div id="result" class="alert alert-info">
            <i class="fas fa-info-circle"></i> NPM akan ditampilkan di sini
        </div>
    </div>

    <!-- Debug info -->
    <div class="mt-3" id="debug-info" style="display: none;">
        <small class="text-muted">
            <strong>Debug Info:</strong><br>
            Selected ID: <span id="debug-id">-</span><br>
            Input Date: <span id="debug-date">-</span>
        </small>
    </div>
</div>

<?php if (!$disableForm): ?>
    <script>
        $(document).ready(function() {
            // Initialize Select2 untuk field nama mahasiswa
            $('#nama').select2({
                placeholder: 'Ketik minimal 3 huruf untuk mencari...',
                minimumInputLength: 3,
                ajax: {
                    url: '<?= base_url('mahasiswa/searchNama') ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });

            // Saat nama dipilih
            $('#nama').on('select2:select', function(e) {
                const data = e.params.data;
                $('#debug-id').text(data.id);
                $('#debug-info').show();
                checkForm();
            });

            // Saat tanggal lahir diisi
            $('#tgl_lahir').on('change', function() {
                $('#debug-date').text($(this).val());
                checkForm();
            });

            function checkForm() {
                const nama = $('#nama').val();
                const tgl = $('#tgl_lahir').val();
                $('#generate').prop('disabled', !(nama && tgl));
            }

            // Tombol generate
            $('#generate').on('click', function() {
                const nama = $('#nama').val();
                const tgl_lahir = $('#tgl_lahir').val();

                if (!nama || !tgl_lahir) {
                    $('#result').removeClass().addClass('alert alert-warning')
                        .html('<i class="fas fa-exclamation-triangle"></i> Mohon lengkapi semua data');
                    return;
                }

                $('#generate').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                $('#result').removeClass().addClass('alert alert-info')
                    .html('<i class="fas fa-spinner fa-spin"></i> Sedang memproses...');

                const postData = {
                    nama: nama,
                    tgllahir: tgl_lahir,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                };

                $.ajax({
                    url: '<?= base_url('mahasiswa/generateNpm') ?>',
                    method: 'POST',
                    data: postData,
                    dataType: 'json',
                    timeout: 15000,
                    success: function(data) {
                        if (data.npm) {
                            if (/tidak cocok|tidak ditemukan|sudah digenerate|tidak sesuai|Gagal/i.test(data.npm)) {
                                $('#result').removeClass().addClass('alert alert-danger')
                                    .html('<i class="fas fa-times-circle"></i> ' + data.npm);
                            } else {
                                $('#result').removeClass().addClass('alert alert-success')
                                    .html('<i class="fas fa-check-circle"></i> <strong>NPM Berhasil Digenerate: ' + data.npm + '</strong>');
                            }
                        } else {
                            $('#result').removeClass().addClass('alert alert-danger')
                                .html('<i class="fas fa-times-circle"></i> Response dari server tidak valid.');
                        }
                    },
                    error: function(xhr, status, error) {
                        let message = 'Terjadi kesalahan koneksi.';
                        if (status === 'timeout') {
                            message = 'Request timeout. Silakan coba lagi.';
                        } else if (xhr.status === 403) {
                            message = 'Akses ditolak. Silakan refresh halaman.';
                        } else if (xhr.status >= 500) {
                            message = 'Terjadi kesalahan server. Silakan coba nanti.';
                        } else if (xhr.responseText) {
                            try {
                                const json = JSON.parse(xhr.responseText);
                                message = json?.npm || message;
                            } catch (e) {
                                message += ' (' + xhr.responseText.substring(0, 100) + '...)';
                            }
                        }

                        $('#result').removeClass().addClass('alert alert-danger')
                            .html('<i class="fas fa-times-circle"></i> ' + message);
                    },
                    complete: function() {
                        $('#generate').prop('disabled', false).html('<i class="fas fa-cog"></i> Generate NPM');
                    }
                });
            });

            // Fokus otomatis ke Select2
            setTimeout(() => {
                $('#nama').select2('focus');
            }, 100);
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>