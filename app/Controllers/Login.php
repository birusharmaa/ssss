<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

use App\Controllers\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function __construct(){
        helper('url', 'cookie');
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
            $remember = "";
            $remember = $this->request->getVar('remember');
            
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

                        if($remember=="on"){
                            $time = time();

                            //One year time
                            $time = $time+31536000;

                        }

                        //Set success message
                        $data['status']  = "success";
                        $data['message'] = "Login successfully.";
                        return $this->respond($data); 
                    }else{
                        //Set wrong password message
                        $data['status'] = "failed";
                        $data['message'] = "Authencation failed, wrong credential.";
                        return $this->fail($data); 
                    }
                }else{

                    //Email does not exists
                    $data['status'] = "failed";
                    $data['type'] = "email";
                    $data['message'] = "Your email id don't not exists.";
                    return $this->fail($data); 
                }
            }
        }
        return view('admin/login/index');
    }

    public function resetPassword(){

        if ($this->request->getMethod() == 'post'){
            //Add field rules
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
            ];
            
            $messages = [
                "email" => [
                    "required" => "Email required",
                    "valid_email" => "Email address is not in format",
                    "is_unique" => "Email address already exists"
                ],
            ];
            
            //Get field value
            $email    = $this->request->getVar('email');

            //Check field are empty or not
            if (empty($email)) {
                return view('index', [
                    "validation" => $this->validator,
                ]);
            }else{

                $model = new UserModel();
                $user = $model->where('personal_email', $email)->first();

                //Check email is exists or not
                if(!empty($user)){
                    $random_number      = rand(999999999,9999999999);
                    $random_number      = md5($random_number);

                    $mail = new PHPMailer(true);  
                    try {    
                        $mail->isSMTP();  
                        $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
                        $mail->SMTPAuth     = true;     
                        $mail->Username     = 'urjasofttest@gmail.com';  
                        $mail->Password     = 'Urja@1234';
                        $mail->SMTPSecure   = 'tls';  
                        $mail->Port         = 587;  
                        $mail->Subject      = "Forgot password link.";

                        $mail_message = 'Dear '.$user['full_name'].','. "\r\n";
                        $mail_message.='<br/>To reset your password, please click the following'."\r\n";
                        $mail_message.='<br/><a href="'.base_url().'/Login/changePassword/'.$random_number.'" style="margin-top:30px;margin-botton:30px;font-size:16px;line-height:20px;font-weight:700;color:#ffffff;background-color:#f49b28;font-style:normal;text-decoration:none;letter-spacing:0px;padding:15px 35px 15px 35px;display:inline-block" target="_blank">
                            <span align="center">RESET PASSWORD</span>
                        </a>';
                        $mail_message.='<br/><br/>Thanks & Regards';
                        $mail_message.='<br>Your company name';
                        $mail->Body         = $mail_message;
                        $mail->setFrom('urjasofttest@gmail.com', 'Demo User');
                        
                        $mail->addAddress($email);  
                        $mail->isHTML(true);
                        if(!$mail->send()) {
                            $data['status'] = "failed";
                            $data['message'] = "Something went wrong. Please try again.";
                            return $this->fail($data);
                        }
                        else {
                            $apiModel = new UserModel();
                            // $apiModel->where('personal_email', $email)->first();
                            // $apiModel->update('key', $random_number);
                            $apiModel->where('personal_email', $email)->set('key', $random_number)->update();

                            $data['status'] = "success";
                            $data['message'] = "We have sent you email for reset your password! Please check your email.";
                            return $this->respond($data);
                        }
                    }catch(Exception $e) {
                        $data['status'] = "failed";
                        $data['type'] = "email";
                        $data['message'] = "Your email id don't not exists.";
                        //echo json_encode($data);
                        return $this->fail($data);
                    }
                    
                }else{

                    //Email does not exists
                    $data['status'] = "failed";
                    $data['type'] = "email";
                    $data['message'] = "Your email id don't not exists.";
                    //echo json_encode($data);
                    return $this->fail($data); 
                }
            }
        }
        return view('admin/login/forgot-password');
    }

    public function changePassword($token = null){
        if(empty($token)){
            return redirect()->to('/');
        }else{
            $model = new UserModel();
            $user = $model->where('key', $token)->first();
            //Check email is exists or not
            if(!empty($user)){
                $session = \Config\Services::session();
                $newdata = [
                    "change-password" => "Yes",
                    "token"           => $token,
                    "id"              => $user['emp_id']
                ];
                $session->set($newdata);
                return redirect()->to('/change-password');
            }else{
                return redirect()->to('/');
            }
        }
    }

    public function passwordChange($t = null){
        $session = \Config\Services::session();
        if($session->get('change-password')=="Yes"){
            $token = $session->get('token');
            return view('admin/login/change-password');
        }else{
            $session->remove('change-password');
            $session->remove('token');
            return redirect()->to('/');
        }
    }

    public function savePassword(){
        if ($this->request->getMethod() == 'post'){

            $rules = [
                'password' => 'required|min_length[5]|max_length[255]|validateUser[password]',
                'confPassword' => 'required|min_length[5]|max_length[255]|validateUser[confPassword]',
            ];
            
            $messages = [
                "email" => [
                    "required" => "Email required",
                    "valid_email" => "Email address is not in format",
                ],
            ];
            
            //Get field value
            $conf_password    = $this->request->getVar('confPassword');
            $password         = $this->request->getVar('password');


            //Check field are empty or not
            if (empty($conf_password) || empty($password)) {
                return view('index', [
                    "validation" => $this->validator,
                ]);
            }else{
                $session = \Config\Services::session();
                $token = "";
                if($session->get('change-password')=="Yes"){
                    $token = $session->get('token');

                    $model = new UserModel();
                    $user = $model->where('key', $token)->first();

                    //Check email is exists or not                    
                    if(!empty($user)){
                        $session->remove("change-password");
                        //Set success message
                        $encrypt_password = password_hash($password, PASSWORD_DEFAULT);
                        $key  = $model->where('emp_id', $user['emp_id'])->set('key', '')->update();
                        $pass = $model->where('emp_id', $user['emp_id'])->set('password', $encrypt_password)->update();
                        
                        $data['status']  = "success";
                        $data['message'] = "Password updated successfully.";
                        return $this->respond($data); 
                    }else{
                        //Set wrong password message
                        $data['status'] = "failed";
                        $data['message'] = "Password update unsuccessfully.";
                        return $this->fail($data); 
                    }
                }else{

                    //Email does not exists
                    $data['status'] = "failed";
                    $data['message'] = "You already updated your password.";
                    return $this->fail($data); 
                }
            }
        }
        return view('admin/login/change-password');
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
