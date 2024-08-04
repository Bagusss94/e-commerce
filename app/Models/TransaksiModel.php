<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_transaksi', 'id_user', 'tanggal', 'status_pembayaran', 'status_transaksi', 'alamat', 'telp', 'noresi', 'distrik', 'provinsi', 'kodepos', 'ekspedisi', 'paket', 'ongkir', 'total_berat', 'estimasi', 'tipe_pembayaran', 'link_pdf', 'total_bayar', 'snapToken',
    ];

    public function IDTransaksi()
    {
        $tglsekarang = date('Y-m-d H:i:s');
        $data = $this->query("SELECT max(id_transaksi) as id_transaksi FROM $this->table WHERE DATE_FORMAT(tanggal, '%Y-%m-%d') = '$tglsekarang'");
        $cek = $data;
        if ($cek->getNumRows() == 0) {
            $id_transaksi = date('dmy', strtotime($tglsekarang)) . '0001';
        } else {
            $hasil = $data->getRowArray();
            $data = $hasil['id_transaksi'];
            $lastnourut = substr($data, -4);
            $nextnourut = intval($lastnourut) + 1;
            $id_transaksi = date('dmy', strtotime($tglsekarang)) . sprintf('%04s', $nextnourut);
        }
        return $id_transaksi;
    }

    public function cekTransaksi($id_user)
    {
        return $this->table($this->table)->where('id_user', $id_user)->orderBy('tanggal', 'DESC')->get();
    }

    public function cekTransaksiUser($id_user, $id_transaksi)
    {
        return $this->table($this->table)->select($this->table . ".*, u.nama_lengkap, u.email")
            ->join("users as u", $this->table . ".id_user=u.id_user")
            ->where($this->table . '.id_user', $id_user)->where('id_transaksi', $id_transaksi)->get();
    }

    public function getPembayaranBerhasil($id_transaksi = null)
    {
        if ($id_transaksi == null) {
            return $this->table($this->table)->where('status_pembayaran', "settlement")
                ->orderBy('tanggal', 'DESC')
                ->get();
        }

        return $this->table($this->table)
            ->join('users as u', $this->table . ".id_user=u.id_user")
            ->where('status_pembayaran', "settlement")
            ->where('id_transaksi', $id_transaksi)->get();
    }

    public function getCariTransaksi($tgl_awal, $tgl_akhir, $status)
    {
        if ($tgl_awal && $tgl_akhir) {
            return $this->table($this->table)
                ->select($this->table . ".*, u.nama_lengkap")
                ->join("users as u", $this->table . ".id_user=u.id_user")
                ->where('status_pembayaran', "settlement")
                ->where("DATE_FORMAT(tanggal, '%Y-%m-%d') >=", $tgl_awal)
                ->where("DATE_FORMAT(tanggal, '%Y-%m-%d') <=", $tgl_akhir)
                ->like('status_transaksi', $status)
                ->orderBy('tanggal', 'DESC')
                ->get();
        }
        return $this->table($this->table)
            ->select($this->table . ".*, u.nama_lengkap")
            ->join("users as u", $this->table . ".id_user=u.id_user")
            ->where('status_pembayaran', "settlement")
            ->like('status_transaksi', $status)
            ->orderBy('tanggal', 'DESC')
            ->get();
    }
}
