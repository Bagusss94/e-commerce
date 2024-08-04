<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlamatKonsumenModel;
use App\Models\UsersModel;

class Users extends BaseController
{
    protected $UsersModel;
    protected $AlamatKonsumenModel;

    public function __construct()
    {
        $this->UsersModel = new UsersModel();
        $this->AlamatKonsumenModel = new AlamatKonsumenModel();
    }


    private function toWhatsappNumber($telpLama)
    {
        $telp = substr($telpLama, 5);
        $telp = str_replace("-", "", $telp);
        $telp = "62" . str_replace("_", "", $telp);
        return $telp;
    }

    private function enkripsi_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function admin()
    {
        $dataAdmin = $this->UsersModel->getAdmin()->getResultArray();
        return view('admin/users/v_admin', [
            'title' => 'Data Admin',
            'subtitle' => null,
            'dataAdmin' => $dataAdmin
        ]);
    }

    public function owner()
    {
        $dataOwner = $this->UsersModel->getOwner()->getResultArray();
        return view('admin/users/v_owner', [
            'title' => 'Data Owner',
            'subtitle' => null,
            'dataOwner' => $dataOwner
        ]);
    }

    public function konsumen($status = null)
    {
        if ($status == "aktif" || $status == null) {
            $dataKonsumen = $this->UsersModel->getKonsumenAktif()->getResultArray();
            $title = "Data Konsumen Aktif";
        } else if ($status == "tidak_aktif") {
            $dataKonsumen = $this->UsersModel->getKonsumenTidakAktif()->getResultArray();
            $title = "Data Konsumen Tidak Aktif";
        } else {
            return redirect()->to(base_url('user/konsumen'));
        }
        return view('admin/users/v_konsumen', [
            'title' => $title,
            'subtitle' => null,
            'dataKonsumen' => $dataKonsumen,
            'status' => $status,
        ]);
    }

