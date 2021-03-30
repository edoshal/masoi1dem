<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;


class Api extends BaseController
{

	use ResponseTrait;
	public function index()
	{
		die();
	}

	//đăng nhập
	public function login()
	{
		$request = \Config\Services::request();
		$username = $request->getVar('username');
		$room = $request->getVar('room');


		$masoiModel = new \App\Models\MasoiModel();
		$masoiModel->JoinGame($username, $room);
		$masoiModel->IsAdmin();
	}

	//ping
	public function ping()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');

		$masoiModel = new \App\Models\MasoiModel();
		$masoiModel->Ping();
		return $this->respond($masoiModel->GetListMember($room));
	}

	//ping
	public function GetRole()
	{
		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->GetMyRole());
	}

	//kickmember
	public function kickMember()
	{
		$request = \Config\Services::request();
		$uid = $request->getVar('uid');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$masoiModel->KickMember($uid);
		}
	}

	//ping
	public function addGold()
	{
		$request = \Config\Services::request();
		$uid = $request->getVar('uid');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$masoiModel->AddGold($uid);
		}
	}


	//subgold
	public function subGold()
	{
		$request = \Config\Services::request();
		$uid = $request->getVar('uid');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$masoiModel->SubGold($uid);
		}
	}

	//ping
	public function kill()
	{
		$request = \Config\Services::request();
		$uid = $request->getVar('uid');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$masoiModel->Kill($uid);
		}
	}

	//ping
	public function revival()
	{
		$request = \Config\Services::request();
		$uid = $request->getVar('uid');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$masoiModel->Revival($uid);
		}
	}

	//add Per Woft
	public function addPerWoft()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$listMember = $masoiModel->GetListMember($room);
			for ($x = 0; $x < count($listMember); $x++) {
				if($listMember[$x]->team == "Ma sói"){
					$masoiModel->AddGold($listMember[$x]->id);
				}
			}
		}
	}
	//add Per Village
	public function addPerVillage()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$listMember = $masoiModel->GetListMember($room);
			for ($x = 0; $x < count($listMember); $x++) {
				if ($listMember[$x]->team == "Dân làng") {
					$masoiModel->AddGold($listMember[$x]->id);
				}
			}
		}
	}


	//clear role

	public function clearRoles()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$listMember = $masoiModel->GetListMemberOnly($room);
			for ($x = 0; $x < count($listMember); $x++) {
				$masoiModel->SetRole($listMember[$x]->id, 20);
			}
		}
	}

	public function trombai()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$target = $request->getVar('target');

		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->Trombai($room, $target));
	}
	public function nhanban()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$target = $request->getVar('target');

		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->Nhanban($room, $target));
	}
	public function keotheo()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$target = $request->getVar('target');

		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->Keotheo($room, $target));
	}
	public function doi2bai()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$target = $request->getVar('target');

		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->Doi2bai($room, $target));
	}
	public function tientri()
	{
		$request = \Config\Services::request();
		$room = $request->getVar('room');
		$target = $request->getVar('target');

		$masoiModel = new \App\Models\MasoiModel();
		return $this->respond($masoiModel->Tientri($room, $target));
	}

	//generate role
	public function generate()
	{
		$request = \Config\Services::request();
		$roles = $request->getVar("roles");
		$numWoft = $request->getVar("woft");
		$room = $request->getVar('room');
		$session = \Config\Services::session();
		if ($session->isadmin) {
			$masoiModel = new \App\Models\MasoiModel();
			$listMember = $masoiModel->GetListMemberOnly($room);
			
			shuffle($listMember);
			// if(count($listMember) < 6) return;
			$assignRole = true;

			for ($x = 0; $x < count($listMember); $x++) {
				if ($numWoft > 0) {
					$masoiModel->SetRole($listMember[$x]->id, 1);
					$numWoft--;
				} else if ($assignRole) {
					foreach ($roles as &$role) {
						$masoiModel->SetRole($listMember[$x]->id, $role);
						$x++;
					}
					$assignRole = false;
					$x--;
				} else {
					$masoiModel->SetRole($listMember[$x]->id, 6);
				}
			}
		}
	}
	//--------------------------------------------------------------------

}
