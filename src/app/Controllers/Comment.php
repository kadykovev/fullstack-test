<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\I18n\Time;

class Comment extends BaseController
{
	public function index()
	{
		$model = new CommentModel();

		//$data = $model->findAll();

		//print_r($data);
		return view('comments/index');
	}

    public function store()
    {
        $model = new CommentModel();

        $result = $model->insert([
            'name' => $this->request->getPost('name'),
            'text' => $this->request->getPost('text'),
            'date' => Time::now('Europe/Moscow', 'ru_RU'),
        ]);

        dd($model->errors());



        //return redirect()->route('comments');
        return redirect()->to('/comments');
    }

}
