<?php

namespace App\Controllers;

class Choi extends BaseController
{
	public function index($name)
	{
		$data['title'] = $name;
		$data['name'] = "choi";
		$data['room'] = $name;
		$masoiModel = new \App\Models\MasoiModel();
		$data['roles'] = $masoiModel->GetListRole();
		$data['fullroles'] = $masoiModel->GetFullListRole();
		return view('choi', $data);
	}
	//--------------------------------------------------------------------

}
