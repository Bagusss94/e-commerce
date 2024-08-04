<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqsModel extends Model
{
  protected $table = 'faqs';
  protected $primaryKey = 'id';
  protected $allowedFields = ['question', 'answer', 'created_at', 'updated_at'];
  protected $useTimestamps = true;
}
