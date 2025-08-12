<?php

namespace App\Controllers;

use App\Models\Admin\CmshBaruModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\Admin\UsersModel;
use App\Models\Admin\ProdiModel; // Untuk mapping prodi_id
use CodeIgniter\I18n\Time;

class CmshBaru extends BaseController
{
    protected $CmshBaruModel;

    public function __construct()
    {
        $this->CmshBaruModel = new CmshBaruModel();
    }

    public function cmshbaru()
    {
        $data = [
            'cmshbaru' => $this->CmshBaruModel->getAllCmshBaru()
        ];
        // dd($data);
        return view('konten/admin/cmshbaru/index.php', $data);
    }
    public function add()
    {
        return view('konten/admin/cmshbaru/add');
    }

    public function save()
    {
        $userModel = new \App\Models\Admin\UsersModel();
        $cmshModel = new \App\Models\Admin\CmshBaruModel();

        $tglLahir = $this->request->getPost('tgl_lahir');
        $kodePeserta = $this->request->getPost('kode_peserta');

        // Format password dari tanggal lahir
        $tglLahirFormatted = $tglLahir ? date('Y-m-d', strtotime($tglLahir)) : null;
        $passwordDate = $tglLahirFormatted ? date('dmY', strtotime($tglLahirFormatted)) : date('dmY');
        $hashedPassword = hash('sha256', sha1($passwordDate));

        // Simpan ke tabel users
        $userId = $userModel->insert([
            'username' => $kodePeserta,
            'password' => $hashedPassword,
            'role_id' => 2,
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ], true);

        if (!$userId) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan user.');
        }

        // Simpan ke tabel mahasiswa
        $cmshModel->insert([
            'kode_peserta' => $kodePeserta,
            'nisn' => $this->request->getPost('nisn'),
            'nama' => $this->request->getPost('nama'),
            'tgl_lahir' => $tglLahirFormatted,
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'tipe_sekolah' => $this->request->getPost('tipe_sekolah'),
            'jurusan_asal' => $this->request->getPost('jurusan_asal'),
            'tahun_lulus' => $this->request->getPost('tahun_lulus'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'agama' => $this->request->getPost('agama'),
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
            'users_id' => $userId,
        ]);

        return redirect()->to('/admin/cmshbaru')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function formImport()
    {
        return view('konten/admin/cmshbaru/import.php');
    }

    public function importExcel()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); // 5 menit

        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $reader = new Xlsx();

                // Konfigurasi reader untuk menghindari masalah dengan structured references
                $reader->setReadDataOnly(true);
                $reader->setReadEmptyCells(false);

                $spreadsheet = $reader->load($file->getTempName());
                $sheet = $spreadsheet->getActiveSheet();

