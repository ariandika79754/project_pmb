<?php

namespace App\Controllers;

use App\Models\Admin\CmshBaruModel;
use App\Models\Admin\NpmModel;

class MahasiswaDashboard extends BaseController
{
    public function index()
    {
        $model = new CmshBaruModel();
        $userId = session()->get('data')['id'];

        $mahasiswa = $model->where('users_id', $userId)->first();

        $profilTidakLengkap = !$mahasiswa
            || empty($mahasiswa['jurusan_id'])
            || empty($mahasiswa['prodi_id'])
            || empty($mahasiswa['tahun_id'])
            || empty($mahasiswa['tgl_lahir'])
            || empty($mahasiswa['nisn'])
            || empty($mahasiswa['no_hp'])
            || empty($mahasiswa['nama_sekolah'])
            || empty($mahasiswa['tipe_sekolah'])
            || empty($mahasiswa['jurusan_asal'])
            || empty($mahasiswa['tahun_lulus']);

        return view('konten/mahasiswa/dashboard/index', [
            'disableForm' => $profilTidakLengkap,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function searchNama()
    {
        $query = $this->request->getGet('query');
        $model = new CmshBaruModel();

        $data = $model
            ->like('nama', $query)
            ->orderBy('nama', 'asc')
            ->limit(10)
            ->findAll();

        $results = array_map(function ($row) {
            return [
                'id' => $row['id'],
                'text' => $row['nama']
            ];
        }, $data);

        return $this->response->setJSON(['results' => $results]);
    }

    public function generateNpm()
    {
        $this->response->setContentType('application/json');

        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)
                ->setJSON(['npm' => 'Metode request tidak valid.']);
        }

        try {
            $idMahasiswa = $this->request->getPost('nama');
            $tglInput = $this->request->getPost('tgllahir');

            if (empty($idMahasiswa) || empty($tglInput)) {
                return $this->response->setJSON(['npm' => 'Nama dan tanggal lahir wajib diisi.']);
            }

            $model = new CmshBaruModel();
            $npmModel = new NpmModel();

            $mhs = $model
                ->select('mahasiswa.*, prodi.kode_prodi, prodi.total_kelas')
                ->join('prodi', 'prodi.id = mahasiswa.prodi_id', 'left')
                ->where('mahasiswa.id', $idMahasiswa)
                ->first();

            if (!$mhs) {
                return $this->response->setJSON(['npm' => 'Data mahasiswa tidak ditemukan.']);
            }

            if (empty($mhs['kode_prodi'])) {
                return $this->response->setJSON(['npm' => 'Kode prodi belum tersedia.']);
            }

            if (empty($mhs['total_kelas']) || $mhs['total_kelas'] < 1) {
                return $this->response->setJSON(['npm' => 'Total kelas prodi belum diatur.']);
            }

            if (!$this->validateDateSafe($mhs['tgl_lahir'], $tglInput)) {
                return $this->response->setJSON([
                    'npm' => 'Tanggal lahir tidak cocok. Tersimpan: ' . ($mhs['tgl_lahir'] ?? 'null')
                ]);
            }

            $existing = $npmModel->where('mahasiswa_id', $idMahasiswa)->first();
            if ($existing) {
                return $this->response->setJSON(['npm' => 'NPM sudah digenerate: ' . $existing['npm']]);
            }

            // Generate NPM dengan sistem pembagian kelas
            $npmBaru = $this->generateNpmWithClassDistribution($mhs, $model, $npmModel);

            if (!$npmBaru) {
                return $this->response->setJSON(['npm' => 'Gagal generate NPM.']);
            }

            $insert = $npmModel->insert([
                'mahasiswa_id' => $idMahasiswa,
                'npm' => $npmBaru,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if (!$insert) {
                return $this->response->setJSON(['npm' => 'Gagal menyimpan NPM.']);
            }

            return $this->response->setJSON(['npm' => $npmBaru]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['npm' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function generateNpmWithClassDistribution($currentMhs, $model, $npmModel): ?string
    {
        try {
            $kodeProdi = $currentMhs['kode_prodi'];
            $totalKelas = (int)$currentMhs['total_kelas'];
            $prodiId = $currentMhs['prodi_id'];

            // Ambil semua mahasiswa dari prodi yang sama, urutkan berdasarkan nama (abjad) kemudian created_at
            $allMahasiswa = $model
                ->select('mahasiswa.id, mahasiswa.nama, mahasiswa.created_at')
                ->join('prodi', 'prodi.id = mahasiswa.prodi_id', 'left')
                ->where('mahasiswa.prodi_id', $prodiId)
                ->orderBy('mahasiswa.nama', 'asc')
                ->orderBy('mahasiswa.created_at', 'asc')
                ->findAll();

            if (empty($allMahasiswa)) {
                return null;
            }

            // Cari posisi mahasiswa saat ini dalam urutan
            $posisiMahasiswa = null;
            foreach ($allMahasiswa as $index => $mhs) {
                if ($mhs['id'] == $currentMhs['id']) {
                    $posisiMahasiswa = $index;
                    break;
                }
            }

            if ($posisiMahasiswa === null) {
                return null;
            }

            // Hitung urutan global (mulai dari 1)
            $urutanGlobal = $posisiMahasiswa + 1;

            // Tentukan kelas berdasarkan distribusi merata
            // Mahasiswa dibagi secara berurutan ke setiap kelas
            $kelasIndex = (($urutanGlobal - 1) % $totalKelas) + 1; // Kelas 1, 2, 3, dst
            $kelasHuruf = chr(64 + $kelasIndex); // A, B, C, dst (A = 65)

            // Hitung urutan dalam kelas
            // Mahasiswa ke-1,4,7 masuk kelas A (urutan 1,2,3)
            // Mahasiswa ke-2,5,8 masuk kelas B (urutan 1,2,3)
            // Mahasiswa ke-3,6,9 masuk kelas C (urutan 1,2,3)
            $urutanDalamKelas = intval(($urutanGlobal - $kelasIndex) / $totalKelas) + 1;

            // Format NPM: KodeProdi + KelasHuruf + UrutanDalamKelas (3 digit)
            $npmBaru = $kodeProdi . str_pad($urutanDalamKelas, 3, '0', STR_PAD_LEFT);

            return $npmBaru;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function validateDateSafe($storedDate, $inputDate): bool
    {
        try {
            if (empty($storedDate) || empty($inputDate)) return false;

            $dbDate = $this->parseDateFlexible($storedDate);
            $input = $this->parseDateFlexible($inputDate);

            return $dbDate === $input;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function parseDateFlexible($date): ?string
    {
        try {
            if (empty($date)) return null;

            $date = str_replace('/', '-', trim($date));
            $formats = ['Y-m-d', 'd-m-Y', 'm-d-Y', 'Y/m/d', 'd/m/Y', 'm/d/Y'];

            foreach ($formats as $fmt) {
                $parsed = \DateTime::createFromFormat($fmt, $date);
                if ($parsed && $parsed->format($fmt) === $date) {
                    return $parsed->format('Y-m-d');
                }
            }

            $timestamp = strtotime($date);
            return $timestamp ? date('Y-m-d', $timestamp) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Generate NPM untuk semua mahasiswa dalam satu prodi secara batch
     * Panggil fungsi ini jika ingin mengupdate semua NPM sekaligus
     */
    public function generateNpmBatch($prodiId = null)
    {
        if (!$prodiId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Prodi ID required']);
        }

        try {
            $model = new CmshBaruModel();
            $npmModel = new NpmModel();

            // Ambil info prodi
            $prodi = $model
                ->select('prodi.kode_prodi, prodi.total_kelas')
                ->join('prodi', 'prodi.id = mahasiswa.prodi_id', 'left')
                ->where('mahasiswa.prodi_id', $prodiId)
                ->first();

            if (!$prodi || empty($prodi['total_kelas'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data prodi tidak lengkap']);
            }

            $kodeProdi = $prodi['kode_prodi'];
            $totalKelas = (int)$prodi['total_kelas'];

            // Ambil semua mahasiswa dari prodi, urutkan berdasarkan nama kemudian created_at
            $allMahasiswa = $model
                ->select('mahasiswa.id, mahasiswa.nama, mahasiswa.created_at')
                ->where('mahasiswa.prodi_id', $prodiId)
                ->orderBy('mahasiswa.nama', 'asc')
                ->orderBy('mahasiswa.created_at', 'asc')
                ->findAll();

            $generated = 0;
            $errors = [];

            foreach ($allMahasiswa as $index => $mhs) {
                // Cek apakah NPM sudah ada
                $existing = $npmModel->where('mahasiswa_id', $mhs['id'])->first();
                if ($existing) {
                    continue; // Skip jika sudah ada NPM
                }

                // Hitung urutan global (mulai dari 1)
                $urutanGlobal = $index + 1;

                // Tentukan kelas berdasarkan distribusi merata
                $kelasIndex = (($urutanGlobal - 1) % $totalKelas) + 1;
                $kelasHuruf = chr(64 + $kelasIndex); // A, B, C, dst

                // Hitung urutan dalam kelas
                $urutanDalamKelas = intval(($urutanGlobal - $kelasIndex) / $totalKelas) + 1;

                // Format NPM
                $npmBaru = $kodeProdi . $kelasHuruf . str_pad($urutanDalamKelas, 3, '0', STR_PAD_LEFT);

                // Insert ke database
                $insert = $npmModel->insert([
                    'mahasiswa_id' => $mhs['id'],
                    'npm' => $npmBaru,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if ($insert) {
                    $generated++;
                } else {
                    $errors[] = "Gagal generate NPM untuk {$mhs['nama']}";
                }
            }

            return $this->response->setJSON([
                'status' => 'success',
                'generated' => $generated,
                'errors' => $errors,
                'message' => "Berhasil generate {$generated} NPM"
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
