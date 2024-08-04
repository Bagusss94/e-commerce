<?php

namespace App\Models;

use CodeIgniter\Model;

class CarouselModel extends Model
{
    protected $table            = 'carousel';
    protected $primaryKey       = 'id_carousel';
    protected $allowedFields    = ['id_setting', 'nama_carousel', 'nama_gambar', 'deskripsi'];
}