                // Ambil data sebagai array dengan range yang lebih aman
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Convert ke array dengan cara yang lebih aman
                $sheetData = [];
                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = [];
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cellValue = $sheet->getCell($col . $row)->getCalculatedValue();
                        $rowData[] = $cellValue;
                    }
                    $sheetData[] = $rowData;
                }

                $userModel = new UsersModel();
                $prodiModel = new ProdiModel();
                $successCount = 0;
                $errorCount = 0;
                $errors = [];

                // Debug: tampilkan beberapa baris pertama
                log_message('debug', 'Total rows: ' . count($sheetData));
                if (count($sheetData) > 1) {
                    log_message('debug', 'Sample row: ' . json_encode($sheetData[1]));
                }

                // Mulai dari baris kedua (skip header)
                for ($i = 1; $i < count($sheetData); $i++) {
                    try {
                        $row = $sheetData[$i];

                        // Pastikan row memiliki data
                        if (empty($row) || count($row) < 10) {
                            continue; // Skip baris kosong
                        }

                        // Mapping kolom sesuai Excel (index dimulai dari 0)
                        $kodePeserta = isset($row[3]) ? trim($row[3]) : '';
                        $namaPeserta = isset($row[4]) ? trim($row[4]) : '';
                        $nisn = isset($row[1]) ? trim($row[1]) : '';
                        $namaProdiTerima = isset($row[12]) ? trim($row[12]) : '';
                        $telepon = isset($row[10]) ? trim($row[10]) : '';
                        $email = isset($row[11]) ? trim($row[11]) : '';
                        $agama = isset($row[8]) ? trim($row[8]) : '';

                        // Tangani tanggal lahir dengan lebih hati-hati
                        $tglLahir = isset($row[6]) ? $row[6] : '';
                        $namaSlta = isset($row[17]) ? trim($row[17]) : '';
                        $tahunLulusSlta = isset($row[19]) ? trim($row[19]) : '';
                        $jurusanSlta = isset($row[18]) ? trim($row[18]) : '';

                        // Validasi data wajib
                        if (empty($kodePeserta) || empty($namaPeserta) || empty($nisn)) {
                            $errors[] = "Baris " . ($i + 1) . ": Data wajib tidak lengkap (Kode: '$kodePeserta', Nama: '$namaPeserta', NISN: '$nisn')";
                            $errorCount++;
                            continue;
                        }

                        // Parsing tanggal lahir dengan error handling yang lebih baik
                        $tglLahirFormatted = '';
                        if (!empty($tglLahir)) {
                            try {
                                if (is_numeric($tglLahir)) {
                                    // Jika format Excel date serial
                                    $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglLahir);
                                    $tglLahirFormatted = $dateObj->format('Y-m-d');
                                } else {
                                    // Jika sudah dalam format string, coba parse
                                    $dateFormats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d'];
                                    foreach ($dateFormats as $format) {
                                        $date = \DateTime::createFromFormat($format, $tglLahir);
                                        if ($date) {
                                            $tglLahirFormatted = $date->format('Y-m-d');
                                            break;
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                log_message('error', "Error parsing date for row " . ($i + 1) . ": " . $e->getMessage());
                            }
                        }

                        // Validasi email
                        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Baris " . ($i + 1) . ": Format email tidak valid: '$email'";
                            $errorCount++;
                            continue;
                        }

                        // Cari prodi_id dan jurusan_id berdasarkan nama prodi yang diterima
                        $prodiId = null;
                        $jurusanId = null;
                        if (!empty($namaProdiTerima)) {
                            // Coba exact match dulu
                            $prodi = $prodiModel->where('nama_prodi', $namaProdiTerima)->first();
                            if (!$prodi) {
                                // Coba dengan LIKE untuk matching yang lebih fleksibel
                                $prodi = $prodiModel->like('nama_prodi', $namaProdiTerima, 'both')->first();
                            }

                            if ($prodi) {
                                $prodiId = $prodi['id'];
                                $jurusanId = $prodi['jurusan_id']; // Ambil jurusan_id dari data prodi
                            } else {
                                // Log untuk debugging
                                log_message('info', "Prodi tidak ditemukan: '$namaProdiTerima' pada baris " . ($i + 1));
                                // Jangan skip, biarkan prodi_id dan jurusan_id null
                            }
                        }

                        // Cek apakah user sudah ada
                        $existingUser = $userModel->where('username', $kodePeserta)->first();
                        if ($existingUser) {
                            $errors[] = "Baris " . ($i + 1) . ": Username '$kodePeserta' sudah ada";
                            $errorCount++;
                            continue;
                        }

                        // Cek apakah NISN sudah ada
                        $existingNisn = $this->CmshBaruModel->where('nisn', $nisn)->first();
                        if ($existingNisn) {
                            $errors[] = "Baris " . ($i + 1) . ": NISN '$nisn' sudah ada";
                            $errorCount++;
                            continue;
                        }

                        // Mulai database transaction
                        $db = \Config\Database::connect();
                        $db->transStart();

                        try {
                            // Simpan ke tabel users
                            $username = $kodePeserta;
                            $nama = $namaPeserta;
                            $passwordDate = !empty($tglLahirFormatted) ? date('dmY', strtotime($tglLahirFormatted)) : date('dmY');
                            $hashedPassword = hash('sha256', sha1($passwordDate));

                            $userId = $userModel->insert([
                                'username' => $username,
                                'nama' => $nama,
                                'password' => $hashedPassword,
                                'role_id' => 2, // mahasiswa
                                'created_at' => Time::now(),
                                'updated_at' => Time::now(),
                            ], true);

                            if (!$userId) {
                                throw new \Exception("Gagal menyimpan user");
                            }

                            // Gabungkan nama kabupaten dan provinsi untuk tipe sekolah
                            $tipeSekolah = '';
                            if (!empty($kabSlta) && !empty($provSlta)) {
                                $tipeSekolah = $kabSlta . ', ' . $provSlta;
                            } elseif (!empty($kabSlta)) {
                                $tipeSekolah = $kabSlta;
                            } elseif (!empty($provSlta)) {
                                $tipeSekolah = $provSlta;
                            }

                            // Prepare data untuk insert
                            $mahasiswaData = [
                                'nisn' => $nisn,
                                'nama' => $namaPeserta,
                                'tgl_lahir' => $tglLahirFormatted ?: null,
                                'nama_sekolah' => $namaSlta,
                                'tipe_sekolah' => $tipeSekolah,
                                'jurusan_asal' => $jurusanSlta,
                                'tahun_lulus' => $tahunLulusSlta,
                                'email' => $email,
                                'no_hp' => $telepon,
                                'agama' => $agama,
                                'created_at' => Time::now(),
                                'updated_at' => Time::now(),
                                'users_id' => $userId,
                                'prodi_id' => $prodiId,
                                'jurusan_id' => $jurusanId,
                                'tahun_id' => 1,  // Tambahkan jurusan_id

                                'nik' => isset($row[0]) ? trim($row[0]) : null,
                                'kode_peserta' => $kodePeserta,
                                'nama_prodi_terima' => $namaProdiTerima,
                                'alamat' => isset($row[9]) ? trim($row[9]) : null,
                                'tempat_lahir' => isset($row[5]) ? trim($row[5]) : null,
                                'telepon' => $telepon,
                                'nama_ayah' => isset($row[13]) ? trim($row[13]) : null,
                                'pekerjaan_ayah' => isset($row[15]) ? trim($row[15]) : null,
                                'nama_ibu' => isset($row[14]) ? trim($row[14]) : null,
                                'pekerjaan_ibu' => isset($row[16]) ? trim($row[16]) : null,
                            ];

                            // Remove null/empty values untuk menghindari error
                            $mahasiswaData = array_filter($mahasiswaData, function ($value) {
                                return $value !== null && $value !== '';
                            });

                            $insertResult = $this->CmshBaruModel->insert($mahasiswaData);

                            if (!$insertResult) {
                                throw new \Exception("Gagal menyimpan data mahasiswa");
                            }

                            // Commit transaction
                            $db->transCommit();
                            $successCount++;
                        } catch (\Exception $e) {
                            // Rollback transaction
                            $db->transRollback();
                            $errorCount++;
                            $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                            log_message('error', "Error inserting data for row " . ($i + 1) . ": " . $e->getMessage());
                        }
                    } catch (\Exception $e) {
                        $errorCount++;
                        $errors[] = "Baris " . ($i + 1) . ": Error processing - " . $e->getMessage();
                        log_message('error', "Error processing row " . ($i + 1) . ": " . $e->getMessage());
                    }
                }

                // Buat pesan hasil import
                $message = "📊 Import selesai!<br>";
                $message .= "✅ Berhasil: <strong>{$successCount}</strong> data<br>";
                $message .= "❌ Gagal: <strong>{$errorCount}</strong> data";

                if (!empty($errors)) {
                    $message .= "<br><br>📋 Detail Error (10 teratas):<br>";
                    $errorSample = array_slice($errors, 0, 10);
                    foreach ($errorSample as $error) {
                        $message .= "• " . htmlspecialchars($error) . "<br>";
                    }

                    if (count($errors) > 10) {
                        $message .= "• ... dan " . (count($errors) - 10) . " error lainnya<br>";
                    }
                }

                if ($successCount > 0) {
                    return redirect()->to('/admin/cmshbaru')->with('success', $message);
                } else {
                    return redirect()->to('/admin/cmshbaru/formImport')->with('error', $message);
                }
            } catch (\Exception $e) {
                log_message('error', 'Excel import error: ' . $e->getMessage());
                return redirect()->back()->with('error', '🚫 Error membaca file Excel: ' . $e->getMessage());
            }
        }
        return redirect()->back()->with('error', '🚫 File tidak valid atau tidak dapat diproses.');
    }
}
