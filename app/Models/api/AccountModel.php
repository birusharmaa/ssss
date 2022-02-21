<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'xla_account';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'account_name', 
      'created_at',
      'updated_at',
      'created_by',
      'updated_by',
      'status'
    ];
    
    public function insertAccount($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteAccount($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateAccount($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}