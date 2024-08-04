<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailTransaksiModel;
use App\Models\KeranjangModel;
use App\Models\ProdukModel;
use App\Models\SettingModel;
use App\Models\TransaksiModel;
use App\Models\UsersModel;

class Transaksiuser extends BaseController
{
    protected $ProdukModel;
    protected $UsersModel;
    protected $KeranjangModel;
    protected $TransaksiModel;
    protected $DetailTransaksiModel;
    protected $userId;

    public function __construct()
    {
        $this->ProdukModel = new ProdukModel();
        $this->KeranjangModel = new KeranjangModel();
        $this->UsersModel = new UsersModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->DetailTransaksiModel = new DetailTransaksiModel();
        $this->userId = session()->get('LoginUser')['id_user'];
    }

    public function tambah_keranjang($id_produk)
    {
        // cek user
        $cekUser = $this->UsersModel->cekKonsumen($this->userId)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Anda tidak memiliki hak akses untuk melakukan ini!');
            return;
        }

        // cek produk
        $produk = $this->ProdukModel->cekProduk($id_produk)->getRowArray();
        if (!$produk) {
            session()->setFlashdata('msg', 'error#Produk tidak ditemukan!');
            return redirect()->to(base_url('/'));
        }

        // cek jika ada inputan post jumlah
        if (!empty($this->request->getPost('jumlah')) && $this->request->getPost('jumlah') != "" && $this->request->getPost('jumlah') != 0) {
            $jumlah = $this->request->getPost('jumlah');
        } else {
            $jumlah = 1;
        }

        // cek dikeranjang apakah ada produk tersebut sudah ada
        $cekKeranjang = $this->KeranjangModel->getProdukKeranjang($this->userId, $id_produk)->getRowArray();
        // jika sudah ada maka tambahkan ke keranjang
        if ($cekKeranjang) {
            // jika produk yang diinputkan lebih dari stok
            if ($produk['stok'] < ((int) $jumlah + (int) $cekKeranjang['jumlah'])) {
                session()->setFlashdata('msg', 'error#Jumlah ' . $produk['nama_produk'] . ' di keranjang sudah melebihi stok!');
                return redirect()->to(base_url('detail-produk/' . $id_produk));
            }

            $this->KeranjangModel->update($cekKeranjang['id_keranjang'], [
                'id_produk' => $id_produk,
                'id_user' => $this->userId,
                'jumlah' => $cekKeranjang['jumlah'] + $jumlah,
            ]);
        } else {
            // jika produk yang diinputkan lebih dari stok
            if ($produk['stok'] < $jumlah) {
                session()->setFlashdata('msg', 'error#Jumlah ' . $produk['nama_produk'] . ' di keranjang sudah melebihi stok!');
                return redirect()->to(base_url('/'));
            }

            $this->KeranjangModel->insert([
                'id_produk' => $id_produk,
                'id_user' => $this->userId,
                'jumlah' => $jumlah,
            ]);
        }

