<?php

namespace App\COntrollers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LeadsModel;
use App\Models\api\LeadModel;
use App\Controllers\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;
use App\Models\api\EnqStatusModel;
use App\Models\UserModel;
use App\Models\api\SourceModel;
use App\Models\api\CategoryModel;
use App\Models\api\LeadsCommentsModal;

class Enquiry extends BaseController
{
    use ResponseTrait;
    protected $leadModel;
    public function __construct(){
        $this->request = service('request');
        $this->leadModel = new LeadsModel();
        $this->_leadModel = new LeadModel();
        $this->validation =  \Config\Services::validation();

        $this->session = session();
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
        
    }

    //Load index with defaults data
    public function index(){
        $pageData['pageTitle'] = "Enquiry";
        $pageData['pageHeading'] = "Leads Enquiry";
        $pageData['username'] = "username";

        //Select enqstatusmodel table data;
        $this->enqStatusModel = new EnqStatusModel();
        $this->enqStatusModel->select(['id', 'title']);
        $pageData['enqStatus'] = $this->enqStatusModel->findAll();

        //Select users table data;
        $this->userModel = new UserModel();
        $this->userModel->select(['emp_id', 'full_name']);
        $pageData['usersData'] = $this->userModel->findAll();

        //Select source table data;
        $this->sourceModel = new SourceModel();
        $this->sourceModel->select(['id', 'title']);
        $pageData['sourceModel'] = $this->sourceModel->findAll();

        //Select phone number first;
        $pageData['allFirstMobiles'] = Array();
        $this->leadModel = new leadModel();
        $this->leadModel->select('Mob_1');
        $pageData['allFirstMobiles'] = $this->leadModel->findAll();

        //Select email address from lead email field;
        $pageData['allEmails'] = Array();
        $this->leadModel = new leadModel();
        $this->leadModel->select('Email');
        $pageData['allEmails'] = $this->leadModel->findAll();

        //Select all course or category data
        $this->categoryModel = new CategoryModel();
        $this->categoryModel->select(['id', 'title']);
        $pageData['courseName'] = $this->categoryModel->findAll();

        // $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        // $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        // $this->leadModel->select('xla_users.full_name AS owner_name');
        // $this->leadModel->select('xla_source.title AS source_name');
        
        //Count current month leads
        $this->leadModel->selectCount('id');
        $this->leadModel->where('MONTH(created_at)', date('m'));
        $this->leadModel->where('YEAR(created_at)', date('Y'));
        $pageData['current_month_count'] = $this->leadModel->findAll();

        //Count previous month leads
        $this->leadModel->selectCount('id');
        $this->leadModel->where('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)');
        $pageData['last_month_count'] = $this->leadModel->findAll();

        //Count current month open leads
        $this->leadModel->selectCount('id');
        //$this->leadModel->where('lead_action_status', 0);
        $this->leadModel->where('MONTH(created_at)', date('m'));
        $this->leadModel->where('YEAR(created_at)', date('Y'));
        $this->leadModel->where('MONTH(updated_at)', null);
        $this->leadModel->where('YEAR(updated_at)', null);
        $pageData['open_leads'] = $this->leadModel->findAll();
        // echo $this->leadModel->getLastQuery();
        // echo "<pre>";
        // print_r($pageData['open_leads']);
        // exit;

        //Count previous month open leads
        $this->leadModel->selectCount('id');
        //$this->leadModel->where('lead_action_status !=', 0);
        $this->leadModel->where('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('MONTH(updated_at)', null);
        $this->leadModel->where('MONTH(updated_at)', null);
        //$this->leadModel->where('MONTH(updated_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        //$this->leadModel->where('MONTH(updated_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $pageData['last_open_leads'] = $this->leadModel->findAll();

        //Count current month current leads
        $this->leadModel->selectCount('id');
        //$this->leadModel->where('lead_action_status !=', 0);
        // $this->leadModel->where('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        // $this->leadModel->where('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('MONTH(updated_at)', date('m'));
        $this->leadModel->where('YEAR(updated_at)', date('Y'));
        $pageData['current_leads'] = $this->leadModel->findAll();

        //Count previous month current leads
        $this->leadModel->selectCount('id');
        //$this->leadModel->where('lead_action_status !=', 0);
        // $this->leadModel->where('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        // $this->leadModel->where('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('MONTH(updated_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $this->leadModel->where('YEAR(updated_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)');
        $pageData['last_leads'] = $this->leadModel->findAll();
       

        $this->leadModel->selectSum('xla_leads.Course_Value');
        $pageData['leads_sum'] = $this->leadModel->findAll();

        $this->enqStatusModel = new EnqStatusModel();
        $pageData['enqStatus'] = $this->enqStatusModel->findAll();


        $lead_comment_model = new LeadsCommentsModal();
        $lead_comment_model->join('xla_users', 'xla_users.emp_id = xla_leads_comments.created_by', 'LEFT');
        $lead_comment_model->select('xla_users.full_name');
        $lead_comment_model->select('xla_leads_comments.created_at AS fallow_comments_time, xla_leads_comments.comments');
        $lead_comment_model->orderBy('xla_leads_comments.id','ASC');            
        $pageData['follow_comment'] = $lead_comment_model->findAll(5);

        return view('admin/enquiry/index', $pageData);
    }

    public function view($id = null){
        $pageData['leads'] = $this->leadModel->getLeadDetails($id);
        return view('admin/leads/view');
    }

    //Get leads table data with join
    public function getAllLeads(){
        
        $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        $this->leadModel->select('xla_users.full_name AS owner_name');
        $this->leadModel->select('xla_source.title AS source_name');
        $this->leadModel->select('xla_leads.*');

        $data = $this->leadModel->findAll();   
        
        if($data) {            
            return $this->respond($data);
        }else{
            return $this->respond('No record found.');
        }
    }

    //Fetch particular user data
    public function show($id=null){

        $this->leadModel->join('xla_enq_status', 'xla_enq_status.id = xla_leads.status', 'LEFT');
        $this->leadModel->select('xla_enq_status.title AS status_name');
        $this->leadModel->select('xla_leads.id,xla_leads.status, xla_leads.Unsubscribe, xla_leads.FollouUp_Counts,xla_leads.name, xla_leads.Enq_Dt, xla_leads.Follow_Up_Dt');
        $data['data'] = $this->leadModel->find($id);

        //Fallow comments
        
        $lead_comment_model = new LeadsCommentsModal();
        $lead_comment_model->join('xla_users', 'xla_users.emp_id = xla_leads_comments.created_by', 'LEFT');
        $lead_comment_model->select('xla_users.full_name');
        $lead_comment_model->select('xla_leads_comments.created_at AS fallow_comments_time, xla_leads_comments.comments');
        $lead_comment_model->orderBy('xla_leads_comments.id','DESC');            
        $data['follow_comment'] = $lead_comment_model->where('lead_id',$id)->findAll(5);

        if($data) {            
            return $this->respond($data);
        } else {
            return $this->respond('');
        }
    }

    //Get filter data 
    public function fetchData($request = null){

        $enq_status  =  $this->request->getPost('enqStatus');
        $owner_id    =  $this->request->getPost('ownerId');
        $source_id   =  $this->request->getPost('sourceId');
        $follow_up   =  $this->request->getPost('followUp');
        $enq_date    =  $this->request->getPost('enqDate');
        $follow_date =  $this->request->getPost('followUpDate');
        $location    =  $this->request->getPost('location');
        $city        =  $this->request->getPost('city');

        //Current month leads count
        $where_condition = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> date('m'),
                'YEAR(xla_leads.created_at)'=> date('Y')
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }

        $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        $this->leadModel->select('xla_users.full_name AS owner_name');
        $this->leadModel->select('xla_source.title AS source_name');
        $this->leadModel->select('xla_leads.*');
        $data['details'] = $this->leadModel->where($where_condition)->findAll();
        $this->leadModel->selectCount('id');
        $data['total_leads'] = $this->leadModel->where($where_condition)->findAll();

        //Last month total leads count
        $where_condition = array();
        $where = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> (int) date('m', strtotime('-1 months')),
                'YEAR(xla_leads.created_at)'=> (int) date('Y', strtotime('-1 months'))
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        $this->leadModel->selectCount('id');
        $data['total_leads_last_month'] = $this->leadModel->where($where_condition)->findAll();


        //open lead counts data
        $where_condition = array();
        // $static = ['1', '2', '3', '4'];
        //$where_condition = array_merge($where_condition,$where);
        $where = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> date('m'),
                'YEAR(xla_leads.created_at)'=> date('Y'),
                // 'MONTH(updated_at)' => date('m'),
                // 'YEAR(updated_at)' => date('Y')
                'MONTH(updated_at)' => null,
                'YEAR(updated_at)' => null
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        
        $this->leadModel->selectCount('id');
        $data['open_leads'] = $this->leadModel
                                            ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
                                            ->findAll();


        //last month open lead counts
        $where_condition = array();
        //$static = ['1', '2', '3', '4'];
        //$where_condition = array_merge($where_condition,$where);
        $where = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> (int) date('m', strtotime('-1 months')),
                'YEAR(xla_leads.created_at)'=> (int) date('Y', strtotime('-1 months')),
                // 'MONTH(updated_at)' => (int) date('m', strtotime('-2 months')),
                // 'YEAR(updated_at)' => (int) date('Y', strtotime('-2 months'))
                'MONTH(updated_at)' => null,
                'YEAR(updated_at)' => null
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        $this->leadModel->selectCount('id');
        $data['open_leads_last_month'] = $this->leadModel
                                            ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
                                            ->findAll();


        //current lead counts data
        $where_condition = array();
        $static = ['1', '2', '3', '4'];
        $where = array();
        //$where_condition = array_merge($where_condition,$where);
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                //'MONTH(xla_leads.created_at)'=> (int) date('m', strtotime('-1 months')),
                //'YEAR(xla_leads.created_at)'=> (int) date('Y', strtotime('-1 months')),
                'MONTH(updated_at)' => date('m'),
                'YEAR(updated_at)' => date('Y')
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        
        
        $this->leadModel->selectCount('id');
        $data['current_leads'] = $this->leadModel
                                            ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
                                            ->findAll();
                                            // echo "<pre>";
                                            // print_r($where_condition);
                                            // echo $this->leadModel->getLastQuery();
                                            // exit;

        //last month current lead counts
        $where_condition = array();
        $static = ['1', '2', '3', '4'];
        //$where_condition = array_merge($where_condition,$where);
        $where = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                // 'MONTH(xla_leads.created_at)'=> (int) date('m', strtotime('-1 months')),
                // 'YEAR(xla_leads.created_at)'=> (int) date('Y', strtotime('-1 months')),
                'MONTH(updated_at)' => (int) date('m', strtotime('-1 months')),
                'YEAR(updated_at)' => (int) date('Y', strtotime('-1 months'))
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        $this->leadModel->selectCount('id');
        $data['current_leads_last_month'] = $this->leadModel
                                            ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
                                            ->findAll();

        //Return data for view page
        if($data) {            
            return $this->respond($data);
        } else {
            return $this->respond($data, false);
        }
    }

