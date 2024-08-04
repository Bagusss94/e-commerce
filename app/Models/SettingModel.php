<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'setting';
    protected $primaryKey       = 'id_setting';
    protected $allowedFields    = ['nama_web', 'logo_web', 'gambar_toko', 'alamat', 'provinsi', 'distrik', 'kontak', 'tentang_kami', 'deskripsi'];

    public function getSetting()
    {
        return $this->table($this->table)->first();
    }
}
