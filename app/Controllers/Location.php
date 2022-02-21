<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\LocationModel;

 
class Location extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");     
        
    }    
      public function index(){                 
            $model = new LocationModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){    
       
        $model = new LocationModel();
        $rules = [
            "location_name" => "required"                
        ];
        $messages = [
            "location_name" => [
            "required" => "Name is required."          
        ]
       ];     
        if (!$this->validate($rules, $messages)) {      
        return $this->fail($this->validator->getErrors(), 400);

        } else {
                     
            $data = $this->request->getPost(); 
            $data = array_merge($data,array('created_at'=> date('y-m-d h:i:sa')));         
            $model->insertLocation($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Location Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }            
                  
    }
      // delete
    public function delete($id = null){

        $model = new LocationModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteLocation($id)) {
                                        
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
                            'success' => 'Location No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new LocationModel();      
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
        $model = new LocationModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();   
        
        if($data){ 
            $rules = [
                "location_name" => "required"                
            ];
            $messages = [
                "location_name" => [
                "required" => "Location Name is required."          
            ]
           ];     
            if (!$this->validate($rules, $messages)) {                    
            return $this->fail($this->validator->getErrors(), 400);    
            } else {        
                                 
                $updateData = [
                    'location_name' => $input['location_name'],
                    'updated_by' => $input['created_by'],                  
                    'updated_at' => date('y-m-d h:i:sa')
                ];
                
                $model->updateLocation($updateData,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Location Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }              
                      
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
       
    }
 
}