    //Save comments details
    public function saveComment(){
        $session     = session();
        $validation =  \Config\Services::validation();

        $lead_id     =  $this->request->getPost('loadId');
        $comments    =  $this->request->getPost('comments');
        $created_by  =  $session->get('loginInfo')['emp_id'];
        
        if ($this->validate([
            'loadId' => 'required',
            'comments' => 'required',
        ])){
            $data = array(
                "lead_id"    => $lead_id,
                "comments"   => $comments,
                "created_by" => $created_by
            );

            $lead_comment_model = new LeadsCommentsModal();
            if($lead_comment_model->insert($data)){
                $lead_comment_model->join('xla_users', 'xla_users.emp_id = xla_leads_comments.created_by', 'LEFT');
                $lead_comment_model->select('xla_users.full_name');
                $lead_comment_model->select('xla_leads_comments.created_at AS fallow_comments_time, xla_leads_comments.comments');
                $lead_comment_model->orderBy('xla_leads_comments.id','DESC');            
                $data['follow_comment'] = $lead_comment_model->where('lead_id',$lead_id)->findAll(5);
                return $this->respond($data);
            }else{
                return $this->fail($data);
            }
        } else {
            return $this->fail($validation->getErrors());
        }
    }

    //Update user details data
    public function updateUserDetails(){
        $validation =  \Config\Services::validation();
        $session        = session();
        $lead_id        = $this->request->getPost('loadId');
        $user_name      = $this->request->getPost('userName');
        $user_status    = $this->request->getPost('userStatus');
        $user_fallow    = $this->request->getPost('userFallow');
        $user_last_call = $this->request->getPost('userLastCall');
        $user_next_call = $this->request->getPost('userNextCall');
        $unsubscribe    = $this->request->getPost('unsubscribe');
        if ($this->validate([
            'loadId' => 'required',
            'userName' => 'required',
            'userStatus' => 'required',
            'userFallow' => 'required',
            'userLastCall' => 'required',
            'userNextCall' => 'required',
        ])){
            $user = $this->leadModel->find($lead_id);
            if($user){
                $data = [
                    'Enq_Dt' => $user_last_call,
                    'Follow_Up_Dt'    => $user_next_call,
                    "FollouUp_Counts" => $user_fallow,
                    "Unsubscribe"=> $unsubscribe,
                    "status"=> $user_status,
                    "Name"=> $user_name
                ];
                $this->leadModel->update($lead_id, $data);
                $result = array("status" => 1, 'message' => "User details updated successfully.");
                return $this->respond($result);
            }else{
                $result = ["message"=>"No record found."];
                return $this->fail($result);
            }
        } else {
            return $this->fail($validation->getErrors());
        }
    }


