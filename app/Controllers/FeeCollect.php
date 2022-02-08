<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\api\FeeModel;


class FeeCollect extends ResourceController
{
    use ResponseTrait;
    protected $session;
    protected $FeeModel;
    protected $empid;

    public function __constuct()
    {
        date_default_timezone_set('Asia/Kolkata');
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->FeeModel = new FeeModel();
    }

    public function index()
    {
        $model = new FeeModel();
        $data = $model->findAll();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->respond('No record found.');
        }
    }

    public function create()
    {
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $session = session();
        $emp = $session->get('loginInfo');
        if ($this->validate([          
            'paid_amount' => 'required',          
            'payment_mode' => 'required',
            'paid_by'    => 'required',
            'remark'    => 'required'
        ])) {

            $model = new FeeModel();
            $data = $this->request->getPost();  
            $data = array_merge($data,array('user_id' => $emp['emp_id']));            
            $model->insertFee($data);
            $response = [
                'status'   => 200,
                'error'    => false,
                'messages' => [
                    'success' => 'Fee Collection stored successfully.'
                ]
            ];
            return $this->respond($response);
        } else {  
           return $this->failValidationErrors($validation->getErrors());           
        }
    }

    public function comments($id = null)
    {
        $model = new FeeModel();
        $data = $model->getAllComments($id);
        if ($data != '') {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Record found');
        }
    }

    // delete
    public function delete($id = null)
    {
        $model = new FeeModel();
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
         
}
