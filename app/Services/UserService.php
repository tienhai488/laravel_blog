<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUser($filter = [])
    {
        $condition = '';
        if ($filter['name'] != '') {
            $name = $filter['name'];
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "CONCAT_WS(' ', last_name, first_name) like '%$name%'";
        }

        if ($filter['email'] != '') {
            $email = $filter['email'];
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "email like '%$email%'";
        }

        if ($filter['status'] != '') {
            $status = $filter['status'];
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= 'status =  ' . $status;
        }

        // dd($condition);

        if ($condition == '') {
            return User::all();
        }

        return User::WhereRaw($condition)->get();
    }

    public function updateUser(User $user, $dataUpdate)
    {
        return $user->update($dataUpdate);
    }

    public function handleDeleteAllPost(User $user)
    {
        return $user->posts()->delete();
    }
}