<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\CategoryModel;

 
class Category extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
    }    
      public function index(){
      
            $model = new CategoryModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->respond('No record found.');
            }
      }

    public function create(){
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
            if ( $this->validate([            
            'title' => 'required|min_length[3]'                       
        ])) {
            
            $model = new CategoryModel();              
            $data = $this->request->getPost();
            $model->insertCategory($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Category Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }else{
            return $this->failValidationErrors($validation->getErrors());   
        }
           
    }
      // delete
    public function delete($id = null){

        $model = new CategoryModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteCategory($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => ' Category Successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'Category No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new CategoryModel();      
        $data = $model->where('id', $id)->first(); 
        if($data !=''){ 
            return $this->respond($data);                    
        } else{
            return $this->failNotFound('No Record found');
        }   
    }

    // update product
    public function update($id = null)
    {
        $validation =  \Config\Services::validation();
        $model = new CategoryModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();

        if($data){        
            if ( $this->validate([            
            'title' => 'required|min_length[3]'                      
             ])) {
                $data = [
                    'title' => $input['title'],                                     
                    'updated_at' => date('y-m-d h:i:sa')
                ];
                $model->updateCategory($data,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Category Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
             }else{
                return $this->failValidationErrors($validation->getErrors());      
             }           
        }else{
            return $this->respond('trying to access invalid data.');
        }
       
    }
 
}