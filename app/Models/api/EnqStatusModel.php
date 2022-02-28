<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class EnqStatusModel extends Model
{
    protected $table = 'xla_enq_status';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 
        'description',
        'created_at',
        'update_at',      
        'status'
    ];
    
    public function insertEnqStatus($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteEnqStatus($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateEnqStatus($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}