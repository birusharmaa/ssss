<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\SourcesModel;

 
class Sources extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");     
        
    }    
      public function index(){                 
            $model = new SourcesModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){    
       
        $this->model = new SourcesModel();
        $rules = [
            "sources_name" => "required",                
        ];
        $messages = [
            "source_name" => [
            "required" => "source name is required."          
        ]
       ];     
        if (!$this->validate($rules, $messages)) {      
            return $this->fail($this->validator->getErrors(), 400);

        } else {
            $data = [
                "title"     => $this->request->getPost('sources_name'),
                'created_at'=> date('y-m-d h:i:sa'),
            ];
            
            $this->model->insert($data);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                        'success' => 'source Added Successfully.'
                    ]
            ];
            return $this->respond($response);
        }            
                  
    }
      // delete
    public function delete($id = null){

        $model = new SourcesModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->delete($id)) {
                                        
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
                            'success' => 'source No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new SourcesModel();      
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
        $model = new SourcesModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();   
        
        if($data){ 
            $rules = [
                "sources_name" => "required"                
            ];
            $messages = [
                "sources_name" => [
                "required" => "source Name is required."          
            ]
           ];     
            if (!$this->validate($rules, $messages)) {                    
            return $this->fail($this->validator->getErrors(), 400);    
            } else {        
                                 
                $updateData = [
                    'title'  => $input['sources_name'],
                    'updated_by' => $input['created_by'],                  
                    'updated_at' => date('y-m-d h:i:sa')
                ];
                
                $model->update($id, $updateData);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'source Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }              
                      
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
       
    }
 
}