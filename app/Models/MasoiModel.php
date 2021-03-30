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
    }

    // get list member
    function GetListMember($room)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('game');

        $builder->select('game.*');
        $builder->select('role.name');
        $builder->select('role.note');
        $builder->select('role.img');
        $builder->select('role.team');

        $builder->where('room', $room);
        $builder->where('lastping >= now() - interval 10 second');
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
        $builder->where('lastping >= now() - interval 10 second');
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

    //ping status
    function GetMyRole()
    {
        $session = \Config\Services::session();
        $db      = \Config\Database::connect();
        $builder = $db->table('game');
        $builder->select('name');
        $builder->select('note');
        $builder->select('team');
        $builder->select('img');
        $builder->join('role', 'game.role = role.id');
        $builder->where('game.id', $session->get("id"));
        $query = $builder->get();
        return $query->getRow();
    }
}
