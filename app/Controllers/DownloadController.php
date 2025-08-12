<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DownloadController extends Controller
{
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom (dengan tambahan kolom prodi_diterima di akhir)
        $headers = [
            'NIK',
            'NISN',
            'REGIST',
            'KODE PESERTA',
            'NAMA PESERTA',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'alamat',
            'telepon',
            'email',
            'prodi_diterima',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'asal_sekolah',
            'jurusan',
            'tahun_lulus',
            'keterangan'
        ];

        // Isi header ke baris pertama
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Contoh baris data (baris ke-2)
        $sheet->fromArray([
            '1234567890123456',
            '1234567890',
            'REG001',
            'PST001',
            'John Doe',
            'Jakarta',
            '01/01/2000',
            'L',
            'Islam',
            'Jl. Contoh No.1',
            '081234567890',
            'john@example.com',
            'Manajemen Informatika',
            'Bapak Doe',
            'Ibu Doe',
            'Pegawai',
            'IRT',
            'SMA Negeri 1',
            'IPA',
            '2025',
            'Aktif',
        ], null, 'A2');

        $filename = 'Template_Data_Mahasiswa.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Output file
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($this->writeToOutput($writer));
    }

    private function writeToOutput($writer)
    {
        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
    }
}
