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
use App\Models\CitiesMadel;
use App\Models\StatesMadel;
use App\Models\api\LocationModel;
use App\Models\Attendance_Model;

class Attendance extends BaseController
{
    use ResponseTrait;
    protected $leadModel;
    public function __construct(){
        $this->request = service('request');
        $this->leadModel = new LeadsModel();
        $this->_leadModel = new LeadModel();
        $this->city_model = new CitiesMadel();
        $this->states_madel = new StatesMadel();
        $this->location_model = new LocationModel();
        $this->attendance = new Attendance_Model();
        $this->validation =  \Config\Services::validation();

        $this->session = session();
        if (!$this->session->has('loginInfo')) {
            return redirect()->to(base_url());
        }
        
    }

    //Load index with defaults data
    public function index(){
        $pages['title'] = "Trainers Attendance";
        echo view('admin/layout/header-section', $pages);
        return view('admin/attendance/trainers');        
    }
    
    public function users(){
        $pages['title'] = "Users Attendance";
        echo view('admin/layout/header-section', $pages);
        return view('admin/attendance/users');
    }
    
    public function all_trainers($param = null) {
        $current_date = $this->request->getGet('date');
        if(empty($current_date)){
            $current_date = date('m-Y');
        } 
        
        //Database connection 
        $db = db_connect();
        
        $income_month = date('m', strtotime('25-'.$current_date));
        $income_years = date('Y', strtotime('25-'.$current_date));

        //Fetch all user id in attendance table
        $sql = "SELECT `user_id` FROM `xla_attendance`
                            WHERE MONTH(`created_at`) = ".$income_month."
                            AND YEAR(`created_at`) = ".$income_years."
                            GROUP BY `user_id` ";
        $query = $db->query($sql);
        $users = $query->getResult();

        //Convert in array from array obejct
        $users = json_decode(json_encode($users), true);
        
        $data = [];
        
        //Loop for all users
        for($u=0; $u<sizeof($users); $u++){
            //Find user id
            $user_id = $users[$u]['user_id'];
            $query   = $db->query("SELECT `xla_users`.`full_name`, 
                                        `xla_attendance`.*, 
                                        `xla_attendance_type`.`name` as `type_name` 
                                        FROM `xla_attendance` 
                                        LEFT JOIN `xla_users` 
                                        ON `xla_attendance`.`user_id` = `xla_users`.`emp_id` 
                                        LEFT JOIN `xla_attendance_type` 
                                        ON `xla_attendance`.`type` = `xla_attendance_type`.`id` 
                                        WHERE MONTH(xla_attendance.created_at) =  $income_month
                                        AND YEAR(xla_attendance.created_at) =  $income_years
                                        AND `xla_attendance`.`user_id` = $user_id
                                        ORDER BY `xla_attendance`.`created_at` ASC");

            //$query   = $db->query($sql)
            $results = $query->getResult();

            //Convert in array of user attendence results
            $results = json_decode(json_encode($results), true);
            
            //Total days in month from current date
            $total_days = intval(date('t', strtotime('25-'.$current_date)));
            

            //Find month from current date
            $current_month = date('m', strtotime('25-'.$current_date));
            
            //Make present and apsent as count number of days
            for($i = 0; $i < $total_days; $i++){
                $j = $i;
                $j = $j+1;
                if($j < 10){
                    $j = '0'.$j;
                }

                //Current month 
                $c_m  = $j."-".$current_month;

                
                for($k = 0; $k < sizeof($results); $k++){
                    $newdate = date("d-m", strtotime($results[$k]['created_at']));
                    if($c_m == $newdate){
                        //Make attendance type data
                        $v = 'P';
                        //Make key aur value as per date
                        $new_data = ['day_'.$j => $v ];

                        //Append key and value in exists array data
                        $results[$k]= $results[$k] + $new_data;
                    }else{
                        //Set attendance type are blanck
                        $v = '';

                        //Make key aur value as per date
                        $new_data = ['day_'.$j=> $v ];

                        //Append key and value in exists array data
                        $results[$k]= $results[$k] + $new_data;
                    }
                }
            }

            $final_arr = [];
            $a= 1;
            $pos = []; 
            
            //Making present and absent in data
            foreach($results as $values){
                foreach($values as $key=>$value){
                    //Initializing "A" as absent in value are empty
                    if(empty($value)){
                        $value = "A";
                    }

                    //Condition check
                    if(!in_array($value, $final_arr)){
                        $final_arr[$key] = $value;
                    }

                    //Condition check
                    if(in_array($value, $final_arr) && $value =="A" && $key !="full_name"
                        && $key !="user_id"
                        && $key !="created_at" && $key !="updated_at"
                        && $key !="type_name"
                    ){                   
                        $final_arr[$key] = $value;
                    }      
                }

                //Search P position(Key value) in current array of row data
                $p = array_search('P',$final_arr,true);
                $pos[] = $p; 
            }

            //Make final data with final_arr and pos array variables
            foreach($final_arr as $k=>$final){    
                foreach($pos as $p=>$pv){
                    if($k==$pv){
                        $final_arr[$k] = "<span class='text-white bg-success p-1'>P</span>";
                    }
                }
            }
            //$append  all final_arr in data
            $data[] = $final_arr;
        }
        
        $res['data'] = $data;
        $res['date'] = $current_date;
        if($res) {            
            return $this->respond($res);
        }else{
            return $this->respond($res, false);
        }
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

        $lead_comment_model->select('xla_leads_comments.id');
        $lead_comment_model->join('xla_leads', 'xla_leads.id = xla_leads_comments.lead_id', 'LEFT');
        $data['comment_counts'] = $lead_comment_model->where('xla_leads_comments.lead_id', $id)->countAllResults();


        $lead_comment_model->join('xla_users', 'xla_users.emp_id = xla_leads_comments.created_by', 'LEFT');
        $lead_comment_model->select('xla_users.full_name');
        $lead_comment_model->select('xla_leads_comments.created_at AS fallow_comments_time, xla_leads_comments.comments');
        $lead_comment_model->orderBy('xla_leads_comments.id','DESC');            
        $data['follow_comment'] = $lead_comment_model->where('lead_id',$id)->findAll(5);
        
        if(count($data['follow_comment'])>0){
            for($i=0; $i<count($data['follow_comment']); $i++){
                $date = date($data['follow_comment'][$i]['fallow_comments_time']);
                $middle = strtotime($date); 
                $new_date = date('d-M-Y H:i A', $middle);
                $data['follow_comment'][$i]['fallow_comments_time'] = $new_date;
            }
        }

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
        // if(!empty($enq_status)){
        //     $where = array(
        //         'xla_leads.status'=> $enq_status
        //     );
        //     $where_condition = array_merge($where_condition,$where);
        // }
        // if(!empty($enq_status)){
        //     $enq_status = str_replace(" ", '', $enq_status);
        //     $enq_status = explode(',', $enq_status);
        // }
        

        // if(!empty($owner_id)){
        //     $owner_id = str_replace(" ", '', $owner_id);
        //     $owner_id = explode(',', $owner_id);
        // }
        // if(!empty($source_id)){
        //     $source_id = str_replace(" ", '', $source_id);
        //     $source_id = explode(',', $source_id);
        // }
        if(!empty($follow_up)){
            $where = array(
                'xla_leads.FollouUp_Counts'=> $follow_up
            );
            $where_condition = array_merge($where_condition,$where);
        }

        if(!empty($enq_date)){
            $where = array(
                'xla_leads.Enq_Dt'=> $enq_date,
            );
            $where_condition = array_merge($where_condition,$where);
        }

        if(!empty($follow_date)){
            $where = array(
                'xla_leads.Follow_Up_Dt'=> $follow_date
            );
            $where_condition = array_merge($where_condition,$where);
        }

        if(!empty($enq_date) && !empty($follow_date)){
            $where = array(
                'MONTH(xla_leads.created_at)'=> date('m'),
                'YEAR(xla_leads.created_at)'=> date('Y')
            );
            $where_condition = array_merge($where_condition,$where);
        }

        // if(!empty($location)){
        //     $location = str_replace(" ", '', $location);
        //     $location = explode(',', $location);
        // }

        // if(!empty($city)){
        //     $city = str_replace(" ", '', $city);
        //     $city = explode(',', $city);
        // }

        $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
        $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
        $this->leadModel->select('xla_users.full_name AS owner_name');
        $this->leadModel->select('xla_source.title AS source_name');
        $this->leadModel->select('xla_leads.*');

        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }

        $data['details'] = $this->leadModel->where($where_condition)->findAll();
        // echo $this->leadModel->getLastQuery();
        // exit;
        
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }

