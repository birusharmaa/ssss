<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'xla_location';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'location_name', 
      'created_at',
      'updated_at',
      'created_by',      
      'updated_by',
      'status'
    ];
    
    public function insertLocation($data) {
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