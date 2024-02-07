<?php

namespace App\Controllers;
use App\Models\Comment;

class Home extends BaseController
{
	public function index()
	{
		$model = new \App\Models\CommentsModel();
		$data = $model->findAll();

		print_r($data);
		return view('welcome_message');
	}
}
