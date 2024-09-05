<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'username' => 'required|alpha_numeric_space|min_length[3]',
        'email'    => 'required|valid_email',
        'password' => 'required|min_length[6]',
    ];
}
