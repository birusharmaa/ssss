<?php

namespace App\Controllers;


class Users extends BaseController
{
    public function __construct()
    {
        $this->session = session();
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
    }

    //Logout function for session destroy
    public function logout()
    {
        session_destroy();
        return redirect()->to('/');
    }
    
    public function forgotPassword()
    {
        return view('admin/login/forgot-password');
    }

}
