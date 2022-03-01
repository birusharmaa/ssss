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
use App\Models\api\EnqStatusModel;
use App\Models\UserModel;
use App\Models\api\SourceModel;
use App\Models\api\LeadsCommentsModal;

class Enquiry extends BaseController
{
    use ResponseTrait;
    protected $leadModel;
    public function __construct(){
        $this->request = service('request');
        $this->leadModel = new LeadsModel();
        $validation =  \Config\Services::validation();

        $this->session = session();
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
        
    }

    //Load index with defaults data
    public function index(){
        $pageData['pageTitle'] = "Enquiry";
        $pageData['pageHeading'] = "Lead Enquiry";
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

        $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        $this->leadModel->select('xla_users.full_name AS owner_name');
        $this->leadModel->select('xla_source.title AS source_name');
        $this->leadModel->select('xla_leads.*');
        $pageData['cound_leads'] = $this->leadModel->countAll();

        $this->leadModel->selectSum('xla_leads.Course_Value');
        $pageData['leads_sum'] = $this->leadModel->findAll();

        $this->enqStatusModel = new EnqStatusModel();
        $pageData['enqStatus'] = $this->enqStatusModel->findAll();

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

        $this->leadModel->select('xla_leads.id');
        $data['count_leads'] = $this->leadModel->where($where_condition)->findAll();
        $data['count_leads'] = count($data['count_leads'] );
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



}