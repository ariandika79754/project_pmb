<?php

namespace App\Controllers;

use App\Models\Admin\CmshBaruModel;
use App\Models\Admin\UsersModel;

class Pendaftar extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

   public function save()
{
    $data = $this->request->getPost();

    // Validasi email cocok
    if ($data['email'] !== $data['konfirmasi_email']) {
        return redirect()->back()->with('error', 'Email dan konfirmasi tidak cocok.');
    }

    $mhsModel = new CmshBaruModel();

    // Simpan ke tabel mahasiswa
    $mhsModel->insert([
        'nisn'         => $data['nisn'],
        'nama'         => $data['nama'],
        'tgl_lahir'    => $data['tgl_lahir'],
        'nama_sekolah' => $data['nama_sekolah'],
        'tipe_sekolah' => $data['tipe_sekolah'],
        'jurusan_asal' => $data['jurusan'],
        'tahun_lulus'  => $data['tahun_lulus'],
        'email'        => $data['email'],
        'no_hp'        => $data['no_hp'],
        'created_at'   => date('Y-m-d H:i:s')
    ]);

    // Buat password dari tanggal lahir (format: ddmmyyyy)
    $tgl = date('dmY', strtotime($data['tgl_lahir']));
    $hashedPassword = hash('sha256', sha1($tgl));

    // Simpan ke tabel users
    $usersModel = new \App\Models\Admin\UsersModel();
    $usersModel->insert([
    'username'   => $data['email'],
    'password'   => $hashedPassword,
    'nama'       => $data['nama'], // tambahkan ini
    'role_id'    => 2, // Role 2 = Mahasiswa
    'created_at' => date('Y-m-d H:i:s')
]);


    // Tampilkan view konfirmasi ke user
    return view('auth/konfirmasi_register', [
        'email'    => $data['email'],
        'password' => $tgl // tampilkan password sebelum di-hash
    ]);
}

}
