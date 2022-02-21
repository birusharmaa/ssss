<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'xla_subject';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'subject_name', 
      'created_at',
      'updated_at',
      'created_by',      
      'updated_by',
      'status'
    ];
    
    public function insertSubject($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteSubject($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateSubject($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}