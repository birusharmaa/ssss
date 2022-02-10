<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = 'xla_call_status';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'title', 
      'status',
      'description',
      'created_at',
      'update_at'
    ];
    
    public function insertStatus($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteStatus($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateStatus($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getAllStatus(){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('status', 1);
        $data =  $builder->get();
        if($data->getResult()){
            return $data->getResult();
        }else{
            return false;
        }      
       
    }
  
}