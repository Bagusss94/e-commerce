<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarouselModel;
use App\Models\SettingModel;

class Setting extends BaseController
{
    protected $CarouselModel;
    protected $SettingModel;
    protected $id_setting;

    public function __construct()
    {
        $this->SettingModel = new SettingModel();
        $this->CarouselModel = new CarouselModel();

        $this->id_setting = $this->SettingModel->first()['id_setting'];
    }

    public function index()
    {
        // membuat session
        return view('admin/setting/v_setting', [
            'title' => 'Setting',
            'subtitle' => null,
            'setting' => $this->SettingModel->getSetting(),
            'carousel' => $this->CarouselModel->findAll(),
            'bagianFokus' => session()->getFlashdata('bagianFokus') ? session()->getFlashdata('bagianFokus') : 'setting'
        ]);
    }

    public function ubah_setting()
    {
        $valid = $this->validate([
            'nama_web' => [
                'label' => "Nama website",
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!',
                    'max_length' => '{field} maksimal 100 karakter!',
                ]
            ],
            'alamat' => [
                'label' => "Alamat Toko",
                'rules' => 'required|max_length[500]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!',
                    'max_length' => '{field} maksimal 100 karakter!',
                ]
            ],
            'provinsi' => [
                'label' => "Provinsi Toko",
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!',
                ]
            ],
            'distrik' => [
                'label' => "Kabupaten/Kota Toko",
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!',
                ]
            ],
            // 'deskripsi' => [
            //     'label' => "Deskripsi",
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} tidak boleh kosong!',
            //     ]
            // ],
            'tentang_kami' => [
                'label' => "Tentang kami",
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!',
                ]
            ],
            'logo_web' => [
                'label' => 'Logo Web',
                'rules' => "is_image[logo_web]|mime_in[logo_web,image/png,image/jpeg,image/jpg]|max_size[logo_web,3096]",
                'errors' => [
                    'is_image' => '{field} harus gambar!',
                    'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                    'max_size' => 'Ukuran {field} maksimal 3mb!'
                ],
            ],
            'gambar_toko' => [
                'label' => 'Logo Web',
                'rules' => "is_image[gambar_toko]|mime_in[gambar_toko,image/png,image/jpeg,image/jpg]|max_size[gambar_toko,3096]",
                'errors' => [
                    'is_image' => '{field} harus gambar!',
                    'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                    'max_size' => 'Ukuran {field} maksimal 3mb!'
                ],
            ]
        ]);

        if (!$valid) {
            session()->setFlashdata('bagianFokus', 'setting');
            return redirect()->to(base_url('setting'))->withInput();
        }

        $setting = $this->SettingModel->first();
        $logoWeb = $this->request->getFile('logo_web');
        if ($logoWeb->getError() == 4) {
            $namaLogo = $setting['logo_web'];
        } else {
            if ($setting['logo_web'] !== "" && $setting['logo_web'] !== null && $setting['logo_web'] !== 'default.jpg') {
                unlink('images/' . $setting['logo_web']);
            }
            $namaLogo = $logoWeb->getRandomName();
            $logoWeb->move('images/', $namaLogo);
        }
        $gambarToko = $this->request->getFile('gambar_toko');
        if ($gambarToko->getError() == 4) {
            $namaGambarToko = $setting['gambar_toko'];
        } else {
            if ($setting['gambar_toko'] !== "" && $setting['gambar_toko'] !== null && $setting['gambar_toko'] !== 'default.jpg') {
                unlink('images/' . $setting['gambar_toko']);
            }
            $namaGambarToko = $gambarToko->getRandomName();
            $gambarToko->move('images/', $namaGambarToko);
        }

        $data = $this->request->getPost();
        $data['logo_web'] = $namaLogo;
        $data['gambar_toko'] = $namaGambarToko;

        $this->SettingModel->update($this->id_setting, $data);
        session()->setFlashdata('bagianFokus', 'setting');
        session()->setFlashdata('msg', 'success#Setting web berhasil diubah');
        return redirect()->to(base_url('setting'));
    }

    public function tambah_carousel()
    {
        $valid = $this->validate([
            'nama_gambar' => [
                'label' => 'Logo Web',
                'rules' => "uploaded[nama_gambar]|is_image[nama_gambar]|mime_in[nama_gambar,image/png,image/jpeg,image/jpg]|max_size[nama_gambar,3096]",
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong!',
                    'is_image' => '{field} harus gambar!',
                    'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                    'max_size' => 'Ukuran {field} maksimal 3mb!'
                ],
            ]
        ]);

        if (!$valid) {
            session()->setFlashdata('bagianFokus', 'carousel');
            return redirect()->to(base_url('setting'))->withInput();
        }

        $gambar = $this->request->getFile('nama_gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('images/', $namaGambar);

        $this->CarouselModel->insert([
            'nama_gambar' => $namaGambar,
            'nama_carousel' => $this->request->getPost('nama_carousel'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('bagianFokus', 'carousel');
        session()->setFlashdata('msg', 'success#Carousel berhasil ditambahkan');
        return redirect()->to(base_url('setting'));
    }

    public function hapus_carousel($id)
    {
        $cekCarousel = $this->CarouselModel->find($id);
        if (!$cekCarousel) {
            session()->setFlashdata('msg', 'error#Carousel tidak ditemukan');
            return redirect()->to(base_url('setting'));
        }

        if ($cekCarousel['nama_gambar'] !== "" && $cekCarousel['nama_gambar'] !== null && $cekCarousel['nama_gambar'] !== 'default.jpg') {
            unlink('images/' . $cekCarousel['nama_gambar']);
        }

        $this->CarouselModel->delete($id);

        session()->setFlashdata('bagianFokus', 'carousel');
        session()->setFlashdata('msg', 'success#Carousel berhasil dihapus');
        return redirect()->to(base_url('setting'));
    }
}