    public function insertLead(){

        
        $photo= $this->request->getFile('photo');
        $new_name = "";
        if($photo->isValid()){
            $new_name = $photo->getRandomName();
            $photo->move('uploads', $new_name);
        }
       
        $this->validation->setRules([
            'sysName'         => ['label' => 'system name', 'rules' => 'required'],
            'leadUserName'    => ['label' => 'user name', 'rules' => 'required'],
            'name'            => 'required',
            'email'           => 'required|valid_email',
            'mob_1'           => ['label' => 'mobile 1', 'rules' => 'required'],
            'mob_2'           => ['label' => 'mobile 2', 'rules' => 'required'],
            'leadCity'        => ['label' => 'city', 'rules' => 'required'],
            'leadLocation'    => ['label' => 'location', 'rules' => 'required'],
            'leadEnqDate'     => ['label' => 'enquiry date', 'rules' => 'required'],
            'FollowUpDate'    => ['label' => 'follow up date', 'rules' => 'required'],
            'leadOwner'       => ['label' => 'lead owner', 'rules' => 'required'],
            'enqCourse'       => ['label' => 'enquiry course', 'rules' => 'required'],
            'courseValue'     => ['label' => 'course value', 'rules' => 'required'],
            'source'          => ['label' => 'source', 'rules' => 'required'],
            'status'          => ['label' => 'status', 'rules' => 'required'],
            'keyComment'      => ['label' => 'key comment', 'rules' => 'required'],
            'followUpComment' => ['label' => 'follow up comment', 'rules' => 'required'],
            'FollowUpDays'    => ['label' => 'follow days', 'rules' => 'required'],
            'FollouUpCounts'  => ['label' => 'follow up counts', 'rules' => 'required'],
            'leadUnsubscribe' => ['label' => 'unsubscribe', 'rules' => 'required'],
        ]);

        if($this->validation->withRequest($this->request)->run()){       
            $time = time();
            $data = [
                'Sys_Name'          => $this->request->getVar('sysName'),
                'User_Name'         => $this->request->getVar('leadUserName'),
                'Data_Entry'        => date('Y-m-d h:i:s'),
                'Enq_Dt'            => $this->request->getVar('leadEnqDate'),
                'Name'              => $this->request->getVar('name'),
                'City'              => $this->request->getVar('leadCity'),
                'Location'          => $this->request->getVar('leadLocation'),
                'Mob_1'             => $this->request->getVar('mob_1'),
                'mob_2'             => $this->request->getVar('mob_2'),
                'Email'             => $this->request->getVar('email'),
                'Follow_Up_Dt'      => $this->request->getVar('FollowUpDate'),
                'Lead_Owner'        => $this->request->getVar('leadOwner'),
                'Source'            => $this->request->getVar('source'),
                'Enq_Course'        => $this->request->getVar('enqCourse'),
                'Key_Comment'       => $this->request->getVar('keyComment'),
                'Follow_Up_Comment' => $this->request->getVar('followUpComment'),
                'Status_value'      => $this->request->getVar('statusValue'),
                'FollowUp_Days'     => $this->request->getVar('FollowUpDays'),
                'FollouUp_Counts'   => $this->request->getVar('FollouUpCounts'),
                'Unsubscribe'       => $this->request->getVar('leadUnsubscribe'),
                'Photo'             => $new_name,
                'Course_Value'      => $this->request->getVar('courseValue'),
                'Last_Updated_By'   => isset($this->session->get('loginInfo')['emp_id'])?$this->session->get('loginInfo')['emp_id']:"0",
                'status'            => $this->request->getVar('status')
            ];
            
            try {
                $user = $this->_leadModel->insert($data);
                $data = array('status'=>'Sucess', 'message' => '');
                return $this->respond(json_encode($data));
            } catch (\Exception $e) {
                return $this->fail($e->getMessage(), 400);
                return redirect()->route('leads');
            }    
        }else{
            return $this->fail($this->validation->getErrors(), 400);
            return redirect()->route('leads');
        }
    }

