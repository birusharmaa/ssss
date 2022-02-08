<?php 

namespace App\Models\api;
use CodeIgniter\Model;

class SubCategoryModel extends Model
{
    protected $table = 'xla_subcategory';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'title', 
      'status',
      'created_at',
      'updated_at',
      'cat_id'
    ];
    
    public function insertSubCategory($data) {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        return $builder->insert($data);
    }

    public function deleteSubCategory($id = null){
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function updateSubCategory($data, $id){        
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->set($data);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function getSubCat($id){
        $db = \Config\Database::connect();      
      
        $builder = $db->table('xla_subcategory');
        $builder->select('xla_subcategory.*, xla_category.title as CategoryName');       
        $builder->join('xla_category', 'xla_subcategory.cat_id = xla_category.id ');
        $builder->where('xla_subcategory.id', $id); 
        $query = $builder->get(); 
        return $query->getRow();
    }

    public function getSubCategories($id)
    {
      $builder =  $this->db->table($this->table);
      $builder->where(['status'=> true, 'cat_id'=>$id]);
      $result = $builder->get();
      if ($result->getResultArray() > 0) {
        return $result->getResult();
      } else {
        return false;
      }
    }
  
}