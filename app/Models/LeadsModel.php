<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadsModel extends Model
{
  protected $table = 'xla_leads';
  protected $primaryKey = 'id';

  public function getAllLeads()
  {
    $builder = $this->db->table($this->table);
    $builder->select('xla_leads.id,xla_leads.Name,xla_leads.Email,xla_leads.Mob_1,xla_category.title as course,xla_leads.City');
    $builder->join('xla_category', 'xla_category.id = xla_leads.Enq_Course');
    $result  = $builder->get();
    if ($result->getResultArray() > 0) {
      return $result->getResult();
    } else {
      return false;
    }
  }

  public function getLeadDetails($id = null)
  {
    $builder = $this->db->table($this->table);
    $builder->select('xla_leads.*,xla_category.title');
    $builder->join('xla_category', 'xla_category.id = xla_leads.Enq_Course','left');
    $builder->where('xla_leads.id', $id);
    $result = $builder->get();
    if ($result->getResultArray() > 0) {
      return $result->getRow();
    } else {
      return false;
    }
  }

  public function getAllCity()
  {
    $db = \Config\Database::connect();
    $data = $db->query("SELECT DISTINCT City FROM `xla_leads` WHERE City <> ''
    ORDER BY `xla_leads`.`City` ASC")->getResult();
    if ($data) {
      return $data;
    }
    return false;
  }

  public function getleadsWhere($condition = null)
  {
    $builder = $this->db->table($this->table);
    $builder->where($condition);
    $result = $builder->get();
    if ($result->getResultArray() > 0) {
      return $result->getResult();
    } else {
      return false;
    }
  }

  public function getadmission()
  {
    $db = \Config\Database::connect();
    $sql = "SELECT DISTINCT xla_leads_comments.lead_id, xla_leads.*,xla_category.title as Category 
    FROM `xla_leads_comments` join xla_leads on xla_leads_comments.lead_id = xla_leads.id 
    join xla_category on xla_leads.Course_Value = xla_category.id WHERE call_status=9;";
    $data = $db->query($sql);
    return $data->getResult();
  }

  public function fee_Collect()
  {
    $db = \Config\Database::connect();
    $sql = 'SELECT DISTINCT xla_leads_comments.lead_id, xla_leads.* 
    FROM `xla_leads_comments` join xla_leads on xla_leads_comments.lead_id = xla_leads.id WHERE call_status=9';
    $data = $db->query($sql);
    return $data->getResult();
  }

  public function getLastComment($id = null)
  {
    $db = \Config\Database::connect();
    $sql = 'SELECT * FROM xla_leads_comments where lead_id=' . $id . ' ORDER BY id DESC LIMIT 1;';
    $data = $db->query($sql);
    return $data->getResult();
  }
}
