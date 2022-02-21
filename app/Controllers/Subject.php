<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\SubjectModel;

 
class Subject extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");     
        
    }    
      public function index(){                 
            $model = new SubjectModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){    
       
        $model = new SubjectModel();
        $data = $this->request->getPost();             
        $rules = [
            "subject_name" => "required"                
        ];
        $messages = [
            "subject_name" => [
            "required" => "Subject Name is required."          
        ]
       ];     
        if (!$this->validate($rules, $messages)) {      
        return $this->fail($this->validator->getErrors(), 400);

        } else {
            $data = array_merge($data, array('created_at' => date('y-m-d h:i:sa')));
            $model->insertSubject($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Subject Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }            
                  
    }
      // delete
    public function delete($id = null){

        $model = new SubjectModel();      
        $data = $model->where('id', $id)->first(); 
           if($data !=''){            
                if ($model->deleteSubject($id)) {
                                        
                    $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Subject Successfully deleted.'
                    ]
                    ];
                    return $this->respond($response);
                } else {
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'Subject No Deleted.'
                        ]
                        ];
                        return $this->respond($response);                   
                } 
           } else{
            return $this->failNotFound('No Record found');
           }     
       
    }     

    public function Show($id = null){

        $model = new SubjectModel();      
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
        $model = new SubjectModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();   
        
        if($data){ 
            $rules = [
                "subject_name" => "required"                
            ];
            $messages = [
                "subject_name" => [
                "required" => "Subject Name is required."          
            ]
           ];     
            if (!$this->validate($rules, $messages)) {                    
            return $this->fail($this->validator->getErrors(), 400);    
            } else {             
                $updateData = [
                    'subject_name' => $input['subject_name'],
                    'updated_by' => $input['created_by'],                  
                    'updated_at' => date('y-m-d h:i:sa')
                ];                
                $model->updateSubject($updateData,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Subject Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }                                    
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
       
    }
 
}