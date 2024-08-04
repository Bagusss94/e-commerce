<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{

    protected $KategoriModel;

    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
    }

    public function index()
    {
        return view('admin/kategori/v_kategori', [
            'title' => 'Kategori Barang',
            'subtitle' => null,
            'dataKategori' => $this->KategoriModel->select('kategori.*')
                // ->join('produk', 'produk.id_kategori=kategori.id_kategori', "left")
                ->findAll()
        ]);
    }

    public function modalForm($id = null)
    {
        if ($this->request->isAJAX()) {
            $title = "Tambah Kategori";
            $id_kategori = null;
            $kategori = null;

            if ($id != null) {
                $dataKategori = $this->KategoriModel->find($id);
                if ($dataKategori) {
                    $title = "Edit Kategori";
                    $id_kategori = $dataKategori['id_kategori'];
                    $kategori = $dataKategori['kategori'];
                }
            }
            $json = [
                'data' => view('admin/kategori/modalformkategori', [
                    'title' => $title,
                    'id_kategori' => $id_kategori,
                    'kategori' => $kategori,
                ])
            ];
            echo json_encode($json);
        } else {
            exit("Tidak dapat diproses!");
        }
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kategori' => [
                    'label' => 'kategori',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
            ]);

            if (!$valid) {
                echo json_encode([
                    'errors' => $validation->getErrors()
                ]);
                return;
            }

            $this->KategoriModel->insert($this->request->getPost());

            echo json_encode([
                'success' => "Kategori berhasil ditambahkan"
            ]);
        }
    }

    public function ubah()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kategori' => [
                    'label' => 'kategori',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
            ]);

            if ($this->request->getPost('id_kategori') == null || $this->request->getPost('id_kategori') == "") {
                echo json_encode([
                    'error' => "kategori tidak ditemukan!"
                ]);
                return;
            }

            if (!$valid) {
                echo json_encode([
                    'errors' => $validation->getErrors()
                ]);
                return;
            }

            $this->KategoriModel->update($this->request->getPost('id_kategori'), $this->request->getPost());

            echo json_encode([
                'success' => "Kategori berhasil diubah"
            ]);
        }
    }

    public function hapus($id)
    {
        try {
            $cekkategori = $this->KategoriModel->find($id);
            if (!$cekkategori) {
                session()->setFlashdata('msg', 'error#kategori tidak ditemukan!');
                return redirect()->to(base_url('kategori'));
            }

            $this->KategoriModel->delete($id);

            session()->setFlashdata('msg', 'success#kategori ' . $cekkategori['kategori'] . ' berhasil dihapus');
            return redirect()->to(base_url('kategori'));
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', 'error#kategori ' . $cekkategori['kategori'] . ' tidak dapat dihapus!');
            return redirect()->to(base_url('kategori'));
        }
    }
}
