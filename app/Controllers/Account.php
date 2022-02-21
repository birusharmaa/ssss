<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\AccountModel;

 
class Account extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
    }    
      public function index(){
      
            $model = new AccountModel();
            $data = $model->findAll();          
            if ($data) {            
                return $this->respond($data);
            } else {
                return $this->failNotFound('No Record found');
            }
      }

    public function create(){    

        $rules = [
            "account_name" => "required"                
        ];
        $messages = [
            "account_name" => [
            "required" => "Account Name is required."          
            ]
       ];     
      
        if (!$this->validate($rules, $messages)) {      
            return $this->fail($this->validator->getErrors(), 400);

        } else {
            $model = new AccountModel();              
            $data = $this->request->getPost();

            $model->insertAccount($data);
            $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Account Added Successfully.'
            ]
            ];
            return $this->respond($response);
        }            
                  
    }
    
    // delete account
    public function delete($id = null){
        $model = new AccountModel();      
        $data = $model->where('id', $id)->first(); 
        if($data !=''){            
            if ($model->deleteAccount($id)) {              
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => ' Account Successfully deleted.'
                    ]
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status'   => 404,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Account No Deleted.'
                    ]
                ];
                return $this->respond($response);                   
            } 
        }else{
            return $this->failNotFound('No Record found');
        }     
    }     

    public function show($id = null){
        $model = new AccountModel();      
        $data = $model->where('id', $id)->first(); 
        if($data !=''){ 
            return $this->respond($data);                    
        } else{
            return $this->failNotFound('No Record found');
        }   
    }

    // update account
    public function update($id = null){     
        $model = new AccountModel();
        $data = $model->where('id', $id)->first(); 
        $input = $this->request->getRawInput();
      
        if($data){ 
            $rules = [
                "account_name" => "required"                
            ];
            $messages = [
                "account_name" => [
                    "required" => "Account Name is required."          
                ]
            ];     
            if (!$this->validate($rules, $messages)) {      
                return $this->fail($this->validator->getErrors(), 400);    
            } else {              
                $updateData = [
                    'account_name' => $input['account_name'],                     
                    'updated_by' => $input['updated_by'],                                      
                    'updated_at' => date('y-m-d h:i:sa')
                ];
                $model->updateAccount($updateData,$id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Account Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }              
                      
        }else{            
            return $this->failNotFound('Trying to access invlaid record.');       
        }
    }
 
}