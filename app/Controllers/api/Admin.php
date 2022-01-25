<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\SettingModel;
use CodeIgniter\HTTP\IncomingRequest;

class Admin extends ResourceController
{


    public function allusers()
    {
        $model = new UserModel();
        $model->select('emp_id, full_name');
        $data = $model->where('isAdmin', 0)->get()->getResultArray();

        if ($data > 0) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Success.'
                ],
                'data' => $data
            ];
        } else {
            $response = [
                'status'   => 404,
                'error'    => null,
                'messages' => [
                    'success' => 'Not found.'
                ],
                'data' => []
            ];
        }
        return $this->respond($response);
    }

    public function dashBoardData()
    {

        $model = new UserModel();

        $data = array(
            array(
                'title' => "Today's Leads",
                'count' => rand(10, 100),
            ),
            array(
                'title' => 'Pending Leads',
                'count' => rand(10, 500),
            ),
            array(
                'title' => 'Next Week Lead',
                'count' => rand(10, 10000),
            ),
            array(
                'title' => 'This Month Lead',
                'count' => '100',
            ),
            array(
                'title' => 'Touched',
                'count' => '24',
            ),
            array(
                'title' => 'Untouched',
                'count' => '100',
            ),
            array(
                'title' => 'Business',
                'count' => '456320',
            ),
            array(
                'title' => 'Revenue',
                'count' => '<i class="fas fa-rupee-sign"></i> 2,34,778',
            ),
            array(
                'title' => 'Admission',
                'count' => '9',
            ),
            array(
                'title' => 'Collection',
                'count' => '21000',
            ),
            array(
                'title' => 'Collection',
                'count' => '21000',
            ),

        );

        if (count($data) > 0) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Success.'
                ],
                'data' => $data
            ];
        } else {
            $response = [
                'status'   => 404,
                'error'    => null,
                'messages' => [
                    'success' => 'Not found.'
                ],
                'data' => []
            ];
        }
        return $this->respond($response);
    }

    public function updateSetting()
    {

        $model = new SettingModel();
        $model->select('id, setting_name')->get();
        $data = $model->where('deleted', 0)->get()->getResultArray();

        $formData = $this->request->getRawInput();

        if (empty($formData)) {
            $response = [
                'status'   => 404,
                'error'    => true,
                'messages' => [
                    'success' => 'invalid data'
                ],
                'data' => []
            ];
            return $this->respond($response);
            
        } else {
            $updatedArr = [];
            foreach ($formData as $key => $item) {
                foreach ($data as $val) {
                    if ($val['setting_name'] === $key) {
                        $id = $val['id'];
                        $d = ['setting_value' => $item];
                        $res = $model->updateSetting($id, $d);
                        $val['setting_value'] = $item;
                        $updatedArr['updated'][] = $val;
                    } 
                }
            }
        }

        $response = [
            'status'   => 200,
            'error'    => false,
            'messages' => [
                'success' => 'Setting Updated.',
            ],
            'data' => [$updatedArr]
        ];
        return $this->respond($response);
    }
}
