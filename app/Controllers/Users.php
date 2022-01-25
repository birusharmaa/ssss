<?php

namespace App\Controllers;
use App\Models\UserModel;


class Users extends BaseController
{   
    public function __construct(){
        helper('url');
    }

    //Check user login or not
    public function index(){
        $session = \Config\Services::session();
       
        if($session->get('emp_id')){
            $Model = new UserModel();
            $user = $Model->where(['isAdmin' => 0])->findAll();            
            echo view('admin/dashboard/index',array('user' => $user));
        }else{
            return view('admin/login/index');
        }
    }

    //Logout function for session destroy
    public function logout(){
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function forgotPassword(){
        return view('admin/login/forgot-password');
    }



}
?>