        $data['total_leads'] = $this->leadModel->where($where_condition)->findAll();

        

        //Last month total leads count
        $where_condition = array();
        $where = array();
        

        // if(!empty($owner_id)){
        //     $where = array(
        //         'xla_leads.Lead_Owner'=> $owner_id
        //     );
        //     $where_condition = array_merge($where_condition,$where);
        // }
        // if(!empty($source_id)){
        //     $where = array(
        //         'xla_leads.Source'=> $source_id
        //     );
        //     $where_condition = array_merge($where_condition,$where);
        // }
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
        
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }
        
        $data['total_leads_last_month'] = $this->leadModel->where($where_condition)->findAll();


        //open lead counts data
        $where_condition = array();
        // $static = ['1', '2', '3', '4'];
        //$where_condition = array_merge($where_condition,$where);
        $where = array();
        
        
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
        
        
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }
        $data['open_leads'] = $this->leadModel
        ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
        ->findAll();


        //last month open lead counts
        $where_condition = array();
        //$static = ['1', '2', '3', '4'];
        //$where_condition = array_merge($where_condition,$where);
        $where = array();
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
        
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }
        $data['open_leads_last_month'] = $this->leadModel
        ->where($where_condition)
                                            //->whereIn('xla_leads.lead_action_status', $static)
        ->findAll();


        //current lead counts data
        $where_condition = array();
        $static = ['1', '2', '3', '4'];
        $where = array();
        //$where_condition = array_merge($where_condition,$where);
        
        
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
        
        
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }
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
        $this->leadModel->selectCount('id');
        if(!empty($enq_status)){
            $this->leadModel->whereIn('xla_leads.status', $enq_status);
        }
        if(!empty($owner_id)){
            $this->leadModel->whereIn('xla_leads.Last_Updated_By', $owner_id);
        }
        if(!empty($source_id)){
            $this->leadModel->whereIn('xla_leads.Source', $source_id);
        }
        if(!empty($location)){
            $this->leadModel->whereIn('xla_leads.Location', $location);
        }
        if(!empty($city)){
            $this->leadModel->whereIn('xla_leads.City', $city);
        }
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

        $user_name      = $this->request->getPost('userName');
        $user_status    = $this->request->getPost('userStatus');
        $user_last_call = $this->request->getPost('userLastCall');
        $user_next_call = $this->request->getPost('userNextCall');
        $unsubscribe    = $this->request->getPost('unsubscribe');

        $created_by  =  $session->get('loginInfo')['emp_id'];
        
        if ($this->validate([
            'loadId' => 'required',
            'userName' => 'required',
            'userStatus' => 'required',
        ])){
            $lead_comment_model = new LeadsCommentsModal();
            if(!empty($comments)){
                $comennts_data = array(
                    "lead_id"    => $lead_id,
                    "comments"   => $comments,
                    "created_by" => $created_by
                );
                $lead_comment_model->insert($comennts_data);
            }

            $user = $this->leadModel->find($lead_id);
            if($user){
                $user_data = [
                    'Enq_Dt' => $user_last_call,
                    'Follow_Up_Dt'    => $user_next_call,
                    "Unsubscribe"=> $unsubscribe,
                    "status"=> $user_status,
                    "Name"=> $user_name
                ];
                $this->leadModel->update($lead_id, $user_data);

                $data['message'] = array("status" => 1, 'message' => "User details updated successfully.");
                
                $lead_comment_model->join('xla_users', 'xla_users.emp_id = xla_leads_comments.created_by', 'LEFT');
                $lead_comment_model->select('xla_users.full_name');
                $lead_comment_model->select('xla_leads_comments.created_at AS fallow_comments_time, xla_leads_comments.comments');
                $lead_comment_model->orderBy('xla_leads_comments.id','DESC');            
                $data['follow_comment'] = $lead_comment_model->where('lead_id',$lead_id)->findAll(5);
                return $this->respond($data);
            }else{
                $result = ["message"=>"No record found."];
                return $this->fail($result);
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
            $follow_date = $this->request->getVar('FollowUpDate');
            $date = strtotime($follow_date);
            $follow_date = date('Y-m-d', $date);

            $enq_date    = $this->request->getVar('leadEnqDate');
            $date = strtotime($enq_date);
            $enq_date = date('Y-m-d', $date);

            $follow_days = $this->request->getVar('FollowUpDays');
            $date = strtotime($follow_days);
            $follow_days = date('Y-m-d', $date);

            $data = [
                'Sys_Name'          => $this->request->getVar('sysName'),
                'User_Name'         => $this->request->getVar('leadUserName'),
                'Data_Entry'        => date('Y-m-d h:i:s'),
                'Enq_Dt'            => $enq_date,
                'Name'              => $this->request->getVar('name'),
                'City'              => $this->request->getVar('leadCity'),
                'Location'          => $this->request->getVar('leadLocation'),
                'Mob_1'             => $this->request->getVar('mob_1'),
                'mob_2'             => $this->request->getVar('mob_2'),
                'Email'             => $this->request->getVar('email'),
                'Follow_Up_Dt'      => $follow_date,
                'Lead_Owner'        => $this->request->getVar('leadOwner'),
                'Source'            => $this->request->getVar('source'),
                'Enq_Course'        => $this->request->getVar('enqCourse'),
                'Key_Comment'       => $this->request->getVar('keyComment'),
                'Follow_Up_Comment' => $this->request->getVar('followUpComment'),
                'Status_value'      => $this->request->getVar('statusValue'),
                'FollowUp_Days'     => $follow_days,
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
    $searchValue =  $this->request->getPost('searchValue');

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
    if(!empty($enq_date) && !empty($follow_date)){
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
    $this->leadModel->join('xla_leads_comments', 'xla_leads_comments.lead_id = xla_leads.id', 'LEFT');
    $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
    $this->leadModel->select('xla_users.full_name AS owner_name');
    $this->leadModel->select('xla_source.title AS source_name');
    $this->leadModel->select('xla_leads.*');
    $this->leadModel->like('xla_leads.Name',$searchValue);
    $this->leadModel->orLike('xla_leads.Email',$searchValue);
    $this->leadModel->orLike('xla_leads.Mob_1',$searchValue);
    $this->leadModel->orLike('xla_leads.Mob_2',$searchValue);
    $this->leadModel->orLike('xla_leads.Follow_Up_Comment',$searchValue);
    $this->leadModel->orLike('xla_leads_comments.comments',$searchValue);
    $data['details'] = $this->leadModel->where($where_condition)->findAll();
        // echo $this->leadModel->getLastQuery();
        // exit;
    $this->leadModel->selectCount('id');
    $data['total_leads'] = $this->leadModel->where($where_condition)->findAll();

        //Return data for view page
    if($data) {            
        return $this->respond($data);
    } else {
        return $this->respond($data, false);
    }
}

function getLocation($city_id = null){
    $location_model = new LocationModel();
    $location_model->select(['location_name','id']);
    $data = $location_model->where('city_id', $city_id)->findAll();
    if($data) {            
        return $this->respond($data);
    } else {
        return $this->respond($data, false);
    }
}

function searchData(){
    $name           =  $this->request->getPost('name');
    $email          =  $this->request->getPost('email');
    $mob_1          =  $this->request->getPost('mob_1');
    $mob_2          =  $this->request->getPost('mob_2');
    $key_comment    =  $this->request->getPost('keyComment');
    $follow_comment =  $this->request->getPost('followUpComment');
    
        //Current month leads count
    $name_where   = array();
    $email_where  = array();
    $mob_1_where  = array();
    $mob_2_where  = array();
    $key_where    = array();
    $follow_where = array();

    $flag = false;
    if(!empty($name)){
        $name_where = array(
            'xla_leads.Name'=> $name
        );
        $flag = true;
    }
    if(!empty($email)){
        // $where = array(
        //     'xla_leads.Email'=> $email
        // );
        // $where_condition = array_merge($where_condition,$where);
        $email_where = array(
            'xla_leads.Email'=> $email
        );
        $flag = true;
    }
    if(!empty($mob_1)){
        // $where = array(
        //     'xla_leads.Mob_1'=> $mob_1
        // );
        // $where_condition = array_merge($where_condition,$where);
        $mob_1_where = array(
            'xla_leads.Mob_1'=> $mob_1
        );
        $flag = true;
    }
    if(!empty($mob_2)){
        $mob_2_where = array(
            'xla_leads.mob_2'=> $mob_2
        );
        $flag = true;
    }
    if(!empty($key_comment)){
        $key_where = array(
            'xla_leads.Key_Comment'=> $key_comment
        );
        $flag = true;
    }
    if(!empty($follow_comment)){
        $follow_where = array(
            'xla_leads.Follow_Up_Comment'=> $follow_comment
        );
        $flag = true;
    }
    
    $this->leadModel->join('xla_users', 'xla_users.emp_id = xla_leads.Lead_Owner', 'LEFT');
    $this->leadModel->join('xla_source', 'xla_source.id = xla_leads.Source', 'LEFT');
    $this->leadModel->join('xla_leads_comments', 'xla_leads_comments.lead_id = xla_leads.id', 'LEFT');
    $this->leadModel->select('xla_users.full_name AS owner_name');
    $this->leadModel->select('xla_source.title AS source_name');
    $this->leadModel->select('xla_leads.*');
    
    if(!empty($name)){
        $this->leadModel->like('xla_leads.Name', $name);
    }

    if(!empty($email)){
        $this->leadModel->orLike('xla_leads.Email', $email);
    }

    if(!empty($mob_1)){
        $this->leadModel->orLike('xla_leads.Mob_1', $mob_1);
    }
    if(!empty($mob_2)){
        $this->leadModel->orLike('xla_leads.mob_2', $mob_2);
    }
    if(!empty($key_comment)){
        $this->leadModel->orLike('xla_leads.Key_Comment', $key_comment);
    }
    if(!empty($follow_comment)){
        $this->leadModel->orLike('xla_leads_comments.comments', $follow_comment);
    }
    $this->leadModel->groupBy('xla_leads.id');
    $data['details'] = $this->leadModel->findAll();
    //echo $this->leadModel->getLastQuery();

    //Return data for view page
    if(!empty($flag)) {  
        return $this->respond($data);
    } else {
        return $this->respond($data['details'] = [], false);
    }
}

function searchcity(){
    $search_city           =  $this->request->getPost('searchCity');
    $flag = false;
    $data = array();
    if(!empty($search_city)){
        $flag = true;
        $this->city_model->select('id, name');
        $this->city_model->like('name',$search_city);
        $this->city_model->orderby('name', 'Asc');            
        $data['cities'] = $this->city_model->findAll();
    }
    

    //Return data for view page
    if(!empty($flag)) {  
        return $this->respond($data);
    } else {
        return $this->respond($data['cities'] = [], false);
    }
}



}