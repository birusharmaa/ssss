<?php

namespace App\Controllers;

class Users extends BaseController
{   
    public function __construct(){
        helper('url');
    }

    //Check user login or not
    public function index(){
        $session = \Config\Services::session();
        if($session->get('emp_id')){
            return view('admin/dashboard/index');
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

}
?>