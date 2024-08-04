<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table            = 'keranjang';
    protected $primaryKey       = 'id_keranjang';
    protected $allowedFields    = [
        'id_produk', 'id_user', 'jumlah'
    ];

    public function getKeranjangGagalDiproses($id_user)
    {
        return $this->query("SELECT $this->table.*, p.*, g.gambar, ($this->table.jumlah*p.harga_produk) as subtotal FROM $this->table INNER JOIN produk as p ON $this->table.id_produk=p.id_produk LEFT JOIN (
            SELECT * FROM gambar_produk WHERE NOT status=0
        ) as g ON $this->table.id_produk = g.id_produk WHERE $this->table.id_user=$id_user AND p.stok < $this->table.jumlah");
    }

    public function getKeranjangUser($id_user)
    {
        // menampilkan keranjang milik user, yang dimana produk masih tersedia
        return $this->query("SELECT $this->table.*, p.*, g.gambar, ($this->table.jumlah*p.harga_produk) as subtotal FROM $this->table INNER JOIN produk as p ON $this->table.id_produk=p.id_produk LEFT JOIN (
            SELECT * FROM gambar_produk WHERE status=1
        ) as g ON $this->table.id_produk = g.id_produk WHERE $this->table.id_user=$id_user AND p.stok >= $this->table.jumlah");
    }

    // public function getCheckoutKeranjang($id_user)
    // {
    //     return $this->query("SELECT $this->table.*, p.*, g.gambar, ($this->table.jumlah*p.harga_produk) as subtotal FROM $this->table INNER JOIN produk as p ON $this->table.id_produk=p.id_produk LEFT JOIN (
    //         SELECT * FROM gambar_produk WHERE NOT status=0
    //     ) as g ON $this->table.id_produk = g.id_produk WHERE $this->table.id_user=$id_user AND p.stok > 0");
    // }

    public function getProdukKeranjang($id_user, $id_produk)
    {
        return $this->table($this->table)->where('id_user', $id_user)->where('id_produk', $id_produk)->get();
    }

    public function getDetailKeranjangUser($id_user, $id_keranjang)
    {
        return $this->table($this->table)->select($this->table . ".* ,produk.*")
            ->join('produk', $this->table . ".id_produk=produk.id_produk")
            ->getWhere([
                'id_user' => $id_user,
                'id_keranjang' => $id_keranjang,
            ]);
    }
}
