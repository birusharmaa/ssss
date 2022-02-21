<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'xla_users';
    protected $primaryKey = 'emp_id';
    protected $allowedFields = [
      'isAdmin', 
      'full_name',
      'designation',
      'personal_email',      
      'password',
      'office_number',
      'personal_number',
      'picture_attachment',
      'gender',
      'address',
      'sys_name',
      'account_name',
      'location',
      'key',
      'created_at'
    ];
    
    public function insertTeam($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteTeam($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('emp_id', $id);
        return $builder->delete();
    }

    public function updateTeam($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('emp_id', $id); 
        return $builder->update();
    }

    public function getAllTeam(){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('xla_users.*, xla_sys_det.sys_name, xla_account.account_name, xla_location.location_name');
        $builder->join('xla_sys_det','xla_users.sys_name = xla_sys_det.id');
        $builder->join('xla_account','xla_users.account_name = xla_account.id');
        $builder->join('xla_location','xla_users.location = xla_location.id');
        $query = $builder->get();
        return $query->getResult();
    }

    public function findTeam($id){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('xla_users.*, xla_sys_det.sys_name, xla_account.account_name, xla_location.location_name');
        $builder->join('xla_sys_det','xla_users.sys_name = xla_sys_det.id');
        $builder->join('xla_account','xla_users.account_name = xla_account.id');
        $builder->join('xla_location','xla_users.location = xla_location.id');
        $builder->where('emp_id', $id); 
        $query = $builder->get();
        return $query->getRow();
    }
  
}