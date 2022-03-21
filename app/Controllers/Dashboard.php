<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\DashboardModel;
use App\Models\LeadsModel;
use App\Models\api\LeadModel;
use App\Models\api\SourceModel; 
use App\Models\CategoryModel;
use App\Models\RoleModel;
use App\Models\api\StatusModel;
use App\Models\api\FeeModel;
use App\Models\api\AccountModel;
use App\Models\api\LocationModel;
use App\Models\api\SystemModel;
use App\Models\api\TeamModel;
use App\Models\CitiesMadel;


class Dashboard extends BaseController
{

    protected $leadModel;
    protected $CategoryModel;
    protected $session;
    protected $followUpModel;
    protected $sourceModel;
    protected $callStatus;


    public function __construct()
    {
        $this->leadModel = new LeadsModel();
        $this->followUpModel = new LeadModel();
        $this->CategoryModel = new CategoryModel();       
        $this->sourceModel = new SourceModel();
        $this->callStatus = new StatusModel();
        $this->accountModel = new AccountModel();
        $this->locationModel = new LocationModel();
        $this->systemModel = new SystemModel();
        $this->teamModel = new TeamModel();
        $this->city_model = new CitiesMadel();
        $this->session = \Config\Services::session();
        helper('general');
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

    /**
     *  Function To load Category view
     *
     * @return void
     */
    public function category()
    {
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Courses & Subjects'];
        return view('admin/dashboard/Category/index', $pageData);
    }


    /**
     *  Function to load role views
     *
     * @return array
     */
    public function role()
    {
        $model =  new RoleModel();
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Roles & Permission'];
        $pageData['roles'] = $model->getAllRole();
        $pageData['modules'] = $model->getAllModule();
        return view('admin/dashboard/Roles/index', $pageData);
    }

    /**
     * Function to load search view
     *
     * @return void
     */
    public function search()
    {
        return view('admin/dashboard/index');
    }

    /**
     * Function to load new leads view
     *
     * @return mixed
     */
    public function new_leads()
    {
        $emp = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'New Leads'];
        $pageData['username'] = $emp['full_name'];
        $pageData['leads'] = $this->leadModel->getAllLeads();
        $pageData['categories'] = $this->CategoryModel->getCategories();
        return view('admin/leads/index', $pageData);
    }

    /**
     * Function Load lead detailed views
     *
     * @param int $id
     * @return mixed
     */
    public function leadDetails($id = null)
    {
        $pageData['lead'] = $this->leadModel->getLeadDetails($id);
        $pageData['categories'] = $this->CategoryModel->getCategories();
        return view('admin/leads/view', $pageData);
    }

    /**
     * Function to load final lead views
     *
     * @return mixed
     */
    public function FinalLeads()
    {
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Final leads'];
        $empid = $this->session->get('loginInfo');
        $pageData['cities'] = $this->leadModel->getAllCity();
        $pageData['categories'] = $this->CategoryModel->getCategories();
        $pageData['assignedLeads'] = $this->leadModel->getleadsWhere(['Lead_Owner' => $empid['emp_id'], 'lead_action_status' => 2, 'Unsubscribe' => 0]);
        $pageData['unsubleads'] = $this->leadModel->getleadsWhere(['Lead_Owner' => $empid['emp_id'], 'Unsubscribe' => 1]);
        return view('admin/leads/final-leads', $pageData);
    }

    /**
     *  Function to load followup view 
     *
     * @return mixed
     */
    public function followupView()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Follow Up'];
        $pageData['callStatus'] = $this->callStatus->getAllStatus();
        $pageData['followUpsLeads'] = $this->followUpModel->getFollowUpsLead($empid['emp_id']);
        return view('admin/leads/follow-up', $pageData);
    }

    /**
     *  Function to load add new lead views
     *
     * @param int $id
     * @return mixed
     */
    public function add_lead($id = null)
    {
        $pageData['lead'] = $this->leadModel->getLeadDetails($id);
        $pageData['comments'] = $this->leadModel->getLastComment($id);
        $pageData['categories'] = $this->CategoryModel->getCategories();
        $pageData['sources'] = $this->sourceModel->findAll();
        $pageData['callStatus'] = $this->callStatus->getAllStatus();
        return view('admin/admission/view', $pageData);
    }

    /**
     * Function to load admission view 
     *
     * @return mixed
     */
    public function admission()
    {
        $pageData['leads'] = $this->leadModel->getadmission();
        $pageData['categories'] = $this->CategoryModel->getCategories();
        return view('admin/admission/index', $pageData);
    }

    /**
     *  Function is used to load fee collection views
     *
     * @return void
     */
    public function fee_collection()
    {
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Fee collection'];
        $pageData['leads'] = $this->leadModel->fee_Collect();
        return view('admin/fee_collect/index', $pageData);
    }

    /**
     * Function is used to show status page.
     */
    public function status(){
        $empid = $this->session->get('loginInfo'); 
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Call Status', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/status/index',$pageData);
    }

     /**
     * Function is used to load account table views
     *
     * @return array
     */
    public function accounts()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Accounts', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/Settings/Accounts/index', $pageData);
    }
    /**
     * Function is used to show inquiry pages
     *
     * @return array
     */
    public function enqStatus()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Enquiry status', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/Settings/Enqstatus/index', $pageData);
    }

    /**
     *  Function is used to show location page     
     * 
     * @return array
     */
    public function location()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Location', 'empid' => $empid['emp_id']];
        $this->city_model->select('id, name');
        $this->city_model->orderby('name', 'Asc');            
        $pageData['cities'] = $this->city_model->where('state_id >', 0)->where('state_id <', 40)->findAll();
        return view('admin/dashboard/Settings/Location/index', $pageData);
    }

    

    /**
     *  Function is used to show subject page
     *
     * @return array
     */
    public function subject()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Subject', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/Settings/Subjects/index', $pageData);
    }

    /**
     *  Function is used to show system details page
     *
     * @return array
     */
    public function systemDetails()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'System Details', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/Settings/SystemSetails/index', $pageData);
    }


      /**
     * Function is used to show list of teams
     *
     * @return array
     */
    public function team()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Team', 'empid' => $empid['emp_id']];
        $pageData['account'] = $this->accountModel->findAll();
        $pageData['location'] =  $this->locationModel->findAll();
        $pageData['system'] =  $this->systemModel->findAll();        
        return view('admin/dashboard/Settings/TeamList/index', $pageData);
    }

    public function teamview($id= null){
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Team View', 'empid' => $empid['emp_id']];
        $pageData['account'] = $this->accountModel->findAll();
        $pageData['location'] =  $this->locationModel->findAll();
        $pageData['system'] =  $this->systemModel->findAll();   
        $pageData['team'] = $this->teamModel->findTeam($id);     
        return view('admin/dashboard/Settings/TeamList/view', $pageData);
    }

    /**
     *  Function is used to logout the user and destroy the session
     */
    public function logout()

    {
        $this->session->remove('loginInfo');
        return redirect()->to(base_url());
    }
     /**
     *  Function is used to status page view.
     */

     /**
     *  Function is used to show sources page     
     * 
     * @return array
     */
    public function sources()
    {
        $empid = $this->session->get('loginInfo');
        $pageData = ['pageTitle' => 'XLAcademy Admin', 'pageHeading' => 'Sources', 'empid' => $empid['emp_id']];
        return view('admin/dashboard/Settings/Source/index', $pageData);
    }

}
