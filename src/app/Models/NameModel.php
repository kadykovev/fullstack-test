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

    protected $validationMessages = [
        'name' => [
            'required' => 'Поле не может быть пустым!',
            'valid_email' => 'Введите действительный email адрес!',
            'max_length[100]' => 'Не должно превышать 100 символов!',
        ],
    ];
}
