<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\SystemModel;

 
class SystemDetials extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");     
        
    }    
      public function index(){                 
            $model = new SystemModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){    
       
        $model = new SystemModel();
        $rules = [
            "sys_name" => "required"                
        ];
        $messages = [
            "sys_name" => [
            "required" => "Name is required."          
        ]
       ];     
        if (!$this->validate($rules, $messages)) {      
        return $this->fail($this->validator->getErrors(), 400);

        } else {
                     
            $data = $this->request->getPost(); 
            $data = array_merge($data, array('created_at' => date('y-m-d h:i:sa')));        
            $model->insertSystem($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'System Name Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }            
                  
    }
      // delete
    public function delete($id = null){

        $model = new SystemModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteSystem($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'System Successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'System No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new SystemModel();      
        $data = $model->where('id', $id)->first(); 
        if($data !=''){ 
            return $this->respond($data);                    
        } else{
            return $this->failNotFound('No Record found');
        }   
    }

    // update 
    public function update($id = null)
    {            
        $model = new SystemModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();   
        
        if($data){ 
            $rules = [
                "sys_name" => "required"                
            ];
            $messages = [
                "sys_name" => [
                "required" => "System Name is required."          
            ]
           ];     
            if (!$this->validate($rules, $messages)) {                    
            return $this->fail($this->validator->getErrors(), 400);    
            } else {             
                $updateData = [
                    'sys_name' => $input['sys_name'], 
                    'updated_by'  => $input['created_by'],               
                    'updated_at' => date('y-m-d h:i:sa')
                ];                
                $model->updateSystem($updateData,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'System Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }                                    
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
       
    }
 
}