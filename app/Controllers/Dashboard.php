<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper('url');
        $session = \Config\Services::session();
        if (!$session->get('emp_id')) {
            return view('admin/login/index');
        }
    }

    /**
     * Function is used to load dashboard page view
     *
     * @return array
     */
    public function index()
    {
        $userData = new DashboardModel();
        $pageData['users'] = $userData->allusers();
        $pageData['dashboardData'] = $userData->dashboardData();
        return view('admin/dashboard/index', $pageData);
    }
    /**
     *  Function is used to load setting page view
     *
     * @return array
     */
    public function settingPage()
    {
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Settings'];
        $model = new SettingModel();
        $pageData['settingData'] = $model->get()->getResult('array');
        return view('admin/dashboard/Websettings/index', $pageData);
    }

    Public function search()
    {   
        return view('admin/dashboard/index');
        
    }
}
