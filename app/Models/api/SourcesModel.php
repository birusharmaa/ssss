<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class SourcesModel extends Model
{
    protected $table = 'xla_source';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title'];
    
    public function insertsource($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteLocation($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateLocation($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }
  
}