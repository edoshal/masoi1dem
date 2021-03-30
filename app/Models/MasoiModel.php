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
        $builder->select('role.note');
        $builder->select('role.img');
        $builder->select('role.team');

        $builder->where('room', $room);
        // $builder->where('lastping >= now() - interval 10 second');
        $builder->join('role', 'game.role = role.id');
        $builder->orderBy('point', 'DESC');

        $query = $builder->get();

        return $query->getResult();
    }
    function GetListMemberOnly($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->where('room', $room);
        $builder->where('isAdmin', 0);
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
        $builder->set('status', 1);
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
    // function Trombai($room, $target)
    // {
    //     $session = \Config\Services::session();
    //     $rolefrom = $this->GetRoleById($session->get("id"))->role_id;
    //     $roleto = $this->GetRoleById($target[0])->role_id;
    //     $roletoName = $this->GetRoleById($target[0])->name;
    //     $db      = \Config\Database::connect();
     
    //     $builder = $db->table('game');
    //     $builder->set('role', $rolefrom);
    //     $builder->where('id', $target[0]);
    //     $builder->update();

    //     $builder2 = $db->table('game');
    //     $builder2->set('role', $roleto);
    //     $builder2->where('id', $session->get("id"));
    //     $builder2->update();

    //     return "Đổi thành công, bây giờ bạn là ". $roletoName;
    // }

    //Revival
    function Nhanban($room, $target)
    {
        $db      = \Config\Database::connect();
    
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
        return "Bạn vừa bắn thẳng mặt " . $this->GetRoleById($target[0])->username;
    }
    //Revival
    function Doi2bai($room, $target)
    {
        $db      = \Config\Database::connect();

        $roleto = $this->GetRoleById($target[0])->role_id;
        $rolefrom = $this->GetRoleById($target[1])->role_id;
        $db      = \Config\Database::connect();

        $builder = $db->table('game');
        $builder->set('role', $rolefrom);
        $builder->where('id', $target[0]);
        $builder->update();

        $builder2 = $db->table('game');
        $builder2->set('role', $roleto);
        $builder2->where('id', $target[1]);
        $builder2->update();

        return "Đổi thành công bài của 2 đứa đó rồi đó.";
    }
    //Revival
    function Tientri($room, $target)
    {
        $role1 = $this->GetRoleById($target[0])->name;
        $role1Name = $this->GetRoleById($target[0])->username;
        $str = "Thằng " . $role1Name . " là " . $role1;
        if (count($target) == 2) {
            $role2 = $this->GetRoleById($target[1])->name;
            $role2Name = $this->GetRoleById($target[1])->username;
            $str .= ". Còn thằng " . $role2Name . " thì là " . $role2;
        }
        return $str;
    }


    //ping status
    function GetMyRole()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
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
}
