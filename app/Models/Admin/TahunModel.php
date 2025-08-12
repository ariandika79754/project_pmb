<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class TahunModel extends Model
{
    protected $table = 'tahun';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_tahun'];

    public function simpanData($data)
    {
        return $this->insert($data);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }
}
