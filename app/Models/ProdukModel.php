<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'nama_produk', 'harga_produk', 'deskripsi_produk', 'stok', 'berat', 'id_satuan', 'id_kategori',
    ];

    public function getTotalRecord($cari = null)
    {
        if ($cari !== null) {
            return $this->table($this->table)
                ->like('nama_produk', $cari)
                ->orlike('deskripsi_produk', $cari)
                ->get()->getNumRows();
        }

        return $this->table($this->table)->get()->getNumRows();
    }

    public function getProdukPagination($limit, $offset, $cari = null)
    {
        if ($cari !== null) {
            return $this->table($this->table)
                ->join('satuan', 'satuan.id_satuan=produk.id_satuan', 'left')
                ->join('kategori', 'kategori.id_kategori=produk.id_kategori', 'left')
                ->like('nama_produk', $cari)
                ->orlike('kategori', $cari)
                ->limit($limit, $offset)
                ->orderBy('id_produk', 'DESC')
                ->get();
        }
        return $this->table($this->table)->limit($limit, $offset)->orderBy('id_produk', 'DESC')->get();
    }

    public function cekProduk($id_produk)
    {
        return $this->table($this->table)
            ->where('id_produk', $id_produk)
            // ->where('stok >', "0")
            ->get();
    }
}
