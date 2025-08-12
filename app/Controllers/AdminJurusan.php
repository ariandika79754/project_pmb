<?php

namespace App\Controllers;

use App\Models\Admin\JurusanModel;

class AdminJurusan extends BaseController
{
    public function index()
    {
        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->findAll();
        return view('konten/admin/jurusan/index', $data);
    }

    public function add()
    {
        return view('konten/admin/jurusan/add');
    }

    public function save()
    {
        $jurusanModel = new JurusanModel();

        $jurusanModel->save([
            'kode_jurusan' => $this->request->getPost('kode_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('/admin/kode/jurusan');
    }

    public function edit($id)
    {
        $jurusanModel = new JurusanModel();
        $data['jurusan'] = $jurusanModel->find($id);
        return view('konten/admin/jurusan/edit', $data);
    }

    public function update($id)
    {
        $jurusanModel = new JurusanModel();

        $jurusanModel->update($id, [
            'kode_jurusan' => $this->request->getPost('kode_jurusan'),
            'nama_jurusan' => $this->request->getPost('nama_jurusan')
        ]);

        return redirect()->to('/admin/kode/jurusan');
    }

    public function delete($id)
    {
        $jurusanModel = new JurusanModel();
        $jurusanModel->delete($id);
        return redirect()->to('/admin/jurusan');
    }
}