        session()->setFlashdata('msg', 'success#Produk ' . $produk['nama_produk'] . ' ditambahkan ke keranjang');
        return redirect()->to(base_url('keranjang'));
    }

    public function keranjang()
    {
        $keranjang = $this->KeranjangModel->getKeranjangUser($this->userId)->getResultArray();
        // dd($keranjang);
        // if (!$keranjang) {
        //     session()->setFlashdata('msg', 'error#Keranjang kosong!');
        //     return redirect()->to(base_url('/'));
        // }
        $jmlItems = $this->KeranjangModel->getKeranjangUser($this->userId)->getNumRows();
        $gagalDiproses = $this->KeranjangModel->getKeranjangGagalDiproses($this->userId)->getResultArray();

        return view('konsumen/v_keranjang', [
            'title' => "Keranjang",
            'jmlItems' => $jmlItems,
            'keranjang' => $keranjang,
            'gagalDiproses' => $gagalDiproses,
        ]);
    }

    public function ubahJumlahItem()
    {
        if ($this->request->isAJAX()) {
            $id_keranjang = $this->request->getPost('id_keranjang');
            $jumlah = $this->request->getPost('jumlah');
            $cekKeranjang = $this->KeranjangModel->getDetailKeranjangUser($this->userId, $id_keranjang)->getRowArray();
            if ($cekKeranjang) {
                if ($cekKeranjang['stok'] >= $jumlah) {
                    $this->KeranjangModel->update($id_keranjang, [
                        'jumlah' => $jumlah,
                    ]);
                    $json = [
                        'success' => 'Jumlah item berhasil diubah'
                    ];
                } else {
                    $json = [
                        'error' => 'Jumlah ' . $cekKeranjang['nama_produk'] . ' di keranjang sudah melebihi stok!'
                    ];
                }
            } else {
                $json = [
                    'error' => 'Item tidak ditemukan di keranjang!'
                ];
            }
            echo json_encode($json);
        } else {
            exit("Maaf tidak dapat diperoses!");
        }
    }

    public function hapusItem($id_keranjang)
    {
        // cek keranjang
        $keranjang = $this->KeranjangModel->getDetailKeranjangUser($this->userId, $id_keranjang)->getRowArray();
        if (!$keranjang) {
            session()->setFlashdata('msg', 'error#Item tidak ditemukan di keranjang!');
            return redirect()->to(base_url('keranjang'));
        }

        $this->KeranjangModel->delete($keranjang['id_keranjang']);
        session()->setFlashdata('msg', 'success#Item berhasil dihapus!');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
        // cek user
        $cekUser = $this->UsersModel->cekKonsumen($this->userId)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Anda tidak memiliki hak akses untuk melakukan ini!');
            return;
        }

        $keranjang = $this->KeranjangModel->getKeranjangUser($this->userId)->getResultArray();
        if (!$keranjang) {
            session()->setFlashdata('msg', 'error#Keranjang kosong!');
            return redirect()->to(base_url('keranjang'));
        }

        $totalBerat = 0;
        $total = 0;
        foreach ($keranjang as $key => $value) {
            $totalBerat += $value['berat'] * $value['jumlah'];
            $total += $value['subtotal'];
        }

        return view('konsumen/v_checkout', [
            'title' => 'Checkout',
            'keranjang' => $keranjang,
            'jmlItem' =>  $this->KeranjangModel->getKeranjangUser($this->userId)->getNumRows(),
            'totalBerat' => $totalBerat,
            'total' => $total,
            'user' => $cekUser,
        ]);
    }

    public function payment()
    {
        // cek request
        if (!$this->request->isAJAX()) {
            exit("Tidak dapat diproses!");
        }

        // cek user
        $cekUser = $this->UsersModel->cekKonsumen($this->userId)->getRowArray();
        if (!$cekUser) {
            exit(json_encode([
                'error' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ]));
        }

        // mengecek ketersediaan produk, dan
        // mengecek apakah detail transaksi dari input checkout itu sama dengan data yang ada di keranjang
        $detail_transaksi = $this->request->getPost('detail_transaksi');
        $jumlah_keranjang_sistem = $this->KeranjangModel->getKeranjangUser($this->userId)->getNumRows();
        if (count($detail_transaksi) !== $jumlah_keranjang_sistem) {
            exit(json_encode([
                'error' => 'Checkout gagal ada produk yang sudah tidak tersedia!'
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

        // mengambil id transaksi dari model
        $id_transaksi = rand();
        // $id_transaksi = $this->TransaksiModel->IDTransaksi();

        // Items product
        $items = [];
        $total = 0;
        $no = 1;
        foreach ($detail_transaksi as $key => $value) {
            $total += $value['subtotal'];
            $items[] = [
                'id' => $no++,
                'name' => $value['nama_produk'],
                'quantity' => $value['jumlah'],
                'price' => $value['harga_produk'],
            ];
        }
        // untuk ongkir
        $items[] = [
            'id' => $no++,
            'name' => 'Ongkir (' . $this->request->getPost('total_berat') . ' gram)',
            'quantity' => 1,
            'price' => $this->request->getPost('ongkir'),
        ];
        // exit(json_encode($items));

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'   => $cekUser['nama_lengkap'],
            'address'      => $this->request->getPost('alamat'),
            'city'         => $this->request->getPost('distrik'),
            'postal_code'  => $this->request->getPost('kodepos'),
            'phone'        => $this->request->getPost('telp'),
            'country_code' => 'IDN'
        );

        // Populate customer's info
        $customer_details = array(
            'first_name'       => $cekUser['nama_lengkap'],
            'email'            => $cekUser['email'],
            'phone'            => $cekUser['telp'],
            'shipping_address' => $shipping_address
        );

        $params = [
            'transaction_details' => array(
                'order_id' => $id_transaksi,
                'gross_amount' => $this->request->getPost('total_bayar'),
            ),
            'item_details'        => $items,
            'customer_details'    => $customer_details
        ];

        $json = [
            'snapToken' => \Midtrans\Snap::getSnapToken($params),
        ];

        echo json_encode($json);
    }

    public function simpanTransaksi()
    {
        // cek request
        if (!$this->request->isAJAX()) {
            exit("Tidak dapat diproses!");
        }

        // cek user
        $cekUser = $this->UsersModel->cekKonsumen($this->userId)->getRowArray();
        if (!$cekUser) {
            exit(json_encode([
                'error' => 'Anda tidak memiliki akses untuk melakukan ini!'
            ]));
        }

        // mengecek ketersediaan produk, dan
        // mengecek apakah detail transaksi dari input checkout itu sama dengan data yang ada di keranjang
        $detail_transaksi = $this->request->getPost('detail_transaksi');
        $jumlah_keranjang_sistem = $this->KeranjangModel->getKeranjangUser($this->userId)->getNumRows();
        if (count($detail_transaksi) !== $jumlah_keranjang_sistem) {
            exit(json_encode([
                'error' => 'Checkout gagal ada produk yang sudah tidak tersedia!'
            ]));
        }

        // ambil semua request post
        $data = $this->request->getPost();
        $data['status_transaksi'] = "pending";
        $data['id_user'] = $this->userId;

        // $jumlah = intval($detail_transaksi[0]['stok']) - intval($detail_transaksi[0]['jumlah']);
        // exit($jumlah);

        // ambil detail transaksi
        $data_transaksi = [];
        foreach ($detail_transaksi as $key => $value) {
            $data_transaksi[] = [
                'id_transaksi' => $data['id_transaksi'],
                'id_produk' => $value['id_produk'],
                'harga' => $value['harga_produk'],
                'jumlah' => $value['jumlah'],
                'subtotal' => $value['subtotal'],
            ];
            // hapus keranjang
            $this->KeranjangModel->delete($value['id_keranjang']);
            // kurangi jumlah produk
            $this->ProdukModel->update($value['id_produk'], [
                'stok' => intval($value['stok']) - intval($value['jumlah'])
            ]);
        }
        // exit(json_encode($data_transaksi));

        try {
            $this->TransaksiModel->insert($data);
            $this->DetailTransaksiModel->insertBatch($data_transaksi);
            $json = [
                'success' => "Transaksi " . $data['id_transaksi'] . " berhasil ditambahkan"
            ];
        } catch (\Throwable $th) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = getenv("MIDTRANS_SERVER_KEY");
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            // batalkan transasksi jika tidak dapat disimpan
            $status = \Midtrans\Transaction::status($data['id_transaksi'])->transaction_status;
            if (strtolower($status) == "capture" || strtolower($status) == "pending") {
                \Midtrans\Transaction::cancel($data['id_transaksi']);
            } else if (strtolower($status) == "settlement") {
                // refund
                // $params = array(
                //     'refund_key' => 'order1-ref1',
                //     'amount' => 10000,
                //     'reason' => 'Terdapat kesalahan pada sistem'
                // );
                // \Midtrans\Transaction::refund($data['id_transaksi'], $params);
            }
            $json = [
                'error' => "Transaksi gagal ditambahkan!"
            ];
        }
        echo json_encode($json);
    }

    public function history()
    {
        // cek user
        $cekUser = $this->UsersModel->cekKonsumen($this->userId)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Anda tidak memiliki akses untuk melakukan ini!');
            return redirect()->to(base_url('/'));
        }

        // cek daftar transaksi
        $transaksi = $this->TransaksiModel->cekTransaksi($this->userId)->getResultArray();
        if (!$transaksi) {
            session()->setFlashdata('msg', 'error#History transaksi masih kosong!');
            return redirect()->to(base_url('/'));
        }

        return view("konsumen/v_history", [
            'title' => 'History transaksi',
            'transaksi' => $transaksi,
        ]);
    }

    public function cekPembayaran()
    {
        if (!$this->request->isAJAX()) {
            exit("Maaf tidak dapat diproses!");
        }

        $id_transaksi = $this->request->getPost('id_transaksi');
        $transaksi = $this->TransaksiModel->cekTransaksiUser($this->userId, $id_transaksi)->getRowArray();
        if (!$transaksi) {
            exit(json_encode([
                'error' => 'Transaksi ' . $id_transaksi . ' tidak ditemukan!'
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
        $status = \Midtrans\Transaction::status($id_transaksi);

        if (strtolower($status->transaction_status) == "cancel" || strtolower($status->transaction_status) == "failure" || strtolower($status->transaction_status) == "expire") {
            $status_transaksi = "gagal";
        } else {
            $status_transaksi = $transaksi['status_transaksi'];
        }

        $this->TransaksiModel->update($id_transaksi, [
            'status_pembayaran' => $status->transaction_status,
            'status_transaksi' => $status_transaksi
        ]);

        $json = [
            'data' => view('konsumen/modalcekpembayaran', [
                'transaksi' => $this->TransaksiModel->cekTransaksiUser($this->userId, $id_transaksi)->getRowArray(),
                'status' => $status,
            ])
        ];
        echo json_encode($json);
    }

    public function detail_history($id_transaksi)
    {
        $transaksi = $this->TransaksiModel->cekTransaksiUser($this->userId, $id_transaksi)->getRowArray();
        if (!$transaksi) {
            session()->setFlashdata('msg', 'error#Transaksi tidak ditemukan!');
            return redirect()->to(base_url('history'));
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

        // // update pembayaran pada midtrans
        // $status = \Midtrans\Transaction::status($id_transaksi)->transaction_status;
        $status = \Midtrans\Transaction::status($id_transaksi);
        // dd($status);

        if (strtolower($status->transaction_status) == "cancel" || strtolower($status->transaction_status) == "failure" || strtolower($status->transaction_status) == "expire") {
            $status_transaksi = "gagal";
        } else {
            $status_transaksi = $transaksi['status_transaksi'];
        }

        $this->TransaksiModel->update($id_transaksi, [
            'status_pembayaran' => $status->transaction_status,
            'status_transaksi' => $status_transaksi,
        ]);

        return view('konsumen/v_detail_history', [
            'title' => 'Detail History - ' . $id_transaksi,
            'transaksi' => $this->TransaksiModel->cekTransaksiUser($this->userId, $id_transaksi)->getRowArray(),
            'detail' => $detail,
            'status' => $status,
        ]);
    }

    public function cetak_history($id_transaksi)
    {
        $transaksi = $this->TransaksiModel->cekTransaksiUser($this->userId, $id_transaksi)->getRowArray();
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
}
