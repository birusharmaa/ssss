<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\TeamModel;


class Team extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
    }
    public function index()
    {
        $model = new TeamModel();
        $data = $model->getAllTeam();     
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function create()
    {
        $model = new TeamModel();
        $data = $this->request->getPost();    
        $rules = [
            "full_name" => "required",
            "designation" => "required",
            "personal_email" => "required|valid_email",
            "password" =>  "required|min_length[8]",
            "office_number" =>  "required|min_length[10]|max_length[10]",
            "personal_number" =>  "required|min_length[10]|max_length[10]",
            "gender" => "required",
        ];
        $messages = [
            "full_name" => [
                "required" => "Name is required."
            ],
            "designation" => [
                "required" => "Designation field is required."
            ],
            "personal_email" => [
                "required" => "Email is Required.",
                "valid_email" => "Email should be a valid Email."
            ],
            "password" => [
                "required" => "Password is required.",
                "min_length" => "Password must be 8 digit long."
            ],
            "office_number" => [
                "required" => "Office Number is required.",
                "min_length" => "Number Must be 10 digits long.",
                "max_length" => "Number Must be 10 digits long."

            ],
            "personal_number" => [
                "required" => "Personal Number is required.",
                "min_length" => "Number Must be 10 digits long.",
                "max_length" => "Number Must be 10 digits long."

            ],
            "gender" => [
                "required" => "Gender field is required"
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        } else {           
            $password = $this->request->getPost('password');
            $password  = password_hash($password, PASSWORD_DEFAULT);
            $data = array_merge($data, array('created_at' => date('y-m-d h:i:sa'), 'password' => $password));
            $model->insertTeam($data);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'User Created Successfully.'
                ]
            ];
            return $this->respond($response);
        }
    }
    // delete
    public function delete($id = null)
    {

        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();
        if ($data != '') {
            if ($model->deleteTeam($id)) {

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'User Successfully deleted.'
                    ]
                ];
                return $this->respond($response);
            } else {
                return $this->failNotFound('No Record found');
            }
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function Show($id = null)
    {

        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();
        if ($data != '') {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    // update 
    public function update($id = null)
    {
        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();
        $input = $this->request->getRawInput();       
        if ($data) {
            $rules = [
                "full_name" => "required",
                "designation" => "required",
                "personal_email" => "required|valid_email",             
                "office_number" =>  "required|min_length[10]|max_length[10]",
                "personal_number" =>  "required|min_length[10]|max_length[10]",
                "gender" => "required",
            ];
            $messages = [
                "full_name" => [
                    "required" => "Name is required."                   
                ],
                "designation" => [
                    "required" => "Designation field is required."
                ],
                "personal_email" => [
                    "required" => "Email is Required.",
                    "valid_email" => "Email should be a valid Email."
                ],
                "password" => [
                    "required" => "Password is required.",
                    "min_length" => "Password must be 8 digit long."
                ],
                "office_number" => [
                    "required" => "Office Number should be required.",
                    "min_length" => "Number Must be 10 digits long.",
                    "max_length" => "Number Must be 10 digits long."                  
                ],
                "personal_number" => [
                    "required" => "Personal Number should be required.",
                    "min_length" => "Number Must be 10 digits long.",
                    "max_length" => "Number Must be 10 digits long."                   
                ],
                "gender" => [
                    "required" => "Gender field is required"
                ]
            ];
            if (!$this->validate($rules, $messages)) {
                return $this->fail($this->validator->getErrors(), 400);
            } else {              
                $updateData = [
                    'full_name' => $input['full_name'],
                    'designation' => $input['designation'],
                    'personal_email' => $input['personal_email'],                   
                    'office_number' => $input['office_number'],
                    'personal_number' => $input['personal_number'],
                    'gender' => $input['gender'],
                    'address' => $input['address'],
                    'sys_name' => $input['sys_name'],
                    'account_name' => $input['account_name'],
                    'location' => $input['location'],
                    'key' => $input['key'],
                    'isAdmin' => $input['isAdmin']
                ];
                $model->updateTeam($updateData, $id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'User Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('Trying to access invlaid record.');
        }
    }

    public function insertImage($id = null)
    {
        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();      
        if ($data) {
            $file_name = rand() . $_FILES['picture_attachment']['name'];
            $filewithpath = base_url() . "/images/team/" . $file_name;
            $file = $this->request->getFile('picture_attachment');
            $file->move('./images/team', $file_name);
            $updateData = [
                'picture_attachment' => $filewithpath
            ];
            $model->updateTeam($updateData, $id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'User Profile Image Updated Successfully.'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('Trying to access invlaid record.');
        }
    }

    public function deleteImage($id = null){
        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();
        $filename = basename($data['picture_attachment']);
        $path = 'images/team/' . $filename;
        if ($data['picture_attachment']!="") {
            if (file_exists($path)) {
                unlink($path);
            }
            $updateData = [
                'picture_attachment' => ''
            ];
            $model->updateTeam($updateData, $id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Profile Image Removed Successfully.'
                ]
            ];
            return $this->respond($response);
        } 
    }

    public function passworChange($id= null){
        $password = $this->request->getPost('newPassword');
        $currentPassword = $this->request->getPost('currentPassword');
        $password  = password_hash($password, PASSWORD_DEFAULT);

        $model = new TeamModel();
        $data = $model->where('emp_id', $id)->first();       
        if ($data) {  
            if (password_verify($currentPassword, $data['password'])) {
                $updateData = [
                    'password' =>  $password
                ];
                $model->updateTeam($updateData, $id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Password Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
             } else{
                return $this->failUnauthorized('Invalid current password');
             }         
           
        } else{
            return $this->failNotFound('Trying to access invlaid record.');
        }
    }
}
