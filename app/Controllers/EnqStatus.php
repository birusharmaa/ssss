<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\EnqStatusModel;

 
class EnqStatus extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
       
    }    
      public function index(){
      
             $model = new EnqStatusModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){   
        $rules = [
            "title" => "required"                
        ];
        $messages = [
            "title" => [
            "required" => "Enquiry Title is required."          
        ]
       ];     
        if (!$this->validate($rules, $messages)) {      
        return $this->fail($this->validator->getErrors(), 400);

        } else {
            $model = new EnqStatusModel();              
            $data = $this->request->getPost();
            $model->insertEnqStatus($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Enquiry Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }            
                  
    }
      // delete
    public function delete($id = null){

        $model = new EnqStatusModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteEnqStatus($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Enquiry Successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'Enquiry No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new EnqStatusModel();      
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
        $model = new EnqStatusModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();
      
        if($data){ 
            $rules = [
                "title" => "required"                
            ];
            $messages = [
                "title" => [
                "required" => "Enquiry Name is required."          
            ]
           ];     
            if (!$this->validate($rules, $messages)) {      
            return $this->fail($this->validator->getErrors(), 400);    
            } else {              
                $updateData = [
                    'title' => $input['title'],
                    'description' => $input['description'],  
                    'update_at' => date('y-m-d h:i:sa')
                ];
                $model->updateEnqStatus($updateData,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Enquiry Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }              
                      
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
       
    }
 
}