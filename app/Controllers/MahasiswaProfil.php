<?php

namespace App\Controllers;

use App\Models\Admin\UsersModel;
use App\Models\Admin\CmshBaruModel;
use App\Models\Admin\JurusanModel;
use App\Models\Admin\ProdiModel;
use App\Models\Admin\TahunModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\ResponseInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class MahasiswaProfil extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        $usersId = session()->get('data')['id'];
        $mhsModel = new CmshBaruModel();
        $mahasiswa = $mhsModel->getByUsersId($usersId);

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

        $jurusanModel = new JurusanModel();
        $prodiModel = new ProdiModel();
        $tahunModel = new TahunModel();

        $data = [
            'mahasiswa' => $mahasiswa,
            'profilTidakLengkap' => $profilTidakLengkap,
            'jurusan' => $jurusanModel->findAll(),
            'prodi' => $prodiModel->findAll(),
            'tahun' => $tahunModel->findAll(),
            'errors' => session('errors')
        ];

        return view('konten/mahasiswa/profil/index', $data);
    }

    public function updateProfil()
    {
        $usersId = session()->get('data')['id'];

        $password = $this->request->getPost('password');
        $nama = $this->request->getPost('nama');
        $tglLahir = $this->request->getPost('tgl_lahir');
        $jurusanId = $this->request->getPost('jurusan_id');
        $prodiId = $this->request->getPost('prodi_id');
        $tahunId = $this->request->getPost('tahun_id');
        $nisn = $this->request->getPost('nisn');
        $namaSekolah = $this->request->getPost('nama_sekolah');
        $tipeSekolah = $this->request->getPost('tipe_sekolah');
        $jurusanAsal = $this->request->getPost('jurusan_asal');
        $tahunLulus = $this->request->getPost('tahun_lulus');
        $noHp = $this->request->getPost('no_hp');

        $userData = [];
        $mhsData = [];

        if (!empty($password)) {
            $userData['password'] = hash('sha256', sha1($password));
        }
        if (!empty($nama)) {
            $userData['nama'] = $nama;
            $mhsData['nama'] = $nama;
        }
        if (!empty($tglLahir)) {
            $mhsData['tgl_lahir'] = $tglLahir;
        }
        if (!empty($jurusanId)) {
            $mhsData['jurusan_id'] = $jurusanId;
        }
        if (!empty($prodiId)) {
            $mhsData['prodi_id'] = $prodiId;
        }
        if (!empty($tahunId)) {
            $mhsData['tahun_id'] = $tahunId;
        }
        if (!empty($nisn)) {
            $mhsData['nisn'] = $nisn;
        }
        if (!empty($namaSekolah)) {
            $mhsData['nama_sekolah'] = $namaSekolah;
        }
        if (!empty($tipeSekolah)) {
            $mhsData['tipe_sekolah'] = $tipeSekolah;
        }
        if (!empty($jurusanAsal)) {
            $mhsData['jurusan_asal'] = $jurusanAsal;
        }
        if (!empty($tahunLulus)) {
            $mhsData['tahun_lulus'] = $tahunLulus;
        }
        if (!empty($noHp)) {
            $mhsData['no_hp'] = $noHp;
        }

        // Upload foto
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() <= 512000 && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $namaBaru = $file->getRandomName();
                $file->move('uploads/mahasiswa/', $namaBaru);
                $mhsData['foto'] = $namaBaru;

                // Hapus foto lama jika ada
                $mhsModel = new CmshBaruModel();
                $mahasiswa = $mhsModel->where('users_id', $usersId)->first();
                if (!empty($mahasiswa['foto']) && file_exists('uploads/mahasiswa/' . $mahasiswa['foto'])) {
                    @unlink('uploads/mahasiswa/' . $mahasiswa['foto']);
                }
            } else {
                session()->setFlashdata('errors', ['File foto tidak valid atau melebihi 500KB.']);
                return redirect()->back()->withInput();
            }
        }

        // Update data ke tabel users
        if (!empty($userData)) {
            $this->userModel->update($usersId, $userData);
        }

        // Update data ke tabel mahasiswa
        if (!empty($mhsData)) {
            $mhsModel = new CmshBaruModel();
            $mahasiswa = $mhsModel->where('users_id', $usersId)->first();
            if ($mahasiswa) {
                $mhsModel->update($mahasiswa['id'], $mhsData);
            }
        }

        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('/mahasiswa/profile');
    }

    // SOLUSI PALING SIMPLE: Ubah method exportNametag() yang sudah ada
