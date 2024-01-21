<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{
    public function profile(){
        $user = Auth::user();
        $title = 'Thông tin cá nhân';
        return view('users.profile', compact('title', 'user'));
    }

    public function postProfile(UserProfileRequest $request){
        $user = Auth::user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;

        $result = $user->save();

        if ($result) {
            Alert::success('Thành công', 'Cập nhật thông tin thành công');

            return back()->with('message', 'Cập nhật thông tin thành công!');
        } else {
            return back()->with('message', 'Cập nhật thông tin không thành công!');
        }
    }
}