<?php

namespace App\Models;

use CodeIgniter\Model;

class NameModel extends Model
{
    protected $table = 'names';
    protected $allowedFields = ['name'];

    protected $validationRules = [
        'name' => "required|valid_email|max_length[100]",
    ];
}
