<?php

namespace App\Models\api;

use CodeIgniter\Model;

class LeadlogsModel extends Model
{
    protected $table = 'xla_leads_comments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'lead_id',
        'call_type',
        'call_status',
        'subject',
        'comments',
        'followup_date',
        'followup_time',
        'created_at',
        'update_at',
        'status',
        'created_by'
    ];

    public function insertLogs($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function getAll($leadId= null)
    {
       
        try {
            
            $consdition['lead_id'] = $leadId;
            $builder = $this->db->table($this->table);
            $res = $builder->getWhere($consdition);
            if ($res->getResultArray()) {
                return $res->getResult();
            } else {
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
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
}
