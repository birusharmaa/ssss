<?php

namespace App\Controllers;

class Users extends BaseController
{   
    public function __construct(){
        helper('url');
        $session = \Config\Services::session();
        if(!$session->get('emp_id')){
            return view('admin/login/index');
        }
      
    }
    
    /**
     * 
     */

     public function settingPage()
     {
        $pageData = ['pageTitle'=>'XLAcademy Admin', 'pageHeading'=>'Setting'];
        return view('admin/dashboard/setting',$pageData);
     }

    //Check user login or not
    public function index(){
            return view('admin/dashboard/index');
    }

    //Logout function for session destroy
    public function logout(){
        session_destroy();
        return redirect()->to('/');
    }

    public function forgotPassword(){
        return view('admin/login/forgot-password');
    }



}
