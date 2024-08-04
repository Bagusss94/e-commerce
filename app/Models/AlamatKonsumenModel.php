<?php

namespace App\Models;

use CodeIgniter\Model;

class AlamatKonsumenModel extends Model
{
    protected $table            = 'alamat_konsumen';
    protected $primaryKey       = 'id_alamat';
    protected $allowedFields    = ['id_user', 'alamat', 'distrik', 'provinsi'];

    public function alamatKonsumen($id_user)
    {
        return $this->table($this->table)->where('id_user', $id_user)->get();
    }
}
