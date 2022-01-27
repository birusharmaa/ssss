<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UserModel;

class Settings extends BaseController
{

    protected $session;
    public function __construct()
    {
       $this->session = session();
    }

    public function index()
    {
        $empid = $this->session->get('emp_id');
        $userModel = new UserModel();
        $pageData['user'] = $userModel->where('emp_id',$empid)->first(); 
        return view('admin/dashboard/Settings/index',$pageData);
    }
}
