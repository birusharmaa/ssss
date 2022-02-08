<?php 

namespace App\Models\api;
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
    
    public function insertCategory($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteCategory($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateCategory($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}