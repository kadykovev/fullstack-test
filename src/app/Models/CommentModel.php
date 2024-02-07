<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $allowedFields = ['name', 'text', 'date'];

    protected $validationRules = [
        'name' => "required|valid_email|max_length[100]",
        'text' => "required",
    ];
}
