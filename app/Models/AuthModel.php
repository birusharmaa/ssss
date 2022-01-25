<?php 
namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'xla_users';
    protected $primaryKey = 'emp_id';
}