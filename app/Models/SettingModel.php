<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
  protected $table = 'xla_settings';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'setting_name',
    'setting_value',
    'type',
    'deleted'
  ];

  public function updateSetting($id, $data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table($this->table);
    return $builder->where('id', $id)->set($data)->update();
  }
}
