<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Auth extends BaseController
{
    protected $UsersModel;

    public function __construct()
    {
        $this->UsersModel = new UsersModel();
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

    public function login()
    {
        if ($this->request->getPost()) {
            $valid = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                    ]
                ]
            ]);

            if (!$valid) {
                return redirect()->to(base_url('auth/login'))->withInput();
            }

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $cekUser = $this->UsersModel->getEmail($email)->getRowArray();
            if (!$cekUser) {
                session()->setFlashdata('msg', 'error#E-mail ' . $email . ' tidak terdaftar pada sistem!');
                return redirect()->to(base_url('auth/login'));
            }
            $aktifasi_akun = $cekUser['aktifasi_akun'];
            if ($aktifasi_akun == 0) {
                session()->setFlashdata('msg', 'error#E-mail ' . $email . ' belum diaktifkan oleh admin!');
                return redirect()->to(base_url('auth/login'));
            }

            // cek user, password salah
            if (!password_verify($password, $cekUser['password'])) {
                session()->setFlashdata('msg', 'error#Password yang anda masukkan salah!');
                return redirect()->to(base_url('auth/login'));
            }

            // password benar buat session
            $data_session = [
                'id_user' => $cekUser['id_user'],
                'email' => $cekUser['email'],
                'nama_lengkap' => $cekUser['nama_lengkap'],
                'role' => $cekUser['role'],
                'foto_profil' => $cekUser['foto_profil'],
                'time' => date('Y-m-d H:i:s'),
                'login' => true,
            ];
            session()->set('LoginUser', $data_session);
            session()->setFlashdata('msg', 'success#Selamat datang ' . $cekUser['nama_lengkap'] . '!');

            if ($cekUser['role'] === "konsumen") {
                return redirect()->to(base_url('/'));
            } else {
                return redirect()->to(base_url('/dashboard'));
            }
        }

        return view('v_login', [
            'title' => 'Login'
        ]);
    }

    public function register()
    {
        if ($this->request->getPost()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_lengkap' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'email' => [
                    'label' => 'E-mail',
                    'rules' => 'required|max_length[100]|valid_email|is_unique[users.email,id_user]',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                        'max_length' => "{field} maksimal 100 karakter!",
                        'is_unique' => "{field} sudah digunakan!",
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'max_length' => "{field} maksimal 100 karakter",
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => "{field} tidak sesuai!",
                    ]
                ],
                'telp' => [
                    'label' => 'No. Telp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                    ]
                ],
            ]);

            if (!$validation->run($this->request->getPost())) {
                return redirect()->to(base_url('auth/register'))->withInput();
            }

            $data = $this->request->getPost();
            $data['telp'] = $this->toWhatsappNumber($this->request->getPost('telp'));
            $data['password'] = $this->enkripsi_password($this->request->getPost('password'));
            $data['role'] = "konsumen";
            $data['foto_profil'] = "default.jpg";
            $data['aktifasi_akun'] = 0;

            $this->UsersModel->insert($data);

            session()->setFlashdata('msg', 'success#Registrasi berhasil, silahkan tunggu sampai akun sudah dapat digunakan');
            return redirect()->to(base_url('auth/login'));
        }

        return view('v_register', [
            'title' => 'Register'
        ]);
    }

    public function lupa_password()
    {
        if ($this->request->getPost()) {
            $valid = $this->validate([
                'email' => [
                    'label' => 'E-mail',
                    'rules' => "required|valid_email",
                    'errors' => [
                        'required' => "{field} tidak boleh kosong!",
                        'valid_email' => "{field} tidak valid!",
                    ]
                ]
            ]);

            if (!$valid) {
                return redirect()->to(base_url("auth/lupa_password"))->withInput();
            }

            $email = $this->request->getPost('email');
            $cekEmail = $this->UsersModel->getEmail($email)->getRowArray();
            if (!$cekEmail) {
                session()->setFlashdata('msg', "error#E-mail konsumen " . $email . " tidak terdaftar pada sistem!");
                return redirect()->to(base_url("auth/lupa_password"));
            }

            $token = md5(rand(0, 255));
            $subject = "Ganti Password";
            $message = "Seseorang meminta untuk melakukan perubahan password pada akun anda, silahkan klik link ini : " . base_url('auth/ubah-password/' . $email . '/' . $token);

            $sendEmail = \Config\Services::email();
            // dd($sendEmail);
            // $sendEmail->SMTPUser = "crewpucksapi@gmail.com";
            // $sendEmail->SMTPPass = "rdcjbxhpcrcmiost";
            $sendEmail->setTo($email);
            $sendEmail->setFrom("crewpucksapi@gmail.com", 'Confirm Reset Password');
            $sendEmail->setSubject($subject);
            $sendEmail->setMessage($message);
            if ($sendEmail->send()) {
                $this->UsersModel->update($cekEmail['id_user'], [
                    'token_lupa_password' => $token,
                ]);
                session()->setFlashdata('msg', "success#Link reset password berhasil terkirim ke email " . $email);
                return redirect()->to(base_url("auth/lupa_password"));
            } else {
                $data = $sendEmail->printDebugger(['headers']);
                print_r($data);
                // session()->setFlashdata('msg', "error#Link reset password gagal terkirim");
                // return redirect()->to(base_url("auth/lupa_password"));
            }
        }

        return view('v_lupa_password', [
            'title' => 'Lupa Password',
        ]);
    }

    public function ubah_password($email, $token)
    {
        $cekData = $this->UsersModel->getWhere([
            'email' => $email,
            'token_lupa_password' => $token
        ])->getRowArray();
        if (!$cekData) {
            session()->setFlashdata('msg', "error#Link tidak valid!");
            return redirect()->to(base_url("auth/login"));
        }

        if ($this->request->getPost()) {
            $valid = $this->validate([
                'password' => [
                    'label' => 'Password',
                    'rules' => "required|max_length[100]|min_length[5]",
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                        'min_length' => '{field} tidak boleh kurang dari 5 karakter',
                    ]
                ],
                'retype_password' => [
                    'label' => 'Retype password',
                    'rules' => "matches[password]",
                    'errors' => [
                        'matches' => '{field} tidak valid!',
                    ]
                ]
            ]);

            if (!$valid) {
                return redirect()->to(base_url("auth/ubah-password/" . $email . "/" . $token))->withInput();
            }

            $passwordHash = $this->enkripsi_password($this->request->getPost('password'));
            $this->UsersModel->update($cekData['id_user'], [
                'password' => $passwordHash,
                'token_lupa_password' => null,
            ]);
            session()->setFlashdata('msg', "success#Ubah password berhasil, silahkan login");
            return redirect()->to(base_url("auth/login"));
        }

        return view('v_ubah_password', [
            'title' => 'Ubah password',
        ]);
    }

    public function logout()
    {
        session()->remove('LoginUser');
        session()->setFlashdata('msg', 'success#Anda berhasil logout');
        return redirect()->to(base_url('auth/login'));
    }
}
