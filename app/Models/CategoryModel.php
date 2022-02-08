<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class CategoryModel extends Model
{
  protected $table = 'xla_category';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'title',
    'status',
    'created_at',
    'updated_at'
  ];

  public function getCategories()
  {
    $builder =  $this->db->table($this->table);
    $builder->where('status', true);
    $result = $builder->get();
    if ($result->getResultArray() > 0) {
      return $result->getResult();
    } else {
      return false;
    }
  }

}
