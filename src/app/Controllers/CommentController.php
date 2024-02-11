<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\NameModel;
use CodeIgniter\I18n\Time;

class CommentController extends BaseController
{
    public function index()
    {
        return view('comments/index');
    }

    public function ajaxIndex()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getGet();
            $perPage = $data['perPage'];
            $currentPage = $data['currentPage'];
            $orderBy = $data['orderBy'];
            $sortingOrder = $data['sortingOrder'];

            $commentModel = new \App\Models\CommentModel();
            $commentsData = $commentModel->getPagination($perPage, $currentPage, $orderBy, $sortingOrder);

            header("Content-type: application/json; charset=utf-8");
            echo json_encode($commentsData);
        }
    }

    public function ajaxStore()
    {
        $commentModel = new CommentModel();
        $nameModel = new NameModel();

        $receivedName = trim($this->request->getPost('name'));
        $receivedComment = trim($this->request->getPost('comment'));

        $isValidName = $nameModel->validate(['name' => $receivedName]);
        $isValidComment = $commentModel->validate(['text' => $receivedComment]);

        if ($isValidName && $isValidComment) {
            $nameData = $nameModel->where('name', $receivedName)->first();
            $nameId = $nameData['id'] ?? null;
            if ($nameId) {
                $commentModel->insert([
                    'name_id' => $nameId,
                    'text' => $receivedComment,
                    'date' => Time::now('Europe/Moscow', 'ru_RU'),
                ]);
                header("Content-type: application/json; charset=utf-8");
                echo json_encode(['status' => 'success']);
            } else {
                $nameModel->insert(['name' => $receivedName]);
                $nameId = $nameModel->getInsertID();
                $commentModel->insert([
                    'name_id' => $nameId,
                    'text' => $receivedComment,
                    'date' => Time::now('Europe/Moscow', 'ru_RU'),
                ]);
                header("Content-type: application/json; charset=utf-8");
                echo json_encode(['status' => 'success']);
            }
        } else {
            $nameError = $isValidName ? ['name' => ''] : $nameModel->errors();
            $commentError = $isValidComment ? ['text' => ''] : $commentModel->errors();
            $respose = [
                'status' => 'failure',
                'errors' => array_merge($nameError, $commentError)
            ];
            header("Content-type: application/json; charset=utf-8");
            echo json_encode($respose);
        }
    }
}
