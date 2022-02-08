<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\LeadModel;
use App\Models\api\LeadlogsModel;
use App\Models\api\FeeModel;

class Lead extends ResourceController
{
    use ResponseTrait;
    protected $session;
    protected $leadModel;
    protected $empid;

    public function __constuct()
    {
        date_default_timezone_set("Asia/Kolkata");
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->leadModel = new LeadModel();
    }

    public function index()
    {
        $model = new LeadModel();
        $data = $model->findAll();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->respond('No record found.');
        }
    }

    public function create()
    {
        $sess = session();
        $empid = $sess->get('loginInfo');
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        if ($this->validate([
            'Name' => 'required',
            'Mob_1' => 'required|numeric',
            'Email'    => 'required|valid_email',
        ])) {
            $model = new LeadModel();
            $data = $this->request->getPost();
            // $MAC = exec('getmac');
            // $data['Sys_Name'] = strtok($MAC, ' '); // getting mac Id
            $data['Sys_Name'] =  getHostName(); // getting remote ip
             // $data['ip'] = $_SERVER['REMOTE_ADDR']; // getting remote ip
            $data['host_name'] = getHostName();
            $Enq_Dt = $data['Enq_Dt'];
            $Follow_Up_Dt = $data['Follow_Up_Dt'];
            $filewithpath = '';

            if (!empty($_FILES['Photo']['name'])) {
                $file_name = rand() . $_FILES['Photo']['name'];
                $filewithpath = base_url() . "/images/leads/" . $file_name;
                $file = $this->request->getFile('Photo');
                $file->move('./images/leads/', $file_name);
            }

            $data = array_merge($data, array(
                'Photo' => $filewithpath,
                'Data_Entry' => date('Y-m-d H:s:i'),
                'Enq_Dt' => $Enq_Dt,
                'Follow_Up_Dt' => $Follow_Up_Dt,
                'created_at' => date('Y-m-d H:s:i'),
                'User_Name' => $empid['full_name']
            ));

            $model->insertLeads($data);
            $response = [
                'status'   => 200,
                'error'    => false,
                'messages' => [
                    'success' => 'Leads added Successfully.'
                ]
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status'   => 200,
                'error'    => true,
                'messages' => [
                    'error' => $validation->getErrors()
                ]
            ];

            return $this->respond($response);
        }
    }

    public function show($id = null)
    {

        $model = new LeadModel();

        $data = $model->where('id', $id)->first();
        if ($data != '') {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    // delete
    public function delete($id = null)
    {
        $model = new LeadModel();
        $data = $model->where('id', $id)->first();
        $filename = basename($data['Photo']);
        $path = 'images/leads/' . $filename;
        if ($data != '') {
            if ($model->deleteLeads($id)) {
                if (file_exists($path)) {
                    unlink($path);
                }
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Lead successfully deleted.'
                    ]
                ];
                return $this->respond($response);
            } else {
                return $this->failNotFound('No Deleted');
            }
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function update($id = null)
    {
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $model = new LeadModel();
        $getdata = $model->where('id', $id)->first();

        if ($getdata) {
            if ($this->validate([
                'Name' => 'required|min_length[5]',
                'Mob_1' => 'required|numeric',
                'Email'    => 'required|valid_email',

            ])) {

                $data = $this->request->getRawInput();


                $data2 = array(
                    'Name' => $data['Name'],
                    'Mob_1' => $data['Mob_1'],
                    'Email' => $data['Email'],
                    'Course_Value' => $data['Category'],
                    'Last_Updated_By' => date("Y-m-d")
                );

                $model->updateLeads($data2, $id);
                $response = [
                    'status'   => 200,
                    'error'    => false,
                    'messages' => [
                        'success' => 'Leads Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => true,
                    'messages' => [
                        'error' => $validation->getErrors()
                    ]
                ];

                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function updateImage($id = null)
    {
        $model = new LeadModel();
        $getdata = $model->where('id', $id)->first();

        if ($getdata) {
            $file_name = rand() . $_FILES['Photo']['name'];
            $filewithpath = base_url() . "/images/leads/" . $file_name;
            $file = $this->request->getFile('Photo');
            $file->move('./images/leads/', $file_name);

            $data = array('Photo' => $filewithpath);
            $model->updateLeads($data, $id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Photo Updated Successfully.'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function deleteImage($id = null)
    {
        $model = new LeadModel();
        $getdata = $model->where('id', $id)->first();
        $filename = basename($getdata['Photo']);
        $path = 'images/leads/' . $filename;

        if ($getdata) {
            if ($filename != '') {
                if (file_exists($path)) {
                    unlink($path);
                }
                $data = array('Photo' => '');
                $model->updateLeads($data, $id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Photo Removed Successfully.'
                    ]
                ];
                return $this->respond($response);
            } else {
                return $this->respond('No Image on this Profile');
            }
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function search()
    {
        $search = $this->request->getVar('query');
        if ($search) {
            $model = new LeadModel();
            $data = $model->search($search);
            if ($data) {
                $response = [
                    'status'   => 200,
                    'error'    => false,
                    'messages' => [
                        'success' => 'Done'
                    ],
                    'data' => $data
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status'   => 404,
                    'error'    => true,
                    'messages' => [
                        'success' => 'Done'
                    ]
                ];
                return $this->respond($response);
            }
        } else {
            return $this->respond('Search Keyword is required.');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLeadBySearch()
    {
        $session = session();
        $data = $this->request->getPost();
        $model = new LeadModel();
        $emp = $session->get('loginInfo');
    
        $data =  $model->getOneRow($data, $emp['emp_id']);
        
        if ($data) {
            $response = [
                'status'   => 200,
                'error'    => false,
                'messages' => [
                    'success' => 'Done'
                ],
                'data' => $data
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status'   => 404,
                'error'    => true,
                'messages' => [
                    'success' => 'No lead found'
                ]
            ];
            return $this->respond($response);
        }
    }

    /**
     * 
     */

    public function assignLead()
    {
        $data = $this->request->getPost();
        $model = new LeadModel();
        $res = $model->assignLeadsToUser($data);
        if ($res) {
            $response = [
                'status'   => 200,
                'error'    => false,
                'messages' => [
                    'success' => 'Assigned'
                ]
            ];
        } else {
            $response = [
                'status'   => 500,
                'error'    => false,
                'message' => "Internal server error"
            ];
        }

        return $this->respond($response);
    }

    /**
     * Function is used to update lead comment one by one in lead comment table
     *
     * @return object
     */
    public function updateLeadComments()
    {
        $session = session();

        $data = $this->request->getPost();
        $emp = $session->get('loginInfo');
        $model = new LeadlogsModel();

        $data['created_by'] = $emp['emp_id'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $res = $model->insertLogs($data);
        if ($res) {
            $response = [
                'status'   => 200,
                'error'    => false,
                'message' => [
                    'success' => 'Successfully saved'
                ]
            ];
        } else {
            $response = [
                'status'   => 500,
                'error'    => false,
                'message' => "Internal server error"
            ];
        }

        return $this->respond($response);
    }

    /**
     * Function is use to unsubscribe / change the status of lead
     */

    public function unsubscribeLeads()
    {
        try {
            $leadId = $this->request->getPost('id');
            $status = $this->request->getPost('status');

            $model = new LeadModel();
            $res =  $model->unsubscribeLead($leadId, $status);

            if ($res) {
                $response = [
                    'status'   => 200,
                    'error'    => false,
                    'message' => [
                        'success' => 'Successfully unsubscribed'
                    ]
                ];
            } else {
                $response = [
                    'status'   => 500,
                    'error'    => false,
                    'message' => "Internal server error"
                ];
            }
            return $this->respond($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function getFolloupList()
    {
        $session = session();
        $emp = $session->get('loginInfo');
        $model = new LeadModel();
        $data = $model->followupList($emp['emp_id']);
        if ($data) {
            $response = [
                'status'   => 200,
                'error'    => false,
                'message' => [
                    'success' => 'Successfully unsubscribed'
                ],
                'data' => $data
            ];
        } else {
            $response = [
                'status'   => 500,
                'error'    => false,
                'message' => "Internal server error"
            ];
        }
        return $this->respond($response);
    }

    function getUnsubscribedList()
    {
        $session = session();
        $emp = $session->get('loginInfo');
        
        $model = new LeadModel();
        $data = $model->unSubscribeList($emp['emp_id']);
        if ($data) {
            $response = [
                'status'   => 200,
                'error'    => false,
                'message' => [
                    'success' => 'Successfully unsubscribed'
                ],
                'data' => $data
            ];
        } else {
            $response = [
                'status'   => 500,
                'error'    => false,
                'message' => "Internal server error"
            ];
        }
        return $this->respond($response);
    }

    public function import()
    {

        date_default_timezone_set('Asia/Kolkata');
        $session = session();
        $emp = $session->get('loginInfo');
        $model = new LeadModel();
        $username = $this->request->getPost('username');
        $file_name = rand() . $_FILES['file_csv']['name'];
        $filewithpath = base_url() . "/public/temp/" . $file_name;
        $file = $this->request->getFile('file_csv');
        $file->move('./temp', $file_name);
        $data = $this->request->getPost();
        $catid                    = $this->request->getPost('category1');
        $subcatid                 = $this->request->getPost('subcategory1');
        $handle1                 = fopen('./temp/' . $file_name, "r");
        $num = 0;
        $countLead = 0;
        $header = fgetcsv($handle1, 1024, ",");
        $header = implode(",", $header);
        $header = '(' . $header . ')';
        $leads = [];

        // $MAC = exec('getmac');
        // $Sys_Name = strtok($MAC, ' '); // getting mac Id
        $host_name = getHostName();
        $Sys_Name = getHostName();

        while (($row = fgetcsv($handle1, 1024, ",")) != FALSE) {
            ++$num;
            if (count($row) > 0) {          
                $Enq_Dt = strtotime($row[0]);
                $Enq_Dt = date('Y-m-d h:i:s', $Enq_Dt);
                $Follow_Up_Dt = strtotime($row[7]);
                $Follow_Up_Dt = date('Y-m-d h:i:s', $Follow_Up_Dt);
                $FollowUp_Days = strtotime($row[12]);
                $FollowUp_Days = date('Y-m-d h:i:s', $FollowUp_Days);

                $lead = array(
                    "Sys_Name" => $Sys_Name,
                    "host_name" => $host_name,
                    "User_Name" => $username,
                    "Data_Entry" => date('Y-m-d h:i:s'),
                    "Enq_Dt" =>  $Enq_Dt,
                    "Name" => $row[1],
                    "City" => $row[2],
                    "Location" => $row[3],
                    "Mob_1" => $row[4],
                    "mob_2" => $row[5],
                    "Email" => $row[6],
                    "Follow_Up_Dt" => $Follow_Up_Dt,
                    "Lead_Owner" => $emp['emp_id'],
                    "Source" => $row[8],
                    "Enq_Course" => $catid,
                    "Key_Comment" => $row[9],
                    "Status_value" => $row[11],
                    "FollowUp_Days" => $FollowUp_Days,
                    "subcategory" => $subcatid,
                    "Course_Value" => $row[13],
                    "created_at" =>  date('Y-m-d h:i:s')
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
    }



    public function update_add($id = null)
    {
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $model = new LeadModel();
        $getdata = $model->where('id', $id)->first();
        $sess = session();
        $empid = $sess->get('loginInfo');
        if ($getdata) {
            if ($this->validate([
                'Name' => 'required|min_length[5]',
                'Mob_1' => 'required|numeric',
                'Email'    => 'required|valid_email',
            ])) {
                $data = $this->request->getRawInput();
                $data2 = array(
                    'Name' => $data['Name'],
                    'Mob_1' => $data['Mob_1'],
                    'mob_2' => $data['Mob_2'],
                    'Email' => $data['Email'],
                    'City' => $data['City'],
                    'Location' => $data['Location'],
                    'Enq_Course' => $data['Category'],
                    'Last_Updated_By' => $empid['emp_id'],
                    'Source' => $data['Source']
                );

                $model->updateLeads($data2, $id);
                $response = [
                    'status'   => 200,
                    'error'    => false,
                    'messages' => [
                        'success' => 'Leads Updated Successfully.'
                    ]
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => true,
                    'messages' => [
                        'error' => $validation->getErrors()
                    ]
                ];

                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    public function lead_fee($id = null)
    {
        $model = new LeadModel();
        $feeModel = new FeeModel();
        $data = $model->where('id', $id)->first();
        $paidAmount = $feeModel->getPaidAmount($id);
        $data['paid_amount'] = $paidAmount[0]['paid_amount'];
        if ($data != '') {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Record found');
        }
    }
}
