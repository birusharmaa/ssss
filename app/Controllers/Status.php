<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\StatusModel;

 
class Status extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
    }    
      public function index(){
      
            $model = new StatusModel();
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
                   
            $model = new StatusModel();              
            $data = $this->request->getPost();
            $model->insertStatus($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Status Added Successfully.'
            ]
            ];
            return $this->respond($response);
                  
    }
      // delete
    public function delete($id = null){

        $model = new StatusModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteStatus($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => ' Status Successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'Status No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new StatusModel();      
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
        $model = new StatusModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();

        if($data){ 
                $data = [
                    'title' => $input['title'], 
                    'description' => $input['description'], 
                    'created_by' => $input['created_by'],                                      
                    'update_at' => date('y-m-d h:i:sa')
                ];
                $model->updateStatus($data,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Status Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
                      
        }else{
            return $this->respond('trying to access invalid data.');
        }
       
    }
 
}