    public function import(){

       $this->validation->setRules([
            'username'        => ['label' => 'system name', 'rules' => 'required'],
            'importCourseVaue'=> ['label' => 'course ', 'rules' => 'required'],
            'file_csv'        => ['label' => 'csv', 'rules'=> 'uploaded[file_csv]|ext_in[file_csv,csv]' ]
        ]);

        if($this->validation->withRequest($this->request)->run()){
            date_default_timezone_set('Asia/Kolkata');
            $session        = session();
            $emp            = $session->get('loginInfo');
            $model          = new LeadModel();
            $username       = $this->request->getPost('username');
            $file_name      = rand() . $_FILES['file_csv']['name'];
            $filewithpath   = base_url() . "/public/temp/" . $file_name;
            $file           = $this->request->getFile('file_csv');
            $file->move('./temp', $file_name);
            
            $data           = $this->request->getPost();
            $catid          = $this->request->getPost('importCourseVaue');
            $subcatid       = NULL;
            $handle1        = fopen('./temp/' . $file_name, "r");
            $num            = 0;
            $countLead      = 0;
            $header         = fgetcsv($handle1, 1024, ",");
            $header         = implode(",", $header);
            $header         = '(' . $header . ')';
            $leads          = [];

            $host_name      = getHostName();
            $Sys_Name       = getHostName();

            try{
                while (($row = fgetcsv($handle1, 1024, ",")) != FALSE) {
                    
                    ++$num;
                    if (count($row) > 0) {          
                        $Enq_Dt            = strtotime($row[0]);
                        $Enq_Dt            = date('Y-m-d h:i:s', $Enq_Dt);
                        $Follow_Up_Dt      = strtotime($row[7]);
                        $Follow_Up_Dt      = date('Y-m-d h:i:s', $Follow_Up_Dt);
                        $FollowUp_Days     = strtotime($row[12]);
                        $FollowUp_Days     = date('Y-m-d h:i:s', $FollowUp_Days);

                        $lead = array(
                            "Sys_Name"     => $Sys_Name,
                            "host_name"    => $host_name,
                            "User_Name"    => $username,
                            "Data_Entry"   => date('Y-m-d h:i:s'),
                            "Enq_Dt"       => $Enq_Dt,
                            "Name"         => $row[1],
                            "City"         => $row[2],
                            "Location"     => $row[3],
                            "Mob_1"        => $row[4],
                            "mob_2"        => $row[5],
                            "Email"        => $row[6],
                            "Follow_Up_Dt" => $Follow_Up_Dt,
                            "Lead_Owner"   => $emp['emp_id'],
                            "Source"       => $row[8],
                            "Enq_Course"   => $catid,
                            "Key_Comment"  => $row[9],
                            "Status_value" => $row[11],
                            "FollowUp_Days"=> $FollowUp_Days,
                            "subcategory"  => $subcatid,
                            "Course_Value" => $row[13],
                            "created_at"   => date('Y-m-d h:i:s')
                        );
                        array_push($leads, $lead);
                    }
                }
            
                if ($model->importLeads($leads)) {
                    $response = [
                        'status'   => 200,
                        'error'    => null,
                        'messages' => [
                            'success' =>  $num . ' Data Import Successfully.'
                        ]
                    ];
                    return $this->respond($response);
                    //$session->markAsFlashdata("import_lead_message", $num.' Data Import Successfully.');                   
                    return redirect()->route('leads');
                } else {
                    return $this->fail('Data import unsuccessfull.', 400);
                    return redirect()->route('leads');
                }
            }catch(\Exception $e){
                return $this->fail("Please select valid format file.", 400);
                return redirect()->route('leads');
            }
        }else{
            return $this->fail($this->validation->getErrors(), 400);
            return redirect()->route('leads');
        }
    }

