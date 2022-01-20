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

    public function __construct()
    {
        helper('url', 'session');
    }


    public function index(){

        $apiModel = new UserModel();
        $data = $apiModel->orderBy('emp_id', 'DESC')->findAll();
        return $this->respond($data);        
    }

    public function login(){
        $data = [];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Email or Password don't match",
                ],
            ];
            
            $email    = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            
            if (empty($email) || empty($password)) {
                return view('index', [
                    "validation" => $this->validator,
                ]);
            }else{
                $model = new UserModel();
                $user = $model->where('personal_email', $email)->first();
                
                if(!empty($user)){
                    if(!password_verify($password, $user['password'])) {
                        $this->setUserSession($user);
                        //Redirecting to dashboard after login
                        $data['status']  = "success";
                        $data['message'] = "Login successfully.";
                        return $this->respond($data); 
                    }else{
                        $data['status'] = "failed";
                        $data['message'] = "Authencation failed, wrong credential.";
                        return $this->respond($data); 
                    }
                }else{
                    $data['status'] = "failed";
                    $data['type'] = "email";
                    $data['message'] = "Your email id don't not exists.";
                    return $this->respond($data); 
                }
            }
        }
        return view('index');
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
