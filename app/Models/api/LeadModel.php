<?php

namespace App\Models\api;

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
        $db = \Config\Database::connect();
        $builder = $db->table('xla_leads');
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

    public function search($search)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        // $users = $builder->like('Name', $search)->orLike('Mob_1', $search)->orLike('Email', $search)->get()->getResult();
        $users = $builder->like('Name', $search)->get(5)->getResult();
        return $users;
    }

    function getOneRow($data, $user)
    {
        $leaddata = false;
        $category = $data['Enq_Course'];
        $subcat = $data['subcategory'];
        $city = $data['City'];
        $from = $data['From'];
        $to = $data['To'];
        $where = '';
        $sql = "SELECT * from xla_leads where (lead_action_status ='1'  " . " AND Lead_Owner like('%$user%'))";
        $query =  $this->db->query($sql);
        $query = $query->getRow();

        if (isset($query->id)) {
            $where = '';
            $where .= " (lead_action_status ='1' " . " AND Lead_Owner like('%$user%'))";
        } else {
            $where = '';
            if ($category) {
                $where .= " Enq_Course ='$category'";
            }
            if ($subcat) {
                $where .= " AND subcategory ='$subcat'";
            }
            if ($city) {
                $where .= " AND City ='$city'";
            }
            if ($from) {
                $where .= " AND created_at >='$from'";
            }
            if ($to) {
                $where .= " AND created_at <='$to'";
            }
            // $where.= " AND lead_action_status ='0' AND Lead_Owner like('%$user%') "; 
            $where .= " AND lead_action_status ='0'";
        }
        $getOnelead = "SELECT *  from xla_leads  where $where ";
        
        $query =  $this->db->query($getOnelead);

        if($query->getResultArray() != ''){
             $leadData = $query->getRow();
            if($leadData){
                
            /**
            * Updating lead state if Views
            */
             $leadUpdateData['lead_action_status'] = 1;
             $leadUpdateData['Lead_Owner'] = $user;
             $res = $this->updateLeads($leadUpdateData, $leadData->id);
             }
            /**
             * Update end
             */
        }
        
        return $leadData;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function assignLeadsToUser($data = null)
    {
        $session = session();
        $emp = $session->get('loginInfo');
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set(['lead_action_status' => 2, 'Lead_Owner' => $emp['emp_id']]);
        $builder->where('id', $data['id']);
        $res = $builder->update();

        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    public function unsubscribeLead($leadId = null, $status=1)
    {
        try {
            $leadUpdateData['Unsubscribe'] = $status;
            return $this->updateLeads($leadUpdateData, $leadId);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
    }

    public function followupList($userid = null)
    {
        try {
            $consdition['lead_action_status'] = 2;
            $consdition['Unsubscribe'] = 0;
            $consdition['Lead_Owner'] = $userid;
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


    public function unSubscribeList($userid = null)
    {
        try {
            $consdition['Unsubscribe'] = 1;
            $consdition['Lead_Owner'] = $userid;
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

    public function importLeads($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('xla_leads');
        return $builder->insertBatch($data);
    }

    public function getFollowUpsLead($leadOwnderId = null)
    {
        $query = "SELECT *, xla_category.title as course_name from xla_leads 
        JOIN(SELECT DISTINCT(lead_id),created_at,call_status,comments FROM `xla_leads_comments`
        WHERE call_status=7 GROUP by lead_id ORDER BY created_at DESC) 
        lead_c ON (lead_c.lead_id  = xla_leads.id) 
        LEFT JOIN xla_category on xla_category.id=xla_leads.Course_Value 
        WHERE Lead_Owner=$leadOwnderId";
        $res =  $this->db->query($query);
        if ($res->getResultArray() > 0) {
            $finalData = $res->getResult('array');
            for ($i = 0; $i < count($finalData); $i++) {
                $leadId = $finalData[$i]['lead_id'];
                $q2 = "SELECT *  FROM `xla_leads_comments`
                    WHERE lead_id=$leadId AND ( SELECT max(created_at) FROM xla_leads_comments) 
                    ORDER by created_at DESC LIMIT 1;";
                $row = $this->db->query($q2);
                $d = $row->getRow();
                $finalData[$i]['comments'] = $d->comments;
            }
            return $finalData;
        } else {
            return false;
        }
    }
}
