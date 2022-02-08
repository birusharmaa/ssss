<?php

namespace App\Models\api;

use CodeIgniter\Model;

class SourceModel extends Model
{
    protected $table = 'xla_source';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'created_at',
        'update_at',
        'status',
    ];

    public function getAll($leadId= null)
    {
        try {
            $consdition['status'] = 1;
            $consdition['id'] = $leadId;
            $builder = $this->db->table($this->table);
            $res = $builder->getWhere($consdition);
            if ($res->getResultArray()) {
                return $res->getRow();
            } else {
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
    }

    

   
}
