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
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
    }

    public function index()
    {
        $data = $this->session->get('loginInfo');
        $userModel = new UserModel();
        $pageData['user'] = $userModel->where('emp_id', $data['emp_id'])->first();
        return view('admin/dashboard/Settings/index', $pageData);
    }
}
