<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\AuthModel;
use CodeIgniter\HTTP\IncomingRequest;


class AuthController extends Controller
{
  use ResponseTrait;

  public function checkUser(){  
           
    $request = service('request');
    $userEmail = $request->getHeader('email');
    $userPassword = $request->getHeader('password'); 
    $userPassword = $userPassword->getValue(); 
    //$userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $model = new AuthModel();
    $condition = ['personal_email' => $userEmail->getValue()];
    $data = $model->where($condition)->first(); 
    if (password_verify($userPassword, $data['password'])) {    
         return TRUE;      
      } else {  
        return FALSE;
      }    
  }
}
