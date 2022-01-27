<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Controllers\AuthController;

class ProfileController extends ResourceController
{
  use ResponseTrait;

  public function updateImage($id = null)
  {
    $model = new UserModel();
    $checkUser = $model->where('emp_id', $id)->first();
    if ($checkUser) {
      $file_name = rand() . $_FILES['picture_attachment']['name'];
      $filewithpath = base_url() . "/images/profile/" . $file_name;
      $file = $this->request->getFile('picture_attachment');
      $file->move('./images/profile', $file_name);
      $data = array('picture_attachment' => $filewithpath);

      $model->updateImage($id, $data);
      $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
          'success' => 'Profile Image Updated Successfully. .'
        ]
      ];
      return $this->respond($response);
    } else {
      return $this->respond('Try to access Invalid User.');
    }
  }


  // delete profile Image
  public function deleteImage($id = null)
  {
    $model = new UserModel();
    $delete_id = $id;
    $data = $model->where('emp_id', $id)->first();
    $filename = basename($data['picture_attachment']);
    $path = 'images/profile/' . $filename;

    if ($data != '') {
      if (file_exists($path)) {
        unlink($path);
        $data = array('picture_attachment' => '');
        $model->updateImage($delete_id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
            'success' => 'Profile Image deleted Successfully.'
          ]
        ];
        return $this->respond($response);
      } else {
        return $this->failNotFound('No Image found');
      }
    } else {
      return $this->failNotFound('No Image found');
    }
  }

  public function update_password($id = null)
  {
    $validation =  \Config\Services::validation();

    $model = new UserModel();
    $data = $model->where('emp_id', $id)->first();
    $input = $this->request->getRawInput();
    $current_pass = $input['password'];
    $status =  $this->validate([
      'new_password' => 'required|min_length[5]',
      'passconf' => 'required|matches[new_password]',
    ]);

    $newPass = md5($input['new_password']);
    if ($data) {
      if (md5($current_pass) ==  $data['password']) {
        if ($status) {
          $data = array('password' => $newPass);
          $model->updateImage($id, $data);
          $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
              'success' => 'Password Change Successfully.'
            ]
          ];
          return $this->respond($response);
        } else {
          $errors = $validation->getErrors();
          $response = [
            'status'   => 200,
            'error'    => true,
            'messages' => [
              'error_message' => $errors
            ]
          ];

          return $this->respond($response);
        }
      } else {
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
            'error-messages' => "Current Password don't match "
          ]
        ];
        return $this->respond($response);
      }
    } else {
      return $this->respond('Trying to access Invalid record.');
    }
  }


  public function update_general($id = null)
  {
    $validation =  \Config\Services::validation();
    $model = new UserModel();
    $data = $model->where('emp_id', $id)->first();
    $input = $this->request->getRawInput();
    $status =  $this->validate([
      'full_name' => 'required|min_length[5]',
      // 'designation' => 'required',
      'personal_email' => 'required|valid_email',
      'office_number' => 'required|numeric',
      'personal_number' => 'required|numeric'
    ]);

    if ($data) {
      if ($status) {
        $data = array(
          'full_name' => $input['full_name'],
          'designation' => $input['designation'],
          'personal_email' => $input['personal_email'],
          'office_number' => $input['office_number'],
          'personal_number' => $input['personal_number'],
          // 'sys_name' => $input['sys_name'],
          // 'account_name' => $input['account_name'],
          'location' => $input['location']
        );

        $model->updateImage($id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
            'success' => 'Data Update Successfully.'
          ]
        ];
        return $this->respond($response);
      } else {
        $errors = $validation->getErrors();
        $response = [
          'status'   => 200,
          'error'    => true,
          'messages' => [
            'error_message' => $errors
          ]
        ];
        return $this->respond($response);
      }
    } else {
      return $this->respond('Trying to access Invalid record.');
    }
  }

  public function search()
  {
    $input = $this->request->getRawInput();
    if ($input) {
      $model = new UserModel();
      $data = $model->like('full_name', $input['full_name'])->findAll();
      if ($data) {
        return $this->respond($data);
      } else {
        return $this->respond('No record found.');
      }
    } else {
      return $this->respond('Search Keyword is required.');
    }
  }
}
