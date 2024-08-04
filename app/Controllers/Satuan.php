<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SatuanModel;

class Satuan extends BaseController
{

    protected $SatuanModel;

    public function __construct()
    {
        $this->SatuanModel = new SatuanModel();
    }

    public function index()
    {
        return view('admin/satuan/v_satuan', [
            'title' => 'Kategori Satuan',
            'subtitle' => null,
            'dataSatuan' => $this->SatuanModel->select("satuan.*")
                // ->join('produk', 'produk.id_satuan=satuan.id_satuan', "left")
                ->findAll()
        ]);
    }

    public function modalForm($id = null)
    {
        if ($this->request->isAJAX()) {
            $title = "Tambah Satuan";
            $id_satuan = null;
            $satuan = null;

            if ($id != null) {
                $dataSatuan = $this->SatuanModel->find($id);
                if ($dataSatuan) {
                    $title = "Edit Satuan";
                    $id_satuan = $dataSatuan['id_satuan'];
                    $satuan = $dataSatuan['satuan'];
                }
            }
            $json = [
                'data' => view('admin/satuan/modalformsatuan', [
                    'title' => $title,
                    'id_satuan' => $id_satuan,
                    'satuan' => $satuan,
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
                'satuan' => [
                    'label' => 'Satuan',
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

            $this->SatuanModel->insert($this->request->getPost());

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
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
            ]);

            if ($this->request->getPost('id_satuan') == null || $this->request->getPost('id_satuan') == "") {
                echo json_encode([
                    'error' => "Satuan tidak ditemukan!"
                ]);
                return;
            }

            if (!$valid) {
                echo json_encode([
                    'errors' => $validation->getErrors()
                ]);
                return;
            }

            $this->SatuanModel->update($this->request->getPost('id_satuan'), $this->request->getPost());

            echo json_encode([
                'success' => "Kategori berhasil diubah"
            ]);
        }
    }

    public function hapus($id)
    {
        try {
            $cekSatuan = $this->SatuanModel->find($id);
            if (!$cekSatuan) {
                session()->setFlashdata('msg', 'error#Satuan tidak ditemukan!');
                return redirect()->to(base_url('satuan'));
            }

            $this->SatuanModel->delete($id);

            session()->setFlashdata('msg', 'success#Satuan ' . $cekSatuan['satuan'] . ' berhasil dihapus');
            return redirect()->to(base_url('satuan'));
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', 'error#Satuan ' . $cekSatuan['satuan'] . ' tidak dapat dihapus!');
            return redirect()->to(base_url('satuan'));
        }
    }
}
