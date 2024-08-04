<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailTransaksiModel;
use App\Models\SettingModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    protected $TransaksiModel;
    protected $DetailTransaksiModel;

    public function __construct()
    {
        $this->TransaksiModel = new TransaksiModel();
        $this->DetailTransaksiModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $tglAwal = $this->request->getGet('tanggal_mulai') ?? date("Y-m-d");
        $tglAkhiri = $this->request->getGet('tanggal_selesai') ?? date("Y-m-d");
        $status = $this->request->getGet('status_transaksi') ?? "pending";
        $transaksi = $this->TransaksiModel->getCariTransaksi($tglAwal, $tglAkhiri, $status)->getResultArray();

        return view('admin/transaksi/v_transaksi', [
            'title' => 'Daftar Transaksi',
            'subtitle' => null,
            'transaksi' => $transaksi,
            'tanggal_awal' => $tglAwal,
            'tanggal_akhir' => $tglAkhiri,
            'status' => $status,
        ]);
    }

    public function detail($id_transaksi)
    {
        $cekTransaksi = $this->TransaksiModel->getPembayaranBerhasil($id_transaksi)->getRowArray();
        if (!$cekTransaksi) {
            session()->setFlashdata('msg', 'error#Transaksi ' . $id_transaksi . ' tidak ditemukan!');
            return redirect()->to(base_url('transaksi'));
        }

        $detail = $this->DetailTransaksiModel->detailTransaksi($id_transaksi)->getResultArray();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = getenv("MIDTRANS_SERVER_KEY");
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // update pembayaran pada midtrans
        $status = \Midtrans\Transaction::status($id_transaksi);
        // dd($status);
        if (strtolower($status->transaction_status) == "cancel" || strtolower($status->transaction_status) == "failure" || strtolower($status->transaction_status) == "expire") {
            $status_transaksi = "gagal";
        } else {
            $status_transaksi = $cekTransaksi['status_transaksi'];
        }

        $this->TransaksiModel->update($id_transaksi, [
            'status_pembayaran' => $status->transaction_status,
            'status_transaksi' => $status_transaksi,
        ]);

        return view('admin/transaksi/v_detail_transaksi', [
            'title' => 'Daftar Transaksi',
            'subtitle' => "Detail Transaksi",
            'transaksi' => $cekTransaksi,
            'detail' => $detail,
            'status' => $status,
        ]);
    }

    public function modalpembayaran()
    {
        if (!$this->request->isAJAX()) {
            exit("Maaf tidak dapat diproses");
        }

        $id_transaksi = $this->request->getPost('id_transaksi');
        $cekTransaksi = $this->TransaksiModel->getPembayaranBerhasil($id_transaksi)->getRowArray();
        if (!$cekTransaksi) {
            exit(json_encode([
                'error' => "Transaksi tidak ditemukan!"
            ]));
        }
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = getenv("MIDTRANS_SERVER_KEY");
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $status = \Midtrans\Transaction::status($id_transaksi);

        if (strtolower($status->transaction_status) == "cancel" || strtolower($status->transaction_status) == "failure" || strtolower($status->transaction_status) == "expire") {
            $status_transaksi = "gagal";
        } else {
            $status_transaksi = $cekTransaksi['status_transaksi'];
        }

        $this->TransaksiModel->update($id_transaksi, [
            'status_pembayaran' => $status->transaction_status,
            'status_transaksi' => $status_transaksi,
        ]);

        $json = [
            'data' => view('admin/transaksi/modalpembayaran', [
                'transaksi' => $cekTransaksi,
                'status' => $status,
            ])
        ];

        echo json_encode($json);
    }

    public function pembayaran()
    {
        if (!$this->request->isAJAX()) {
            exit("Maaf tidak dapat diproses");
        }

        $id_transaksi = $this->request->getPost('id_transaksi');

        $cekTransaksi = $this->TransaksiModel->getPembayaranBerhasil($id_transaksi)->getRowArray();
        if (!$cekTransaksi) {
            exit(json_encode([
                'error' => "Transaksi tidak ditemukan!"
            ]));
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = getenv("MIDTRANS_SERVER_KEY");
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // update pembayaran pada midtrans
        $status = \Midtrans\Transaction::status($id_transaksi)->transaction_status;
        if (strtolower($status) == "cancel" || strtolower($status) == "failure" || strtolower($status) == "expire") {
            $status_transaksi = "gagal";
        } else {
            // $status_transaksi = $cekTransaksi['status_transaksi'];
            $status_transaksi =  $this->request->getPost('status_transaksi') ?? $cekTransaksi['status_transaksi'];
        }

        $this->TransaksiModel->update($id_transaksi, [
            'status_pembayaran' => $status,
            'status_transaksi' => $status_transaksi,
        ]);

        // $status_trans = $this->request->getPost('status_transaksi') ?? $status_transaksi;
        // if ($status_transaksi == 'gagal') {
        //     // refund money
        //     // $params = array(
        //     //     'refund_key' => 'order1-ref1',
        //     //     'amount' => 10000,
        //     //     'reason' => 'Item out of stock'
        //     // );
        //     // $direct_refund = \Midtrans\Transaction::refundDirect($orderId, $params);
        //     // var_dump($direct_refund);
        // }

        $noresi = $this->request->getPost('noresi');
        $this->TransaksiModel->update($id_transaksi, [
            'status_transaksi' => $status_transaksi,
            'noresi' => $noresi,
            'ekspedisi' => $this->request->getPost('ekspedisi') ?  strtolower($this->request->getPost('ekspedisi') ?? "") : null,
        ]);

        $json = [
            'success' => "Status Transaksi " . $id_transaksi . " berhasil diubah"
        ];
        echo json_encode($json);
    }

    public function cetak_invoice($id_transaksi, $id_user)
    {
        $transaksi = $this->TransaksiModel->cekTransaksiUser($id_user, $id_transaksi)->getRowArray();
        if (!$transaksi) {
            session()->setFlashdata('msg', 'error#Transaksi tidak ditemukan!');
            return redirect()->to(base_url('history'));
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = getenv("MIDTRANS_SERVER_KEY");
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // // update pembayaran pada midtrans
        // $status = \Midtrans\Transaction::status($id_transaksi)->transaction_status;
        $status = \Midtrans\Transaction::status($id_transaksi);
        // dd($status);

        $settingModel = new SettingModel();

        return view("konsumen/v_cetak_history", [
            'title' => "Cetak Invoice - " . $id_transaksi,
            'transaksi' => $transaksi,
            'status' => $status,
            'detail' => $this->DetailTransaksiModel->detailTransaksi($id_transaksi)->getResultArray(),
            'setting' => $settingModel->first()
        ]);
    }

    public function cetak_laporan()
    {
        $tgl_awal = !empty($this->request->getGet('tgl_awal')) ? $this->request->getGet('tgl_awal') : "";
        $tgl_akhir = !empty($this->request->getGet('tgl_akhir')) ? $this->request->getGet('tgl_akhir') : "";
        $status = !empty($this->request->getGet('status')) ?  $this->request->getGet('status') : "";
        $transaksi = $this->TransaksiModel->getCariTransaksi($tgl_awal, $tgl_akhir, $status)->getResultArray();

        // if (!$transaksi) {
        //     session()->setFlashdata('msg', 'error#Transaksi kosong!');
        //     return redirect()->to(base_url('transaksi'));
        // }

        return view("admin/transaksi/v_cetak_transaksi", [
            'title' => "Cetak Laporan",
            'transaksi' => $transaksi,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'status' => $status,
        ]);
    }
}
