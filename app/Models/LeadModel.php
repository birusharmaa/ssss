<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table = 'xla_leads';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'Sys_Name',
        'User_Name',
        'Data_Entry',
        'Enq_Dt',
        'Name',
        'City',
        'Location',
        'Mob_1',
        'mob_2',
        'Email',
        'Follow_Up_Dt',
        'Lead_Owner',
        'Source',
        'Enq_Course',
        'Key_Comment',
        'Follow_Up_Comment',
        'Status_value',
        'FollowUp_Days',
        'FollouUp_Counts',
        'Unsubscribe',
        'Photo',
        'Course_Value',
        'Last_Updated_By',
        'status',
        'created_at'
    ];

    public function insertLeads($data)
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('xla_leads');
            $builder->insert($data);
        } catch (\Exception $e) {
            die($e->getMessage());
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
