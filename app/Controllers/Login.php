<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct(){
        helper('url');
    }


    public function index(){
        $apiModel = new UserModel();
        $data = $apiModel->orderBy('emp_id', 'DESC')->findAll();
        return $this->respond($data);        
    }

    //User login check
    public function login(){
        $data = [];

        //Check if request type is post
        if ($this->request->getMethod() == 'post'){
            
            //Add field rules
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];
            
            $messages = [
                "name" => [
                    "required" => "Name is required"
                ],
                "email" => [
                    "required" => "Email required",
                    "valid_email" => "Email address is not in format",
                    "is_unique" => "Email address already exists"
                ],
            ];
            
            //Get field value
            $email    = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            //Check field are empty or not
            if (empty($email) || empty($password)) {
                return view('index', [
                    "validation" => $this->validator,
                ]);
            }else{

                $model = new UserModel();
                $user = $model->where('personal_email', $email)->first();

                //Check email is exists or not
                if(!empty($user)){
                    
                    //password verify
                    if(password_verify($password, $user['password'])) {
                        
                        //Session declaration and store
                        $session = \Config\Services::session();
                        $newdata = [
                            "emp_id"            => $user['emp_id'],
                            'full_name'         => $user['full_name'],
                            'email'             => $user['personal_email'],
                            "designation"       => $user['designation'],
                            "office_number"     => $user['office_number'],
                            "personal_number"   => $user['personal_number'],
                            "picture_attachment"=> $user['picture_attachment'],
                            "account_name"      => $user['account_name'],
                            "location"          => $user['location'],
                            "key"               => $user['key'],
                            'logged_in'         => true
                            
                        ];
                        $session->set($newdata);

                        //Set success message
                        $data['status']  = "success";
                        $data['message'] = "Login successfully.";
                        return $this->respond($data); 
                    }else{
                        
                        //Set wrong password message
                        $data['status'] = "failed";
                        $data['message'] = "Authencation failed, wrong credential.";
                        return $this->respond($data); 
                    }
                }else{

                    //Email does not exists
                    $data['status'] = "failed";
                    $data['type'] = "email";
                    $data['message'] = "Your email id don't not exists.";
                    return $this->respond($data); 
                }
            }
        }
        return view('admin/login/index');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new UserModel();
        $data = [
            'full_name' => $this->request->getVar('fullName'),
            'designation'  => $this->request->getVar('designation'),
            'personal_email'  => $this->request->getVar('personalEmail'),
            'office_number'  => $this->request->getVar('officeNumber'),
            'personal_number'  => $this->request->getVar('personalumber'),
            'designation'  => $this->request->getVar('designation'),
            'designation'  => $this->request->getVar('designation'),
            'designation'  => $this->request->getVar('designation'),
            'designation'  => $this->request->getVar('designation'),
        ];
        echo "<pre>";
        print_r($data);
        exit;
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Employee created successfully'
            ]
        ];
        return $this->respondCreated($response);

    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
