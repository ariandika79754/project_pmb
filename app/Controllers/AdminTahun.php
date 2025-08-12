<?php

namespace App\Controllers;

use App\Models\Admin\TahunModel;

class AdminTahun extends BaseController
{
    public function index()
    {
        $model = new TahunModel();
        $data['tahun'] = $model->findAll();
        return view('konten/admin/tahun/index', $data);
    }

    public function add()
    {
        return view('konten/admin/tahun/add');
    }

    public function save()
    {
        $model = new TahunModel();
        $data = [
            'kode_tahun' => $this->request->getPost('kode_tahun'),
        ];
        $model->simpanData($data);
        return redirect()->to('/admin/kode/tahun');
    }

    public function edit($id)
    {
        $model = new TahunModel();
        $data['tahun'] = $model->find($id);
        return view('konten/admin/tahun/edit', $data);
    }

    public function update($id)
    {
        $model = new TahunModel();
        $data = [
            'kode_tahun' => $this->request->getPost('kode_tahun'),
        ];
        $model->updateData($id, $data);
        return redirect()->to('/admin/kode/tahun');
    }

    public function delete($id)
    {
        $model = new TahunModel();
        $model->delete($id);
        return redirect()->to('/admin/kode/tahun');
    }
}
