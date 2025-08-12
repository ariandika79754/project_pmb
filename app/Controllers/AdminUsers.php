<?php

namespace App\Controllers;

use App\Models\Admin\UsersModel;

class AdminUsers extends BaseController
{
    protected $userModel;
    protected $db;
    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {

        $data = [
            'users' =>  $this->userModel->getAllPelanggan()
        ];
        echo view('konten/admin/users/index.php', $data);
    }
    // Edit Pelanggan

    // Delete

    public function deleteUsers($id)
    {
        $this->userModel->delete(decrypt_url($id));
        session()->setFlashdata('error', 'Berhasil menghapus data.'); // tambahkan ini
        return redirect()->to('/admin/pelanggan');
    }
}
