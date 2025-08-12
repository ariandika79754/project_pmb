<?php
namespace App\Controllers;

use App\Models\Admin\CmshBaruModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $mahasiswaModel = new CmshBaruModel();
        $jumlahMahasiswa = $mahasiswaModel->countAll(); // menghitung total data

        return view('konten/admin/dashboard/index', [
            'jumlahMahasiswa' => $jumlahMahasiswa
        ]);
    }
}