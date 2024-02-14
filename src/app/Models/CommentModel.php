<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $allowedFields = ['name_id', 'text', 'date'];

    protected $validationRules = [
        'text' => "required",
    ];

    protected $validationMessages = [
        'text' => [
            'required' => 'Поле не может быть пустым!',
        ],
    ];

    public function getPagination(int $perPage, int $currentPage, string $orderBy, string $sortingOrder): array
    {
        $this->builder()
            ->select('names.id AS id, names.name, comments.id AS comment_id, comments.text, comments.date AS date')
            ->join('names', 'names.id = comments.name_id')
            ->orderBy($orderBy, $sortingOrder);
        return [
            'commentsList'  => $this->paginate($perPage, 'commentsGroup', $currentPage),
            'currentPage' => $this->pager->getCurrentPage('commentsGroup'),
            'pageCount' => $this->pager->getPageCount('commentsGroup'),
        ];
    }
}