    public function sendMessage(){

        $this->validation->setRules([
            'bulkSms'     => ['label' => 'Bulk sms', 'rules' => 'required'],
            'smartSms'    => ['label' => 'Smart sms', 'rules' => 'required'],
            'whatsApp'    => ['label' => 'Whatsapp number', 'rules' => 'required'],
            'bulkEmails'  => ['label' => 'Bulk email', 'rules' => 'required'],
        ]);

        if($this->validation->withRequest($this->request)->run()){       
            $time = time();
            $data = [
                'bulkSms'          => $this->request->getVar('bulkSms'),
                'smartSms'         => $this->request->getVar('smartSms'),
                'whatsApp'         => $this->request->getVar('whatsApp'),
                'bulkEmails'       => $this->request->getVar('bulkEmails'),
            ];
            
            try {
                    //Load custom helper
                    helper('send');

                    $email = $this->request->getVar('bulkEmails');
                    $subject = "Test";
                    $message = "Message";
                    $to      = $email;
                    $from    =  "sartiadevelopment@gmail.com";
                    $name    = "Test Demo";
                    $status = "";
                    
                    //Send email message
                    if(count($email)>0){
                        $i = 0;
                        while($i <count($email)) {
                            if(myMail($email[$i], $from, $subject, $message, $name)){
                                $status = 1;
                            }
                            $i++;
                        }
                    }

                    $status = "";
                    $numbers =  $this->request->getVar('smartSms');                    
                    
                    //Send sms message
                    if(count($numbers)>0){
                        $i = 0;
                        while($i <count($numbers)) {
                            $fields = array(
                                "variables_values" => "5599",
                                "route" => "otp",
                                "numbers" => $numbers[$i]
                            );
                            if(sendSms($fields)){
                                $status = 1;
                            }
                            $i++;
                        }
                    }
                    echo $status;
                    exit;
                // $user = $this->_leadModel->insert($data);
                // $data = array('status'=>'Sucess', 'message' => '');
                return $this->respond(json_encode($data));
            } catch (\Exception $e) {
                return $this->fail($e->getMessage(), 400);
                return redirect()->route('leads');
            }    
        }else{
            return $this->fail($this->validation->getErrors(), 400);
            return redirect()->route('leads');
        }
    }

