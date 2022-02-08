<?php

namespace App\Controllers;
use Config\Services;

class Profile extends BaseController
{
    public function index()
    {
        return view('admin/profile/index');
    }
}
