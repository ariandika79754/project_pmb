<?= $this->extend('layout/page') ?>
<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="fw-light">Profil Mahasiswa</span></h4>

<?php
// Di bagian controller atau di view, tambahkan logika untuk mengecek kelengkapan profil
$requiredFields = ['nama', 'tgl_lahir', 'nisn', 'nama_sekolah', 'tipe_sekolah', 'jurusan_asal', 'tahun_lulus', 'email', 'no_hp'];
$isProfileComplete = true;

foreach ($requiredFields as $field) {
    if (empty($mahasiswa[$field])) {
        $isProfileComplete = false;
        break;
    }
}
?>
<?php if ($profilTidakLengkap): ?>
    <div class="alert alert-warning">
        Profil Anda belum lengkap. Silakan anda melengkapi data-data yang belum terisi.
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-10 mb-4 order-0">
        <form action="<?= base_url('/mahasiswa/profile/update') ?>" method="post" enctype="multipart/form-data">
            <div class="card mb-4">
                <h5 class="card-header">Data Mahasiswa</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="text-center mb-4">
                            <?php if (!empty($mahasiswa['foto'])): ?>
                                <img id="previewImage" src="<?= !empty($mahasiswa['foto']) ? base_url('uploads/mahasiswa/' . $mahasiswa['foto']) : base_url('assets/img/default-user.png') ?>" alt="Foto Profil" width="120" style="object-fit: cover; height: 120px; border-radius: 10px;" />
                            <?php else: ?>
                                <img id="previewImage" src="<?= base_url('uploads/mahasiswa/default.png') ?>" alt="Default Foto" width="120" style="object-fit: cover; height: 120px; border-radius: 10px;">
                            <?php endif; ?>

                            <div class="mt-2">
                                <label for="foto" class="form-label"></label>
                                <input type="file" name="foto" id="foto" accept="image/*" class="d-none" onchange="previewFile(this)">
                                <label for="foto" class="btn btn-primary" id="uploadLabel">Upload new photo</label>
                                <div class="form-text text-muted">File yang diizinkan adalah JPG, GIF, atau PNG. File paling besar 500K</div>
                                <div class="form-text text-warning"><strong>*kosongkan jika tidak ingin merubah foto</strong></div>
                            </div>
                        </div>


                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username / Kode Peserta</label>
                            <input class="form-control" type="text" value="<?= esc($mahasiswa['username'] ?? '') ?>" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordField">
                                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                    <i class="bx bx-show" id="eyeIcon"></i>
                                </span>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama</label>
                            <input class="form-control" type="text" name="nama" value="<?= esc($mahasiswa['nama']) ?>">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input class="form-control" type="date" name="tgl_lahir" value="<?= esc($mahasiswa['tgl_lahir']) ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NISN</label>
                            <input class="form-control" type="text" name="nisn" value="<?= esc($mahasiswa['nisn'] ?? '') ?>">
                        </div>

                        <!-- Sudah Ada: Nama -->

                        <!-- Sudah Ada: Tanggal Lahir -->

                        <!-- Tambahan: Nama Sekolah -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama Sekolah</label>
                            <input class="form-control" type="text" name="nama_sekolah" value="<?= esc($mahasiswa['nama_sekolah'] ?? '') ?>">
                        </div>

                        <!-- Tambahan: Tipe Sekolah -->
                        <!-- Tipe Sekolah -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tipe Sekolah *</label>
                            <select name="tipe_sekolah" id="tipe_sekolah" class="form-select" required>
                                <option value="">-</option>
                                <option value="SMA" <?= $mahasiswa['tipe_sekolah'] == 'SMA' ? 'selected' : '' ?>>SMA</option>
                                <option value="SMK" <?= $mahasiswa['tipe_sekolah'] == 'SMK' ? 'selected' : '' ?>>SMK</option>
                                <option value="MA" <?= $mahasiswa['tipe_sekolah'] == 'MA' ? 'selected' : '' ?>>MA</option>
                            </select>
                        </div>

                        <!-- Jurusan Otomatis -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Keahlian/Jurusan *</label>
                            <select name="jurusan_asal" id="jurusan" class="form-select select2" required>
                                <option value="">-</option>
                                <?php
                                $sma = [
                                    'IPA',
                                    'IPS',
                                    'Bahasa',
                                    'Agama',
                                    'Lintas Minat',
                                    'umum',
                                    'Matematika dan Ilmu Pengetahuan Alam'
                                ];
                                $smk = [
                                    'Teknik Mesin',
                                    'Teknik Otomotif',
                                    'Teknik Audio Video',
                                    'Teknik Elektronika Industri',
                                    'Teknik Ketenagalistrikan',
                                    'Teknik Pendingin dan Tata Udara',
                                    'Teknik Gambar Bangunan',
                                    'Teknik Konstruksi dan Properti',
                                    'Teknik Geomatika',
                                    'Teknik Permesinan',
                                    'Teknik Mekatronika',
                                    'Teknik Sepeda Motor',
                                    'Teknik Kendaraan Ringan',
                                    'Teknik Logistik',

                                    // Teknologi Informasi dan Komunikasi
                                    'Teknik Komputer dan Jaringan',
                                    'Rekayasa Perangkat Lunak',
                                    'Multimedia',
                                    'Sistem Informatika, Jaringan dan Aplikasi',

                                    // Bisnis dan Manajemen
                                    'Akuntansi dan Keuangan Lembaga',
                                    'Otomatisasi dan Tata Kelola Perkantoran',
                                    'Bisnis Daring dan Pemasaran',
                                    'Manajemen Perkantoran',
                                    'Perbankan dan Keuangan Mikro',

                                    // Pariwisata
                                    'Usaha Perjalanan Wisata',
                                    'Akomodasi Perhotelan',
                                    'Tata Boga',
                                    'Tata Busana',
                                    'Tata Kecantikan Kulit dan Rambut',

                                    // Agribisnis dan Agroteknologi
                                    'Agribisnis Tanaman Pangan dan Hortikultura',
                                    'Agribisnis Ternak',
                                    'Agribisnis Perikanan Air Tawar',
                                    'Agribisnis Perikanan Laut',
                                    'Agribisnis Pengolahan Hasil Pertanian',
                                    'Agribisnis Perkebunan',

                                    // Kesehatan dan Pekerjaan Sosial
                                    'Farmasi',
                                    'Keperawatan',
                                    'Teknologi Laboratorium Medik',
                                    'Kesehatan Gigi',
                                    'Pekerjaan Sosial',

                                    // Kemaritiman dan Transportasi
                                    'Nautika Kapal Niaga',
                                    'Teknika Kapal Niaga',
                                    'Nautika Kapal Penangkap Ikan',
                                    'Transportasi Darat',
                                    'Transportasi Udara',

                                    // Seni dan Industri Kreatif
                                    'Seni Musik',
                                    'Seni Tari',
                                    'Seni Teater',
                                    'Animasi',
                                    'Desain Komunikasi Visual',
                                    'Kriya Kreatif Batik',
                                    'Kriya Kreatif Kayu',
                                    'Kriya Kreatif Logam',
                                    'Kriya Kreatif Tekstil'
                                ];
                                $ma = [
                                    'IPA',
                                    'IPS',
                                    'Keagamaan',
                                    'Bahasa',
                                    'Ilmu Ushuluddin',
                                    'Ilmu Hadits dan Tafsir',
                                    'Ilmu Syariah'
                                ];

                                $semua_jurusan = array_merge($sma, $smk, $ma);
                                foreach ($semua_jurusan as $item): ?>
                                    <option value="<?= $item ?>" <?= $mahasiswa['jurusan_asal'] == $item ? 'selected' : '' ?>><?= $item ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tahun Lulus -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tahun Lulus *</label>
                            <select name="tahun_lulus" class="form-select" required>
                                <option value="">-</option>
                                <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                                    <option value="<?= $i ?>" <?= $mahasiswa['tahun_lulus'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>


                        <!-- Tambahan: Email -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="<?= esc($mahasiswa['email'] ?? '') ?>" readonly>
                        </div>

                        <!-- Tambahan: No HP -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">No HP</label>
                            <input class="form-control" type="text" name="no_hp" value="<?= esc($mahasiswa['no_hp'] ?? '') ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Jurusan</label>
                            <select class="form-control" name="jurusan_id" disabled>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach ($jurusan as $item): ?>
                                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $mahasiswa['jurusan_id'] ? 'selected' : '' ?>>
                                        <?= $item['nama_jurusan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Program Studi</label>
                            <select class="form-control" name="prodi_id" disabled>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodi as $item): ?>
                                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $mahasiswa['prodi_id'] ? 'selected' : '' ?>>
                                        <?= $item['nama_prodi'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tahun Akademik</label>
                            <select class="form-control" name="tahun_id" disabled>
                                <option value="">-- Pilih Tahun Akademik --</option>
                                <?php foreach ($tahun as $item): ?>
                                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $mahasiswa['tahun_id'] ? 'selected' : '' ?>>
                                        <?= $item['kode_tahun'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                        <?php if ($isProfileComplete): ?>
                            <a href="<?= base_url('/mahasiswa/profile/export') ?>" class="btn btn-warning">Export Nametag</a>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled title="Lengkapi profil terlebih dahulu untuk export nametag">
                                <i class="bx bx-lock"></i> Export Nametag
                            </button>
                            <small class="text-danger mt-1">*Lengkapi semua data profil untuk dapat mengexport nametag</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const jurusanOptions = {
        SMA: [
            'IPA',
            'IPS',
            'Bahasa',
            'Agama',
            'Lintas Minat', 'umum',
            'Matematika dan Ilmu Pengetahuan Alam'
        ],
        MA: [
            'IPA',
            'IPS',
            'Keagamaan',
            'Bahasa',
            'Ilmu Ushuluddin',
            'Ilmu Hadits dan Tafsir',
            'Ilmu Syariah'
        ],
        SMK: [
            // Teknologi dan Rekayasa
            'Teknik Mesin',
            'Teknik Otomotif',
            'Teknik Audio Video',
            'Teknik Elektronika Industri',
            'Teknik Ketenagalistrikan',
            'Teknik Pendingin dan Tata Udara',
            'Teknik Gambar Bangunan',
            'Teknik Konstruksi dan Properti',
            'Teknik Geomatika',
            'Teknik Permesinan',
            'Teknik Mekatronika',
            'Teknik Sepeda Motor',
            'Teknik Kendaraan Ringan',
            'Teknik Logistik',

            // Teknologi Informasi dan Komunikasi
            'Teknik Komputer dan Jaringan',
            'Rekayasa Perangkat Lunak',
            'Multimedia',
            'Sistem Informatika, Jaringan dan Aplikasi',

            // Bisnis dan Manajemen
            'Akuntansi dan Keuangan Lembaga',
            'Otomatisasi dan Tata Kelola Perkantoran',
            'Bisnis Daring dan Pemasaran',
            'Manajemen Perkantoran',
            'Perbankan dan Keuangan Mikro',

            // Pariwisata
            'Usaha Perjalanan Wisata',
            'Akomodasi Perhotelan',
            'Tata Boga',
            'Tata Busana',
            'Tata Kecantikan Kulit dan Rambut',

            // Agribisnis dan Agroteknologi
            'Agribisnis Tanaman Pangan dan Hortikultura',
            'Agribisnis Ternak',
            'Agribisnis Perikanan Air Tawar',
            'Agribisnis Perikanan Laut',
            'Agribisnis Pengolahan Hasil Pertanian',
            'Agribisnis Perkebunan',

            // Kesehatan dan Pekerjaan Sosial
            'Farmasi',
            'Keperawatan',
            'Teknologi Laboratorium Medik',
            'Kesehatan Gigi',
            'Pekerjaan Sosial',

            // Kemaritiman dan Transportasi
            'Nautika Kapal Niaga',
            'Teknika Kapal Niaga',
            'Nautika Kapal Penangkap Ikan',
            'Transportasi Darat',
            'Transportasi Udara',

            // Seni dan Industri Kreatif
            'Seni Musik',
            'Seni Tari',
            'Seni Teater',
            'Animasi',
            'Desain Komunikasi Visual',
            'Kriya Kreatif Batik',
            'Kriya Kreatif Kayu',
            'Kriya Kreatif Logam',
            'Kriya Kreatif Tekstil'
        ]
    };

    document.getElementById('tipe_sekolah').addEventListener('change', function() {
        const selected = this.value;
        const jurusanSelect = document.getElementById('jurusan');

        // Simpan jurusan yang sudah dipilih sebelumnya
        const currentValue = jurusanSelect.value;

        // Kosongkan jurusan hanya jika belum terisi
        jurusanSelect.innerHTML = '<option value="">-</option>';

        if (jurusanOptions[selected]) {
            jurusanOptions[selected].forEach(function(jurusan) {
                const opt = document.createElement('option');
                opt.value = jurusan;
                opt.text = jurusan;
                if (jurusan === currentValue) {
                    opt.selected = true;
                }
                jurusanSelect.appendChild(opt);
            });
        }
    });


    // Trigger saat halaman pertama kali dimuat (agar jurusan terisi saat edit)
    window.addEventListener('DOMContentLoaded', function() {
        const currentTipe = document.getElementById('tipe_sekolah').value;
        const currentJurusan = "<?= $mahasiswa['jurusan_asal'] ?>";
        const jurusanSelect = document.getElementById('jurusan');

        // Jika tidak ada jurusan yang terisi (misalnya baru input), baru isi otomatis
        if (jurusanSelect.value === '' && jurusanOptions[currentTipe]) {
            jurusanOptions[currentTipe].forEach(function(jurusan) {
                const opt = document.createElement('option');
                opt.value = jurusan;
                opt.text = jurusan;
                if (jurusan === currentJurusan) {
                    opt.selected = true;
                }
                jurusanSelect.appendChild(opt);
            });
        }
    });
</script>

<!-- Script toggle password visibility -->
<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('bx-show');
            eyeIcon.classList.add('bx-hide');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('bx-hide');
            eyeIcon.classList.add('bx-show');
        }
    }

    function previewFile(input) {
        const file = input.files[0];
        const reader = new FileReader();
        const preview = document.getElementById('previewImage');

        if (file) {
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);

            // Tampilkan nama file di tombol (opsional)
            document.getElementById('uploadLabel').innerText = file.name;
        }
    }
</script>
<script>
    // Inisialisasi Select2
    $(document).ready(function() {
        $('#jurusan').select2({
            placeholder: 'Pilih atau ketik jurusan',
            allowClear: true
        });
    });
</script>

<?= $this->endSection() ?>