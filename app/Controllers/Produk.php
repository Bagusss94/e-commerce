<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GambarProdukModel;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\SatuanModel;

class Produk extends BaseController
{
    protected $ProdukModel;
    protected $GambarProdukModel;
    protected $SatuanModel;
    protected $KategoriModel;

    public function __construct()
    {
        $this->ProdukModel = new ProdukModel();
        $this->GambarProdukModel = new GambarProdukModel();
        $this->SatuanModel = new SatuanModel();
        $this->KategoriModel = new KategoriModel();
    }

    public function index()
    {
        return view('admin/produk/v_produk', [
            'title' => 'Daftar Produk',
            'subtitle' => null,
            'dataProduk' => $this->ProdukModel
                ->join('satuan', 'produk.id_satuan=satuan.id_satuan', 'left')
                ->join('kategori', 'produk.id_kategori=kategori.id_kategori', 'left')
                ->orderBy('id_produk', 'DESC')->get()->getResultArray()
        ]);
    }

    public function tambah()
    {
        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_produk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'max_length' => '{field} maksimal 100 karakter!',
                    ]
                ],
                'harga_produk' => [
                    'label' => 'Harga Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
                'berat' => [
                    'label' => 'Berat Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
            ]);

            if (!$validation->run($this->request->getPost())) {
                return redirect()->to(base_url('produk/tambah'))->withInput();
            }

            try {
                $this->ProdukModel->insert($this->request->getPost());
                session()->setFlashdata('msg', 'success#Produk berhasil ditambahkan');
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', 'error#Terdapat kesalahan pada sistem!');
            }

            return redirect()->to(base_url('produk'));
        }

        return view('admin/produk/v_tambah_produk', [
            'title' => 'Daftar Produk',
            'subtitle' => "Tambah Produk",
            'satuan' => $this->SatuanModel->findAll(),
            'kategori' => $this->KategoriModel->findAll(),
        ]);
    }

    public function edit($id)
    {
        $cekProduk = $this->ProdukModel->find($id);
        if (!$cekProduk) {
            session()->setFlashdata('msg', 'error#Produk tidak ditemukan!');
            return redirect()->to(base_url('produk'));
        }

        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_produk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'max_length' => '{field} maksimal 100 karakter!',
                    ]
                ],
                'harga_produk' => [
                    'label' => 'Harga Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
                'berat' => [
                    'label' => 'Berat Produk',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'numeric' => '{field} harus angka!',
                    ]
                ],
            ]);

            if (!$validation->run($this->request->getPost())) {
                return redirect()->to(base_url('produk/edit/' . $id))->withInput();
            }

            try {
                $this->ProdukModel->update($id, $this->request->getPost());
                session()->setFlashdata('msg', 'success#Produk berhasil diubah');
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', 'error#Terdapat kesalahan pada sistem!');
            }

            return redirect()->to(base_url('produk'));
        }

        return view('admin/produk/v_edit_produk', [
            'title' => 'Daftar Produk',
            'subtitle' => "Edit Produk",
            'dataProduk' => $cekProduk,
            'satuan' => $this->SatuanModel->findAll(),
            'kategori' => $this->KategoriModel->findAll(),
        ]);
    }

    public function hapus($id)
    {
        try {
            $cekProduk = $this->ProdukModel->find($id);
            if (!$cekProduk) {
                session()->setFlashdata('msg', 'error#Produk tidak ditemukan!');
                return redirect()->to(base_url('produk'));
            }

            // hapus daftar gambar
            $daftarGambar = $this->GambarProdukModel->cariGambarProduk($id)->getResultArray();
            foreach ($daftarGambar as $gambar) {
                if ($gambar['gambar'] !== "" && $gambar['gambar'] !== null && $gambar['gambar'] !== 'default.jpg') {
                    unlink('images/' . $gambar['gambar']);
                }
                $this->GambarProdukModel->delete($gambar['id_gambar']);
            }

            // hapus produk
            $this->ProdukModel->delete($id);

            session()->setFlashdata('msg', 'success#Produk ' . $cekProduk['nama_produk'] . ' berhasil dihapus');
            return redirect()->to(base_url('produk'));
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', 'error#Produk ' . $cekProduk['nama_produk'] . ' tidak dapat dihapus!');
            return redirect()->to(base_url('produk'));
        }
    }

    public function tambah_gambar($id)
    {
        $cekProduk = $this->ProdukModel
            ->join('satuan', 'produk.id_satuan=satuan.id_satuan', 'left')
            ->join('kategori', 'produk.id_kategori=kategori.id_kategori', 'left')
            ->orderBy('id_produk', 'DESC')->find($id);
        if (!$cekProduk) {
            session()->setFlashdata('msg', 'error#Produk tidak ditemukan!');
            return redirect()->to(base_url('produk'));
        }

        // post
        if ($this->request->getPost()) {
            $id_produk = $this->request->getPost('id_produk');
            $gambar = $this->request->getFile('gambar');

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Gambar',
                    'rules' => "uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/png,image/jpeg,image/jpg]|max_size[gambar,3096]",
                    'errors' => [
                        'uploaded' => '{field} tidak boleh kosong!',
                        'is_image' => 'File harus gambar!',
                        'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                        'max_size' => 'Ukuran {field} maksimal 3mb!'
                    ],
                ]
            ]);

            if (!$valid) {
                return redirect()->to(base_url('produk/tambah_gambar/' . $id_produk . '#errors'))->withInput();
            }

            try {
                $namaGambarBaru = $gambar->getRandomName();
                $gambar->move('images', $namaGambarBaru);
                $this->GambarProdukModel->insert([
                    'id_produk' => $id_produk,
                    'gambar' => $namaGambarBaru
                ]);
                session()->setFlashdata('msg', 'success#Gambar berhasil ditambahkan');
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', 'error#Terdapat kesalahan pada sistem!');
            }

            return redirect()->to(base_url('produk/tambah_gambar/' . $id_produk));
        }

        // biasa
        $dataGambar = $this->GambarProdukModel->cariGambarBukanCover($cekProduk['id_produk'])->getResultArray();
        $coverGambar = $this->GambarProdukModel->cariGambarCover($cekProduk['id_produk'])->getRowArray();
        return view('admin/produk/v_tambah_gambar', [
            'title' => 'Daftar Produk',
            'subtitle' => 'Tambah Gambar Produk',
            'dataGambar' => $dataGambar,
            'dataProduk' => $cekProduk,
            'coverGambar' => $coverGambar,
        ]);
    }

    // public function detail_produk($id)
    // {
    //     $cekProduk = $this->ProdukModel->find($id);
    //     if (!$cekProduk) {
    //         session()->setFlashdata('msg', 'error#Produk tidak ditemukan!');
    //         return redirect()->to(base_url('produk'));
    //     }

    //     // biasa
    //     $dataGambar = $this->GambarProdukModel->cariGambarBukanCover($cekProduk['id_produk'])->getResultArray();
    //     $coverGambar = $this->GambarProdukModel->cariGambarCover($cekProduk['id_produk'])->getRowArray();
    //     return view('admin/produk/v_tambah_gambar', [
    //         'title' => 'Daftar Produk',
    //         'subtitle' => 'Detail Produk',
    //         'dataGambar' => $dataGambar,
    //         'dataProduk' => $cekProduk,
    //         'coverGambar' => $coverGambar,
    //     ]);
    // }

    public function jadikan_cover()
    {
        if ($this->request->isAJAX()) {
            $id_produk = $this->request->getPost('id_produk');
            $id_gambar = $this->request->getPost('id_gambar');
            $cekGambar = $this->GambarProdukModel
                ->where('id_produk', $id_produk)->where('status', 1)
                ->get()->getRowArray();
            // jika gambar cover sudah ada maka hapus dari daftar cover
            if ($cekGambar) {
                $this->GambarProdukModel->update($cekGambar['id_gambar'], [
                    'status' => 0
                ]);
            }

            $this->GambarProdukModel->update($id_gambar, [
                'status' => 1
            ]);

            echo json_encode([
                'success' => 'Cover berhasil diubah'
            ]);
        } else {
            exit("Tidak dapat diproses!");
        }
    }

    public function hapus_gambar()
    {
        if ($this->request->isAJAX()) {
            $id_gambar = $this->request->getPost('id_gambar');
            $cekGambar = $this->GambarProdukModel->find($id_gambar);
            if ($cekGambar) {
                try {
                    if ($cekGambar['gambar'] !== "" && $cekGambar['gambar'] !== null && $cekGambar['gambar'] !== 'default.jpg') {
                        // hapus gambar
                        unlink('images/' . $cekGambar['gambar']);
                    }
                    $this->GambarProdukModel->delete($id_gambar);
                    echo json_encode([
                        'success' => 'Gambar berhasil dihapus'
                    ]);
                } catch (\Throwable $th) {
                    echo json_encode([
                        'error' => 'Gambar gagal dihapus!'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => 'Gambar tidak ditemukan!'
                ]);
            }
        } else {
            exit("Tidak dapat diproses!");
        }
    }
}
