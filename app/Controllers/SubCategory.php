<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\SubCategoryModel;

 
class SubCategory extends ResourceController
{
    use ResponseTrait;

    public function __construct(){
        date_default_timezone_set("Asia/Kolkata");
    } 
    
      public function index($id = null){      
            $model = new SubCategoryModel();
            $data = $model->where('cat_id' , $id)->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                $response = [
                    'status'   => 404,
                    'error'    => null,
                    'messages' => [
                        'success' => 'No SubCategory found'
                    ]
                    ];
                    return $this->respond($response);
               
            }
      }

    public function create(){
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
            if ( $this->validate([            
            'title' => 'required|min_length[3]',            
            'cat_id' => 'required|is_natural_no_zero'
        ])) {
            
            $model = new SubCategoryModel();              
            $data = $this->request->getPost();
            $model->insertSubCategory($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'SubCategory Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }else{           
            return $this->failValidationErrors($validation->getErrors());      
        }
           
    }
      // delete
    public function delete($id = null){
     
        $model = new SubCategoryModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteSubCategory($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'SubCategory successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    return $this->failNotFound('No Deleted');
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){
        $model = new SubCategoryModel();      
        //$data = $model->where('id', $id)->first();
        $data = $model->getSubCat($id); 
       
        if($data !=''){ 
            return $this->respond($data);                    
        } else{
            return $this->failNotFound('No Record found');
        }   
    }

    
    // update SubCategory
    public function update($id = null)
    {
        $validation =  \Config\Services::validation();
        $model = new SubCategoryModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();

        if($data){        
            if ( $this->validate([            
            'title' => 'required|min_length[3]',            
            'cat_id' => 'required|is_natural_no_zero'
             ])) {
                $data = [
                    'cat_id' => $input['cat_id'],
                    'title' => $input['title'],                    
                    'updated_at' => date('y-m-d h:i:a')
                ];
                $model->updateSubCategory($data,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Subcategory Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
             }else{
                return $this->failValidationErrors($validation->getErrors());                
             }           
        }else{
            $response = [
                'status'   => 404,
                'error'    => null,
                'messages' => [
                    'success' => 'trying to access invalid data.'
                ]
            ];
            return $this->respond($response);            
        }
       
    }
 
}