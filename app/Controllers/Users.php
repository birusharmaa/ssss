<?php

namespace App\Controllers;
use App\Models\DashboardModel;

class Users extends BaseController
{
    public function __construct()
    {
        helper('url');
        $session = \Config\Services::session();
        if (!$session->get('emp_id')) {
            return view('admin/login/index');
        }
    }

    //Check user login or not
    public function index()
    {
        $userData = new DashboardModel();
        $pageData['users'] = $userData->allusers();
        $pageData['dashboardData'] = $userData->dashboardData();
        return view('admin/dashboard/index', $pageData);
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
