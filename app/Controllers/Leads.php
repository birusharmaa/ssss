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

    public function index()
    {   
        return view('admin/leads/index');
    }


    public function view()
    {   
        return view('admin/leads/view');
    
    }
}




?>