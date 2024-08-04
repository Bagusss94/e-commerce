<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'id_det_trans';
    protected $allowedFields    = [
        'id_transaksi', 'id_produk', 'harga', 'jumlah', 'subtotal'
    ];

    public function detailTransaksi($id_transaksi)
    {
        // return $this->table($this->table)->select($this->table . ".*, p.*, gambar_produk.gambar")
        //     ->join('produk as p', $this->table . ".id_produk=p.id_produk")
        //     ->join(
        //         'gambar_produk',
        //         new RawSql("p.id_produk=(
        //             SELECT id_produk FROM gambar_produk WHERE NOT gambar_produk.status=0 LIMIT 1
        //         )"),
        //         "LEFT"
        //     )
        //     ->where($this->table . ".id_transaksi", $id_transaksi)
        //     ->get();
        return
            $this->query(
                "SELECT $this->table.*, p.*, g.gambar, s.satuan FROM $this->table INNER JOIN produk as p ON $this->table.id_produk = p.id_produk LEFT JOIN satuan as s ON s.id_satuan=p.id_satuan LEFT JOIN (
            SELECT * FROM gambar_produk WHERE NOT status=0
        ) as g ON p.id_produk = g.id_produk WHERE $this->table.id_transaksi=$id_transaksi"
            );
    }
}
