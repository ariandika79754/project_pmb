<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_prodi', 'nama_prodi', 'jenjang_prodi', 'jurusan_id', 'total_kelas'];

    public function getAllProdi()
    {
        return $this->select('prodi.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id = prodi.jurusan_id', 'left') // ubah jadi LEFT JOIN
            ->findAll();
    }

    public function simpanData($data)
    {
        return $this->insert($data);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }
}
