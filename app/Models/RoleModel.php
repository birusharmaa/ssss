<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
  protected $table = 'xla_role';
  protected $primaryKey = 'id ';
  protected $allowedFields = [
    'title',
    'permission',
    'created_at',
    'update_at',
    'status',
    'created_by'
  ];

  public function getAllRole()
  {
    $bulider = $this->db->table($this->table);
    $res = $bulider->get()->getResult();

    if ($res) {
      return $res;
    } else {
      return false;
    }
  }

  public function getAllModule()
  {
    $bulider = $this->db->table('xla_module');
    $res = $bulider->get()->getResult();
    if ($res) {
      return $res;
    } else {
      return false;
    }
  }
}