public function exportNametag()
{
    $usersId = session()->get('data')['id'];
    $mhsModel = new CmshBaruModel();
    $mahasiswa = $mhsModel->where('users_id', $usersId)->first();

    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    // Pastikan kode_peserta ada
    if (empty($mahasiswa['kode_peserta'])) {
        return redirect()->back()->with('error', 'Kode peserta tidak ditemukan.');
    }

    // TAMBAHAN: Validasi kelengkapan profil
    $requiredFields = [
        'nama' => 'Nama',
        'tgl_lahir' => 'Tanggal Lahir',
        'nisn' => 'NISN',
        'nama_sekolah' => 'Nama Sekolah',
        'tipe_sekolah' => 'Tipe Sekolah',
        'jurusan_asal' => 'Keahlian/Jurusan',
        'tahun_lulus' => 'Tahun Lulus',
        'email' => 'Email',
        'no_hp' => 'No HP'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field => $label) {
        if (empty($mahasiswa[$field])) {
            $missingFields[] = $label;
        }
    }

    // Jika ada field yang kosong, redirect dengan pesan error
    if (!empty($missingFields)) {
        $message = 'Profil Anda belum lengkap. Mohon lengkapi data berikut: ' . implode(', ', $missingFields);
        return redirect()->back()->with('error', $message);
    }

    try {
        // Generate QR Code dengan konfigurasi yang lebih baik
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_M,
            'scale' => 8,
            'imageBase64' => false,
            'cachefile' => null,
            'quietzoneSize' => 2,
            'bgColor' => [255, 255, 255],
            'imageTransparent' => false,
        ]);

        $qrCode = new QRCode($options);
        $qrImageData = $qrCode->render($mahasiswa['kode_peserta']);
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImageData);

        // Prepare data untuk template
        $logoPath = FCPATH . 'template/assets/img/logo/polinela.png';
        $fotoPath = FCPATH . 'uploads/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.png');

        $logoBase64 = '';
        $fotoBase64 = '';

        if (file_exists($logoPath)) {
            $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        if (file_exists($fotoPath)) {
            $fotoBase64 = 'data:' . mime_content_type($fotoPath) . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            $defaultFotoPath = FCPATH . 'uploads/mahasiswa/default.png';
            if (file_exists($defaultFotoPath)) {
                $fotoBase64 = 'data:' . mime_content_type($defaultFotoPath) . ';base64,' . base64_encode(file_get_contents($defaultFotoPath));
            }
        }

        // Generate HTML untuk PDF
        $html = view('konten/mahasiswa/profil/nametag_pdf', [
            'mahasiswa' => $mahasiswa,
            'qrBase64' => $qrBase64,
            'logoBase64' => $logoBase64,
            'fotoBase64' => $fotoBase64
        ]);

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', false);
        $options->set('isPhpEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 210, 297], 'portrait');
        $dompdf->render();

        $filename = 'nametag_' . $mahasiswa['kode_peserta'] . '.pdf';

        // SOLUSI SIMPLE: Selalu gunakan attachment untuk mobile
        // Deteksi mobile dengan cara sederhana
        $userAgentString = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgentString);
        
        // Untuk mobile: force download, untuk desktop: bisa preview
        $disposition = $isMobile ? 'attachment' : 'inline';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', $disposition . '; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'no-cache, must-revalidate')
            ->setHeader('Expires', '0')
            ->setBody($dompdf->output());

    } catch (\Exception $e) {
        log_message('error', 'Error generating nametag: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat nametag. Silakan coba lagi.');
    }
}

// SOLUSI ALTERNATIF: Method khusus untuk download (tidak ada preview sama sekali)
public function downloadNametag()
{
    $usersId = session()->get('data')['id'];
    $mhsModel = new CmshBaruModel();
    $mahasiswa = $mhsModel->where('users_id', $usersId)->first();

    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    if (empty($mahasiswa['kode_peserta'])) {
        return redirect()->back()->with('error', 'Kode peserta tidak ditemukan.');
    }

    try {
        // ... (same code as above for QR generation and PDF creation) ...
        
        // Generate QR Code
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_M,
            'scale' => 8,
            'imageBase64' => false,
            'cachefile' => null,
            'quietzoneSize' => 2,
            'bgColor' => [255, 255, 255],
            'imageTransparent' => false,
        ]);

        $qrCode = new QRCode($options);
        $qrImageData = $qrCode->render($mahasiswa['kode_peserta']);
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImageData);

        // Prepare images
        $logoPath = FCPATH . 'template/assets/img/logo/polinela.png';
        $fotoPath = FCPATH . 'uploads/mahasiswa/' . ($mahasiswa['foto'] ?? 'default.png');

        $logoBase64 = '';
        $fotoBase64 = '';

        if (file_exists($logoPath)) {
            $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        if (file_exists($fotoPath)) {
            $fotoBase64 = 'data:' . mime_content_type($fotoPath) . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            $defaultFotoPath = FCPATH . 'uploads/mahasiswa/default.png';
            if (file_exists($defaultFotoPath)) {
                $fotoBase64 = 'data:' . mime_content_type($defaultFotoPath) . ';base64,' . base64_encode(file_get_contents($defaultFotoPath));
            }
        }

        $html = view('konten/mahasiswa/profil/nametag_pdf', [
            'mahasiswa' => $mahasiswa,
            'qrBase64' => $qrBase64,
            'logoBase64' => $logoBase64,
            'fotoBase64' => $fotoBase64
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', false);
        $options->set('isPhpEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 210, 297], 'portrait');
        $dompdf->render();

        $filename = 'nametag_' . $mahasiswa['kode_peserta'] . '.pdf';

        // SELALU DOWNLOAD - tidak ada preview
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Content-Length', strlen($dompdf->output()))
            ->setHeader('Cache-Control', 'private, max-age=0, must-revalidate')
            ->setHeader('Pragma', 'public')
            ->setBody($dompdf->output());

    } catch (\Exception $e) {
        log_message('error', 'Error downloading nametag: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mendownload nametag.');
    }
}
}
