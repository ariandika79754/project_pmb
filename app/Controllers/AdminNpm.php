<?php

namespace App\Controllers;

use App\Models\Admin\NpmModel;

class AdminNpm extends BaseController
{
    public function index()
{
    $model = new \App\Models\Admin\NpmModel();
    $data['mahasiswa'] = $model->getAllWithMahasiswa();

    return view('konten/admin/mahasiswa/index', $data);
}


    public function add()
    {
        return view('konten/admin/mahasiswa/add');
    }

    public function save()
    {
        $model = new NpmModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'npm'  => $this->request->getPost('npm'),
        ];
        $model->simpanData($data);
        return redirect()->to('/admin/kode/mahasiswa');
    }

    public function edit($id)
    {
        $model = new NpmModel();
        $data['mahasiswa'] = $model->find($id);
        return view('konten/admin/mahasiswa/edit', $data);
    }

    public function update($id)
    {
        $model = new NpmModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'npm'  => $this->request->getPost('npm'),
        ];
        $model->updateData($id, $data);
        return redirect()->to('/admin/kode/mahasiswa');
    }

    public function delete($id)
    {
        $model = new NpmModel();
        $model->delete($id);
        return redirect()->to('/admin/kode/mahasiswa');
    }
}