    // ADMIN
    public function tambah_admin()
    {
        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();

            // data post dimasukkan ke variabel $data
            $data = $this->request->getPost();
            // mengubah ke nomor hp yang dapat dihubungi wangsaff
            $data['telp'] = $this->toWhatsappNumber($data['telp']);
            $data['foto_profil'] = $this->request->getFile('foto_profil');

            $validation->setRules([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email|max_length[100]|is_unique[users.email,id_user]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} sudah digunakan!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} salah!",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Retype password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                    ]
                ],
                'foto_profil' => [
                    'label' => 'Foto profil',
                    'rules' => "is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpeg,image/jpg]|max_size[foto_profil,3096]",
                    'errors' => [
                        'is_image' => '{field} harus gambar!',
                        'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                        'max_size' => 'Ukuran {field} maksimal 3mb!'
                    ],
                ]
            ]);

            if (!$validation->run($data)) {
                return redirect()->to(base_url('users/tambah_admin'))->withInput();
            }

            // cek apakah gambar sudah diupload
            if ($data['foto_profil']->getError() == 4) {
                $namaProfil = 'default.jpg';
            } else {
                $namaProfil = $data['foto_profil']->getRandomName();
                // memindahkan gambar ke folder image
                $data['foto_profil']->move("images/", $namaProfil);
            }

            // mengganti nama profil
            $data['foto_profil'] = $namaProfil;
            $data['password'] = $this->enkripsi_password($data['password']);
            $this->UsersModel->insert($data);

            session()->setFlashdata('msg', 'success#Admin berhasil ditambahkan');
            return redirect()->to(base_url('users/admin'));
        }

        return view('admin/users/v_tambah_admin', [
            'title' => 'Data Admin',
            'subtitle' => 'Tambah Admin',
            'role' => 'admin',
        ]);
    }

    public function edit_admin($id)
    {
        $cekUser = $this->UsersModel->getAdmin($id)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Admin tidak ditemukan!');
            return redirect()->to(base_url('users/admin'));
        }

        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();

            // data post dimasukkan ke variabel $data
            $data = $this->request->getPost();
            // mengubah ke nomor hp yang dapat dihubungi wangsaff
            $data['telp'] = $this->toWhatsappNumber($data['telp']);
            $data['foto_profil'] = $this->request->getFile('foto_profil');

            $validation->setRules([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email|max_length[100]|is_unique[users.email,id_user, " . $id . "]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} sudah digunakan!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "max_length[100]",
                    'errors' => [
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} salah!",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Retype password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 12 karakter!",
                    ]
                ],
                'foto_profil' => [
                    'label' => 'Foto profil',
                    'rules' => "is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpeg,image/jpg]|max_size[foto_profil,3096]",
                    'errors' => [
                        'is_image' => '{field} harus gambar!',
                        'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                        'max_size' => 'Ukuran {field} maksimal 3mb!'
                    ],
                ]
            ]);

            if (!$validation->run($data)) {
                return redirect()->to(base_url('users/tambah_admin'))->withInput();
            }

            // cek apakah gambar sudah diupload
            if ($data['foto_profil']->getError() == 4) {
                $namaProfil = $cekUser['foto_profil'];
            } else {
                // menghapus foto lama
                if ($cekUser['foto_profil'] !== "" && $cekUser['foto_profil'] !== null && $cekUser['foto_profil'] !== 'default.jpg') {
                    unlink("images/" . $cekUser['foto_profil']);
                }

                $namaProfil = $data['foto_profil']->getRandomName();
                // memindahkan gambar ke folder image
                $data['foto_profil']->move("images/", $namaProfil);
            }
            // mengganti nama profil
            $data['foto_profil'] = $namaProfil;

            // apakah password diubah
            if ($data['password'] !== "") {
                $data['password'] = $this->enkripsi_password($data['password']);
            } else {
                $data['password'] = $cekUser['password'];
            }

            $this->UsersModel->update($id, $data);

            session()->setFlashdata('msg', 'success#Admin berhasil diubah');
            return redirect()->to(base_url('users/admin'));
        }

        return view('admin/users/v_edit_admin', [
            'title' => 'Data Admin',
            'subtitle' => 'Edit Admin',
            'dataUser' => $cekUser,
        ]);
    }

    public function hapus_admin($id)
    {
        try {
            $cekUser = $this->UsersModel->getAdmin($id)->getRowArray();
            if (!$cekUser) {
                session()->setFlashdata('msg', 'error#Admin tidak ditemukan!');
                return redirect()->to(base_url('users/admin'));
            }

            if ($cekUser['foto_profil'] !== "" && $cekUser['foto_profil'] !== null && $cekUser['foto_profil'] !== 'default.jpg' && file_exists("images/" . $cekUser['foto_profil'])) {
                unlink("images/" . $cekUser['foto_profil']);
            }

            $alamatModel = new AlamatKonsumenModel();
            $alamatModel->where('id_user', $id)->delete();

            $this->UsersModel->delete($id);

            session()->setFlashdata('msg', 'success#Admin berhasil dihapus');
            return redirect()->to(base_url('users/admin'));
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', 'error#Admin tidak dapat dihapus');
            return redirect()->to(base_url('users/admin'));
        }
    }


    // OWNER
    public function tambah_owner()
    {
        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();

            // data post dimasukkan ke variabel $data
            $data = $this->request->getPost();
            // mengubah ke nomor hp yang dapat dihubungi wangsaff
            $data['telp'] = $this->toWhatsappNumber($data['telp']);
            $data['foto_profil'] = $this->request->getFile('foto_profil');

            $validation->setRules([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email|max_length[100]|is_unique[users.email,id_user]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} sudah digunakan!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} salah!",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Retype password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                    ]
                ],
                'foto_profil' => [
                    'label' => 'Foto profil',
                    'rules' => "is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpeg,image/jpg]|max_size[foto_profil,3096]",
                    'errors' => [
                        'is_image' => '{field} harus gambar!',
                        'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                        'max_size' => 'Ukuran {field} maksimal 3mb!'
                    ],
                ]
            ]);

            if (!$validation->run($data)) {
                return redirect()->to(base_url('users/tambah_owner'))->withInput();
            }

            // cek apakah gambar sudah diupload
            if ($data['foto_profil']->getError() == 4) {
                $namaProfil = 'default.jpg';
            } else {
                $namaProfil = $data['foto_profil']->getRandomName();
                // memindahkan gambar ke folder image
                $data['foto_profil']->move("images/", $namaProfil);
            }

            // mengganti nama profil
            $data['foto_profil'] = $namaProfil;
            $data['password'] = $this->enkripsi_password($data['password']);
            $this->UsersModel->insert($data);

            session()->setFlashdata('msg', 'success#Owner berhasil ditambahkan');
            return redirect()->to(base_url('users/owner'));
        }

        return view('admin/users/v_tambah_owner', [
            'title' => 'Data owner',
            'subtitle' => 'Tambah owner',
            'role' => 'owner',
        ]);
    }

    public function edit_owner($id)
    {
        $cekUser = $this->UsersModel->getOwner($id)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Owner tidak ditemukan!');
            return redirect()->to(base_url('users/owner'));
        }

        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();

            // data post dimasukkan ke variabel $data
            $data = $this->request->getPost();
            // mengubah ke nomor hp yang dapat dihubungi wangsaff
            $data['telp'] = $this->toWhatsappNumber($data['telp']);
            $data['foto_profil'] = $this->request->getFile('foto_profil');

            $validation->setRules([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email|max_length[100]|is_unique[users.email,id_user, " . $id . "]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} sudah digunakan!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => "max_length[100]",
                    'errors' => [
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => "{field} salah!",
                    ]
                ],
                'nama_lengkap' => [
                    'label' => 'Retype password',
                    'rules' => "required|max_length[100]",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                    ]
                ],
                'foto_profil' => [
                    'label' => 'Foto profil',
                    'rules' => "is_image[foto_profil]|mime_in[foto_profil,image/png,image/jpeg,image/jpg]|max_size[foto_profil,3096]",
                    'errors' => [
                        'is_image' => '{field} harus gambar!',
                        'mime_in' => 'Format {field} harus png/jpeg/jpg!',
                        'max_size' => 'Ukuran {field} maksimal 3mb!'
                    ],
                ]
            ]);

            if (!$validation->run($data)) {
                return redirect()->to(base_url('users/tambah_owner'))->withInput();
            }

            // cek apakah gambar sudah diupload
            if ($data['foto_profil']->getError() == 4) {
                $namaProfil = $cekUser['foto_profil'];
            } else {
                // menghapus foto lama
                if ($cekUser['foto_profil'] !== "" && $cekUser['foto_profil'] !== null && $cekUser['foto_profil'] !== 'default.jpg') {
                    unlink("images/" . $cekUser['foto_profil']);
                }

                $namaProfil = $data['foto_profil']->getRandomName();
                // memindahkan gambar ke folder image
                $data['foto_profil']->move("images/", $namaProfil);
            }
            // mengganti nama profil
            $data['foto_profil'] = $namaProfil;

            // apakah password diubah
            if ($data['password'] !== "") {
                $data['password'] = $this->enkripsi_password($data['password']);
            } else {
                $data['password'] = $cekUser['password'];
            }

            $this->UsersModel->update($id, $data);

            session()->setFlashdata('msg', 'success#Owner berhasil diubah');
            return redirect()->to(base_url('users/owner'));
        }

        return view('admin/users/v_edit_owner', [
            'title' => 'Data Owner',
            'subtitle' => 'Edit Owner',
            'dataUser' => $cekUser,
        ]);
    }

    public function hapus_owner($id)
    {
        $cekUser = $this->UsersModel->getOwner($id)->getRowArray();
        if (!$cekUser) {
            session()->setFlashdata('msg', 'error#Owner tidak ditemukan!');
            return redirect()->to(base_url('users/owner'));
        }

        if ($cekUser['foto_profil'] !== "" && $cekUser['foto_profil'] !== null && $cekUser['foto_profil'] !== 'default.jpg') {
            unlink("images/" . $cekUser['foto_profil']);
        }

        $this->UsersModel->delete($id);

        session()->setFlashdata('msg', 'success#Owner berhasil dihapus');
        return redirect()->to(base_url('users/owner'));
    }

    public function detail_konsumen()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getPost('id_user');

            $dataUser = $this->UsersModel->getKonsumen($id_user)->getRowArray();
            if ($dataUser) {
                $json = [
                    'data' => view('admin/users/modaldetailkonsumen', [
                        'dataUser' => $dataUser,
                    ])
                ];
            } else {
                $json = [
                    'error' => 'Konsumen dengan id ' . $id_user . ' tidak ditemukan!'
                ];
            }
            echo json_encode($json);
        } else {
            exit("Tidak dapat diproses!");
        }
    }

    public function aktifkan_akun($id = null)
    {
        $userData = $this->UsersModel->getKonsumenTidakAktif($id)->getRowArray();

        if ($userData) {
            $this->UsersModel->update($id, [
                'aktifasi_akun' => 1
            ]);
            session()->setFlashdata('msg', 'success#Akun ' . $userData['email'] . ' berhasil diaktifkan');
            return redirect()->to(base_url('users/konsumen/aktif'));
        }

        return redirect()->to(base_url('users/konsumen/tidak_aktif'));
    }
}
