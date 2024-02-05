<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUser($filter = [])
    {
        $name = $filter["name"] ?? "";
        $email = $filter["email"] ?? "";
        $status = $filter["status"] ?? "";

        $condition = '';
        if ($name != '') {
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "CONCAT_WS(' ', last_name, first_name) like '%$name%'";
        }

        if ($email != '') {
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "email like '%$email%'";
        }

        if ($status != '') {
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

    public function filterData($name, $email, $status)
    {
        $users = User::orderBy('created_at', 'desc');
        $condition = '';
        if ($name != '') {
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "CONCAT_WS(' ', last_name, first_name) like '%$name%'";
        }

        if ($email != '') {
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= "email like '%$email%'";
        }

        if ($status != '') {
            if ($condition != '') {
                $condition .= ' and ';
            }
            $condition .= 'status =  ' . $status;
        }

        return $condition ?  $users->WhereRaw($condition) : $users;
    }
}
