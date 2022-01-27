<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\UserModel;

class DashboardModel extends Model
{
    public function allusers()
    {
        $model = new UserModel();
        $model->select('emp_id, full_name');
        $data = $model->where('isAdmin', 0)->get()->getResultArray();
        return $data;
    }

    public function dashboardData()
    {
        $data =  array(
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
        return $data;
    }
}
