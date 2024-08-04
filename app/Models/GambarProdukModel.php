<?php

namespace App\Models;

use CodeIgniter\Model;

class GambarProdukModel extends Model
{
    protected $table            = 'gambar_produk';
    protected $primaryKey       = 'id_gambar';
    protected $allowedFields    = ['id_produk', 'gambar', 'status'];

    public function cariGambarProduk($id_produk)
    {
        return $this->table($this->table)->where('id_produk', $id_produk)->get();
    }

    public function cariGambarBukanCover($id_produk)
    {
        return $this->table($this->table)->where('id_produk', $id_produk)->where('status', 0)->get();
    }

    public function cariGambarCover($id_produk)
    {
        return $this->table($this->table)->where('id_produk', $id_produk)->where('status', 1)->get();
    }
}
