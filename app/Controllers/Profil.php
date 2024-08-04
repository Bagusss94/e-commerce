<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlamatKonsumenModel;
use App\Models\UsersModel;

class Profil extends BaseController
{
    protected $UserModel;
    protected $userId;
    protected $AlamatKonsumenModel;

    public function __construct()
    {
        $this->UserModel = new UsersModel();
        $this->AlamatKonsumenModel = new AlamatKonsumenModel();
        $this->userId = session()->get('LoginUser')['id_user'];
    }

    public function index()
    {
        $dataUser = $this->UserModel->getKonsumen($this->userId)->getRowArray();
        if (!$dataUser) {
            session()->setFlashdata('msg', 'error#Anda tidak memiliki hak akses untuk melihat ini!');
            return redirect()->to(base_url('/'));
        }

        if ($this->request->getPost()) {
            $valid = $this->validate([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email|max_length[100]|is_unique[users.email,id_user," . $dataUser['id_user'] . "]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} <b>" . $this->request->getPost('email') . "</b> sudah digunakan!",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Nama Lengkap',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "permit_empty|min_length[5]|max_length[100]",
                    'errors' => [
                        'max_length' => "{field} maksimal 100 karakter!",
                        'min_length' => "{field} minimal 5 karakter!",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype Password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} tidak sesuai!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required|numeric",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'numeric' => "{field} harus angka!",
                    ]
                ],
                'provinsi' => [
                    'label' => 'Distrik',
                    'rules' => "permit_empty",
                ],
                'distrik' => [
                    'label' => 'Distrik',
                    'rules' => "permit_empty",
                ],
            ]);

            if (!$valid) {
                return redirect()->to(base_url('profil'))->withInput();
            }

            $data = $this->request->getPost();
            if ($this->request->getPost('password') == "" || $this->request->getPost('password') == null) {
                $data['password'] = $dataUser['password'];
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            // jika sudah punya data di tabel alamat 
            if ($data['id_alamat'] != null) {
                $this->AlamatKonsumenModel->update($data['id_alamat'], [
                    'id_user' => $this->userId,
                    'alamat' => $data['alamat'],
                    'provinsi' => $data['provinsi'] ?? null,
                    'distrik' => $data['distrik'] ?? null,
                ]);
                // jika belum punya data di tabel alamat
            } else {
                $this->AlamatKonsumenModel->insert([
                    'id_user' => $this->userId,
                    'alamat' => $data['alamat'],
                    'provinsi' => $data['provinsi'] ?? null,
                    'distrik' => $data['distrik'] ?? null,
                ]);
            }

            // simpan biodata
            $this->UserModel->update($this->userId, $data);

            session()->setFlashdata('msg', 'success#Biodata berhasil diubah');
            return redirect()->to(base_url('profil'));
        }

        return view('konsumen/v_profil', [
            'title' => 'Profil',
            'user' => $dataUser,
        ]);
    }

    public function ubah_profil()
    {
        $dataUser = $this->UserModel->getKonsumen($this->userId)->getRowArray();
        if (!$dataUser) {
            session()->setFlashdata('msg', 'error#Anda tidak memiliki hak akses untuk melihat ini!');
            return redirect()->to(base_url('/'));
        }

        $valid = $this->validate([
            'foto_profil' => [
                'label' => 'Foto Profil',
                'rules' => "max_size[foto_profil,2048]|is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpeg,image/jpg]",
                'errors' => [
                    'max_size' => "{field} ukuran foto maksimal 2mb!",
                    'is_image' => "{field} harus dalam bentuk gambar!",
                    'mime_in' => "Format {field} harus [png/jpg/jpeg]"
                ]
            ]
        ]);

        if (!$valid) {
            return redirect()->to(base_url("profil"))->withInput();
        }

        $foto_profil = $this->request->getFile('foto_profil');
        if ($foto_profil->getError() == 4) {
            $namaFoto = $dataUser['foto_profil'];
        } else {
            // cek gambar lama dan hapus gambar lama
            if ($dataUser['foto_profil'] != "" && $dataUser['foto_profil'] != null && $dataUser['foto_profil'] != "default.jpg") {
                unlink("images/" . $dataUser['foto_profil']);
            }
            $namaFoto = $foto_profil->getRandomName();
            $foto_profil->move("images/", $namaFoto);
        }

        $this->UserModel->update($this->userId, [
            'foto_profil' => $namaFoto
        ]);

        session()->setFlashdata('msg', 'success#Foto profil berhasil diubah');
        return redirect()->to(base_url('profil'));
    }
}
