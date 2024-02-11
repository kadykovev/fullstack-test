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

    public function getPagination(int $perPage = null, int $currentPage, string $orderBy, string $sortingOrder): array
    {
        $this->builder()
            ->select('names.id AS id, names.name, comments.text, comments.date AS date')
            ->join('names', 'names.id = comments.name_id')
            ->orderBy($orderBy, $sortingOrder);

        return [
            'commentsList'  => $this->paginate($perPage, 'commentsGroup', $currentPage),
            'currentPage' => $this->pager->getCurrentPage('commentsGroup'),
            'pageCount' => $this->pager->getPageCount('commentsGroup'),
        ];
    }
}
