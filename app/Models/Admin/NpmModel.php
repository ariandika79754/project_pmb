<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class NpmModel extends Model
{
    protected $table = 'npm';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mahasiswa_id', 'npm'];
    protected $useTimestamps = true;
    
    public function getAllWithMahasiswa()
    {
        return $this->select('npm.*, mahasiswa.nama')
            ->join('mahasiswa', 'mahasiswa.id = npm.mahasiswa_id')
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
