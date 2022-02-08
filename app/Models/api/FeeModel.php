<?php

namespace App\Models\api;

use CodeIgniter\Model;

class FeeModel extends Model
{
    protected $table = 'xla_fee';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'lead_id',
        'user_id',
        'paid_amount',
        'payment_mode',
        'paid_by',
        'remark',
        'status',
        'created_at',
        'updated_at'        
    ];

    public function insertFee($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteLeads($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateLeads($data, $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getAllComments($id){
        $db = \Config\Database::connect();
        $builder = $db->table('xla_leads_comments');
        $builder->select('*');
        $builder->where('lead_id', $id);
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
        
    }

    public function getPaidAmount($id){
        $db = \Config\Database::connect(); 
        $sql ='SELECT sum(paid_amount) as paid_amount FROM `xla_fee` WHERE lead_id='.$id.'';
        $data = $db->query($sql);
        return $data->getResultArray();        
    }

}