    public function searchValue(){
        $enq_status  =  $this->request->getPost('enqStatus');
        $owner_id    =  $this->request->getPost('ownerId');
        $source_id   =  $this->request->getPost('sourceId');
        $follow_up   =  $this->request->getPost('followUp');
        $enq_date    =  $this->request->getPost('enqDate');
        $follow_date =  $this->request->getPost('followUpDate');
        $location    =  $this->request->getPost('location');
        $city        =  $this->request->getPost('city');
        $searchValue        =  $this->request->getPost('searchValue');

        //Current month leads count
        $where_condition = array();
        if(!empty($enq_status)){
            $where = array(
                'xla_leads.status'=> $enq_status
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($owner_id)){
            $where = array(
                'xla_leads.Lead_Owner'=> $owner_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($source_id)){
            $where = array(
                'xla_leads.Source'=> $source_id
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(empty($enq_date) && empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> date('m'),
                'YEAR(xla_leads.created_at)'=> date('Y')
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($location)){
            $where = array(
                'xla_leads.Location'=> $location
            );
            $where_condition = array_merge($where_condition,$where);
        }
        if(!empty($city)){
            $where = array(
                'xla_leads.City'=> $city
            );
            $where_condition = array_merge($where_condition,$where);
        }
        
        $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        $this->leadModel->select('xla_users.full_name AS owner_name');
        $this->leadModel->select('xla_source.title AS source_name');
        $this->leadModel->select('xla_leads.*');
        $this->leadModel->like('xla_leads.Name',$searchValue);
        $this->leadModel->orLike('xla_leads.Email',$searchValue);
        $this->leadModel->orLike('xla_leads.Mob_1',$searchValue);
        $data['details'] = $this->leadModel->where($where_condition)->findAll();
        $this->leadModel->selectCount('id');
        $data['total_leads'] = $this->leadModel->where($where_condition)->findAll();

        //Return data for view page
        if($data) {            
            return $this->respond($data);
        } else {
            return $this->respond($data, false);
        }
    }



}