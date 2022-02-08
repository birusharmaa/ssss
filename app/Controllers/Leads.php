<?php

namespace App\COntrollers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LeadsModel;
use App\Controllers\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;

class Leads extends BaseController
{

    protected $leadModel;
    public function __construct()
    {
        $this->leadModel = new LeadsModel();
        $this->session = session();
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
    }

    public function index()
    {
        $pageData['leads'] = $this->leadModel->getAllLeads();
        return view('admin/leads/index', $pageData);
    }

    public function view($id = null)
    {
        $pageData['leads'] = $this->leadModel->getLeadDetails($id);
        return view('admin/leads/view');
    }
}
