<?php

namespace App\Models;

use CodeIgniter\Model;

class MasoiModel extends Model
{

    // Đăng ký tài khoản
    function JoinGame($username, $room)
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();

        $builder = $db->table('game');
        $builder->where('room', $room);
        $builder->where('lastping >= now() - interval 30 second');
        $builder->selectCount('id');
        $query = $builder->get();
        $value = $query->getRow()->id;

        $builder2 = $db->table('game');
        if ($value == 0) {
            $data = [
                'username' => $username,
                'room'  => $room,
                'isAdmin'  => TRUE,
                'role' => 21
            ];
        } else {
            $data = [
                'username' => $username,
                'room'  => $room,
                'isAdmin'  => FALSE
            ];
        }
        $builder2->insert($data);
        $session->set("id", $db->insertID());
        $session->set("username", $username);


        if ($value == 0) {
            $data['username'] = "Card1";
            $data['isBot'] = true;
            $data['isAdmin'] = false;
            $data['role'] = 20;
            $data['point'] = 0;

            $builder2->insert($data);


            $data['username'] = "Card2";
            $builder2->insert($data);

            $data['username'] = "Card3";
            $builder2->insert($data);
        }
    }

    // get list member
    function GetListMember($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');

        $builder->select('game.*');
        $builder->select('role.id as role_id');
        $builder->select('role.name');
        $builder->select('role2.id realrole_id');
        $builder->select('role2.name realrole');
        $builder->select('role.note');
        $builder->select('role.img');
        $builder->select('role.team');

        $builder->where('room', $room);
        // $builder->where('lastping >= now() - interval 10 second');
        $builder->join('role', 'game.role = role.id');
        $builder->join('role as role2', 'game.realrole = role2.id');
        $builder->orderBy('point', 'DESC');

        $query = $builder->get();

        return $query->getResult();
    }

    // get history
    function GetHistory($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('log');
        $builder->select('log.*');
        $builder->where(
            'room',
            $room
        );
        $builder->orderBy('dttm', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    function GetListMemberOnly($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->where('room', $room);
        $builder->where('isAdmin', 0);
        $builder->where('status', 1);
        // $builder->where('lastping >= now() - interval 10 second');
        $query = $builder->get();

        return $query->getResult();
    }

    function GetListRole()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('role');
        $builder->whereNotIn('id', [1, 20, 6]);
        $query = $builder->get();

        return $query->getResult();
    }
    function GetFullListRole()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('role');
        $builder->whereNotIn('id', [20]);
        $query = $builder->get();

        return $query->getResult();
    }
    // isAdmin
    function IsAdmin()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->where('id', $session->get("id"));
        $query = $builder->get();
        $session->set("isadmin", $query->getRow()->isAdmin);
        $session->set("room", $query->getRow()->room);
    }
    //ping status
    function Ping()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('lastping', date('Y-m-d H:i:s'));
        $builder->where('id', $session->get("id"));
        $builder->update();
    }


    //set role
    function SetRole($uid, $role)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('role', $role);
        $builder->set('realrole', $role);
        $builder->set('status', 1);
        $builder->set('donejob', 0);
        $builder->where('id', $uid);
        $builder->update();
    }
    //kick member
    function KickMember($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->where('id', $uid);
        $builder->delete();
    }


    //add Gold
    function AddGold($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('point', 'point+10', FALSE);
        $builder->where('id', $uid);
        $builder->update();
    }

    //Sub Gold
    function SubGold($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('point', 'point-10', FALSE);
        $builder->where('id', $uid);
        $builder->update();
    }

    //Kill
    function Kill($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('status', 0);
        $builder->where('id', $uid);
        $builder->update();
    }

    //Revival
    function Revival($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('status', 1);
        $builder->where('id', $uid);
        $builder->update();
    }


    //Revival
    function Trombai($room, $target)
    {
        $session = \Config\Services::session();
        $rolefrom = $this->GetRoleById($session->get("id"))->role_id;
        $rolefromName = $this->GetRoleById($session->get("id"))->username;
        if (count($target) == 1) {

            $roleto = $this->GetRoleById($target[0])->role_id;
            $roletoName = $this->GetRoleById($target[0])->name;
            $roletoUserName = $this->GetRoleById($target[0])->username;
            $db      = \Config\Database::connect();

            $builder = $db->table('game');
            $builder->set('realrole', $rolefrom);
            $builder->where('id', $target[0]);
            $builder->update();

            $builder2 = $db->table('game');
            $builder2->set('realrole', $roleto);
            $builder2->where('id', $session->get("id"));
            $builder2->update();
            $this->SetMeDone();

            $this->addLog($room,  $rolefromName . " đã trộm bài của " . $roletoUserName);
            return "Trộm bài thành công, bây giờ bạn là " . $roletoName;
        } else {
            $this->addLog($room,  $rolefromName . " chọn " . count($target) . " người nên không thành trộm.");
            return "Trộm thất bại, cần chọn 1 người để trộm.";
        }
    }

    //Revival
    function Nhanban($room, $target)
    {
        $db      = \Config\Database::connect();
        $session = \Config\Services::session();
        $rolefromName = $this->GetRoleById($session->get("id"))->username;

        $roleto = $this->GetRoleById($target[0])->role_id;
        $roletoName = $this->GetRoleById($target[0])->name;
        $roletoUserName = $this->GetRoleById($target[0])->username;
        $db      = \Config\Database::connect();
        if (count($target) == 1) {

            $builder2 = $db->table('game');
            $builder2->set('role', $roleto);
            $builder2->set('realrole', $roleto);
            $builder2->where('id', $session->get("id"));
            $builder2->update();

            $this->addLog($room,  $rolefromName . " đã nhân bản bài của " . $roletoUserName);
            return "Nhân bản bài thành công, bây giờ bạn có vai trò là " . $roletoName . ", hãy thực hiện chức năng.";
        } else {
            return "Vui lòng chọn 1 người để nhân bản.";
        }
    }
    //Revival
    function Keotheo($room, $target)
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('target', $this->GetRoleById($target[0])->username);
        $builder->where('id', $session->get("id"));
        $builder->update();
        $this->SetMeDone();

        if (count($target) == 1) {
            $rolefromName = $this->GetRoleById($session->get("id"))->username;
            $roletoName = $this->GetRoleById($target[0])->username;

            $this->addLog($room,  $rolefromName . " đã kéo theo " . $roletoName);

            return "Bạn vừa bắn thẳng mặt " . $this->GetRoleById($target[0])->username;
        } else {
            $rolefromName = $this->GetRoleById($session->get("id"))->username;
            $this->addLog($room,  $rolefromName . " kéo theo nhầm ");

            return "Vui lòng chọn 1 người để kéo theo.";
        }
    }
    //Revival
    function Doi2bai($room, $target)
    {
        $db      = \Config\Database::connect();
        $session = \Config\Services::session();

        $roleto = $this->GetRoleById($target[0])->realrole;
        $rolefrom = $this->GetRoleById($target[1])->realrole;
        $db      = \Config\Database::connect();

        if (count($target) == 2) {
            $builder = $db->table('game');
            $builder->set('realrole', $rolefrom);
            $builder->where('id', $target[0]);
            $builder->update();

            $builder2 = $db->table('game');
            $builder2->set('realrole', $roleto);
            $builder2->where('id', $target[1]);
            $builder2->update();
            $this->SetMeDone();

            $roleTrouble = $this->GetRoleById($session->get("id"))->username;
            $rolefromName = $this->GetRoleById($target[1])->username;
            $roletoName = $this->GetRoleById($target[0])->username;

            $this->addLog($room,  $roleTrouble . " (Kẻ gây rối) đã đổi bài của " . $roletoName . " và " . $rolefromName);
            return "Đổi thành công bài của 2 đứa đó rồi đó.";
        } else {
            $roleTrouble = $this->GetRoleById($session->get("id"))->username;
            $this->addLog($room,  $roleTrouble . " chọn " . count($target) . " người nên không thành công.");
            return "Đổi thất bại, cần chọn 2 người để đổi.";
        }
    }
    //Revival
    function Tientri($room, $target)
    {
        $session = \Config\Services::session();
        $rolefromName = $this->GetRoleById($session->get("id"))->username;

        $role1 = $this->GetRoleById($target[0])->name;
        $role1Name = $this->GetRoleById($target[0])->username;
        $str = "Thằng " . $role1Name . " là " . $role1;

        $this->addLog($room,  $rolefromName . " đã tiên tri bài của " . $role1Name);

        if (count($target) == 2) {
            $role2 = $this->GetRoleById($target[1])->name;
            $role2Name = $this->GetRoleById($target[1])->username;
            if ($this->GetRoleById($target[0])->isBot && $this->GetRoleById($target[1])->isBot) {
                $str .= ". Còn thằng " . $role2Name . " thì là " . $role2;
                $this->addLog($room,  $rolefromName . " đã tiên tri bài của " . $role2Name);
            }
        }
        $this->SetMeDone();


        return $str;
    }

    function SetMeDone()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('donejob', 1);
        $builder->where('id', $session->get("id"));
        $builder->update();
    }
    function SetHideAll($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set('donejob', 1);
        $builder->where('game.room', $room);
        $builder->update();
    }

    function SetShowHis($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set(
            'showhis',
            1
        );
        $builder->where('game.room', $room);
        $builder->update();
    }
    function SetHideHis($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->set(
            'showhis',
            0
        );
        $builder->where('game.room', $room);
        $builder->update();

        $this->deleteAllLog($room);
    }
    function addLog($room, $message)
    {
        $db      = \Config\Database::connect();
        $builder2 = $db->table('log');
        $data = [
            'room'  => $room,
            'log'  => $message
        ];

        $builder2->insert($data);
    }

    function deleteAllLog($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('log');
        $builder->delete(['room' => $room]);
    }
    //ping status
    function GetMyRole()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->select('game.*');
        $builder->select('role.id as role_id');
        $builder->select('name');
        $builder->select('note');
        $builder->select('team');
        $builder->select('img');
        $builder->join('role', 'game.role = role.id');
        $builder->where('game.id', $session->get("id"));
        $query = $builder->get();
        return $query->getRow();
    }

    //ping status
    function GetRoleById($uid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->select('game.*');
        $builder->select('role.id as role_id');
        $builder->select('name');
        $builder->select('note');
        $builder->select('team');
        $builder->select('img');
        $builder->join('role', 'game.role = role.id');
        $builder->where('game.id', $uid);
        $query = $builder->get();
        return $query->getRow();
    }

    function GetRoleNameId($roleid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('role');
        $builder->where('id', $roleid);
        $query = $builder->get();
        return $query->getRow()->name;
    }
}
