<?php 

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'xla_users';
    protected $primaryKey = 'emp_id';
    protected $allowedFields = [
      'full_name', 
      'designation',
      'personal_email',
      'password',
      'office_number',
      'personal_number',
      'picture_attachment',
      'sys_name',
      'account_name',
      'location',
      'key'
    ];
    
    public function updateImage($id,$data){
      $db = \Config\Database::connect();
      $builder = $db->table($this->table);
      $builder->set($data);
      $builder->where('emp_id', $id);
      return $builder->update();
  }
}