<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class SystemModel extends Model
{
    protected $table = 'xla_sys_det';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'sys_name', 
      'created_at',
      'updated_at',
      'created_by',      
      'updated_by',
      'status'
    ];
    
    public function insertSystem($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteSystem($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateSystem($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}