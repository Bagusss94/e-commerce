<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = ['email', 'password', 'nama_lengkap', 'telp', 'foto_profil', 'token_lupa_password', 'role', 'aktifasi_akun'];

    public function getAdmin($id = null)
    {
        if ($id !== null) {
            return $this->table($this->table)->where('role', 'admin')->where('id_user', $id)->get();
        }
        return $this->table($this->table)->where('role', 'admin')->get();
    }

    public function getOwner($id = null)
    {
        if ($id !== null) {
            return $this->table($this->table)->where('role', 'owner')->where('id_user', $id)->get();
        }
        return $this->table($this->table)->where('role', 'owner')->get();
    }

    public function getKonsumen($id = null)
    {
        if ($id !== null) {
            return $this->table($this->table)->select($this->table . ".*, a.id_alamat, a.alamat, a.provinsi, a.distrik")
                ->join("alamat_konsumen as a", $this->table . ".id_user = a.id_user", 'left')
                ->where('role', 'konsumen')
                ->where($this->table . '.id_user', $id)->get();
        }
        return $this->table($this->table)->where('role', 'konsumen')->get();
    }

    public function getKonsumenAktif($id = null)
    {
        if ($id !== null) {
            return $this->table($this->table)->select($this->table . ".*, a.id_alamat, a.alamat, a.provinsi, a.distrik")
                ->join("alamat_konsumen as a", $this->table . ".id_user = a.id_user", 'left')
                ->where('role', 'konsumen')
                ->where('aktifasi_akun', '1')
                ->where($this->table . '.id_user', $id)->get();
        }
        return $this->table($this->table)->where('role', 'konsumen')->where('aktifasi_akun', '1')->get();
    }

    public function getKonsumenTidakAktif($id = null)
    {
        if ($id !== null) {
            return $this->table($this->table)->select($this->table . ".*, a.id_alamat, a.alamat, a.provinsi, a.distrik")
                ->join("alamat_konsumen as a", $this->table . ".id_user = a.id_user", 'left')
                ->where('role', 'konsumen')
                ->where('aktifasi_akun', '0')
                ->where($this->table . '.id_user', $id)->get();
        }
        return $this->table($this->table)->where('role', 'konsumen')->where('aktifasi_akun', '0')->get();
    }

    public function getEmail($email)
    {
        return $this->table($this->table)->where('email', $email)->get();
    }

    public function cekKonsumen($id_user)
    {
        return $this->table($this->table)->select($this->table . ".*, a.id_alamat, a.alamat, a.provinsi, a.distrik")
            ->join("alamat_konsumen as a", $this->table . ".id_user = a.id_user", 'left')
            ->where('role', 'konsumen')
            ->where($this->table . '.id_user', $id_user)->get();
    }
}
