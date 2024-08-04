<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Dashboard extends BaseController
{
    protected $UsersModel;
    protected $userId;

    public function __construct()
    {
        $this->UsersModel = new UsersModel();
        $this->userId = session('LoginUser')['id_user'];
    }

    public function index()
    {
        $user = $this->UsersModel->find($this->userId);

        if ($this->request->getPost()) {
            $valid = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => "required|valid_email|is_unique[users.email, id_user, " . $user['id_user'] . "]|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'is_unique' => "{field} " . $this->request->getPost('email') . " sudah digunakan!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Nama lengkap',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "permit_empty|max_length[100]",
                    'errors' => [
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype Password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} tidak valid!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required|max_length[100]|numeric",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'numeric' => "{field} harus angka!",
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'foto_profil' => [
                    'label' => 'No. Telp',
                    'rules' => "is_image[foto_profil]|max_size[foto_profil,2048]|mime_in[foto_profil,image/png,image/jpg, image/jpeg]",
                    'errors' => [
                        'is_image' => "{field} harus gambar!",
                        'mime_in' => "{field} harus format[png/jpg/jpeg]!",
                        'max_size' => "{field} maksimal 2mb!",
                    ]
                ],
            ]);

            if (!$valid) {
                return redirect()->to(base_url('dashboard'))->withInput();
            }

            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil->getError() == 4) {
                $namaFoto = $user['foto_profil'];
            } else {
                if ($user['foto_profil'] != "" && $user['foto_profil'] != null && $user['foto_profil'] != "default.jpg") {
                    unlink("images/" . $user['foto_profil']);
                }
                $namaFoto = $foto_profil->getRandomName();
                $foto_profil->move('images/', $namaFoto);
            }

            if ($this->request->getPost('password') == "" || $this->request->getPost('password') == null) {
                $password = $user['password'];
            } else {
                $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            $data = $this->request->getPost();
            $data['foto_profil'] = $namaFoto;
            $data['password'] = $password;

            $this->UsersModel->update($this->userId, $data);

            session()->setFlashdata('msg', 'success#Profil berhasil diupdate!');
            return redirect()->to(base_url("dashboard"));
        }

        return view('v_dashboard', [
            'title' => 'Dashboard',
            'subtitle' => null,
            'user' => $user,
        ]);
    }
}
