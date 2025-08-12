<?php

namespace App\Controllers;

use App\Models\Admin\ProdiModel;
use App\Models\Admin\JurusanModel;

class AdminProdi extends BaseController
{
    public function index()
    {
        $model = new ProdiModel();
        $data['prodi'] = $model->getAllProdi();
        return view('konten/admin/prodi/index', $data);
    }


    public function add()
    {
        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->findAll();
        return view('konten/admin/prodi/add', $data);
    }
    public function save()
    {
        $model = new ProdiModel();
        $data = [
            'kode_prodi' => $this->request->getPost('kode_prodi'),
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'total_kelas' => $this->request->getPost('total_kelas'),
        ];
        $model->simpanData($data);
        return redirect()->to('/admin/kode/prodi');
    }



    public function edit($id)
    {
        $prodiModel = new \App\Models\Admin\ProdiModel();
        $jurusanModel = new \App\Models\Admin\JurusanModel();

        $prodi = $prodiModel->find($id);
        $jurusan = $jurusanModel->findAll();

        if (!$prodi) {
            return redirect()->to('/admin/kode/prodi')->with('error', 'Data prodi tidak ditemukan.');
        }

        return view('konten/admin/prodi/edit', [
            'prodi' => $prodi,
            'jurusan' => $jurusan
        ]);
    }

    public function update($id)
    {
        $prodiModel = new \App\Models\Admin\ProdiModel();

        $data = [
            'kode_prodi' => $this->request->getPost('kode_prodi'),
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'total_kelas' => $this->request->getPost('total_kelas'),
        ];

        $prodiModel->update($id, $data);

        return redirect()->to('/admin/kode/prodi')->with('success', 'Data prodi berhasil diupdate.');
    }


    public function delete($id)
    {
        $model = new ProdiModel();
        $model->delete($id);
        return redirect()->to('/admin/kode/prodi');
    }
}
