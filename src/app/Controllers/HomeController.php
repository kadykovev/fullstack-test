<?php

namespace App\Controllers;

class HomeController extends BaseController
{
	public function index()
	{
		if ($r = $this->request->isAJAX()) {
            print_r($this->request->getGet());
            echo $r;
		}
		//$req = $this->request;
		//dd($req);
		return view('home');
	}
}
