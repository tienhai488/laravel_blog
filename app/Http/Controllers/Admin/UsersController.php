<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{
    public function index(Request $request){
        $filter = [];

        $condition = '';
        if ($request->name != '') {
            $name = $request->name;
            if($condition != ''){
                $condition .= ' and ';
            }
            $condition .= "last_name || ' ' || first_name like '%$name%'";
        }

        if ($request->email != '') {
            $email = $request->email;
            if($condition != ''){
                $condition .= ' and ';
            }
            $condition .= "email like '%$email%'";
        }

        if ($request->status != '') {
            $status = $request->status;
            if($condition != ""){
                $condition .= " and ";
            }
            $condition .= "status = $status";
        }

        if($condition != ""){
            $users = User::WhereRaw($condition)->get();
        }
        else{
            $users = User::all();
        }

        $user = Auth::user();
        $title = 'Danh sách người dùng';
        return view('admin.users.list', compact('title', 'user', 'users'));
    }

    public function update(User $user){
        $userUpdate = $user;
        $user = Auth::user();
        if($user->id == $userUpdate->id){
            abort(404);
        }
        $title = 'Cập nhật người dùng';
        return view('admin.users.update', compact('title', 'user', 'userUpdate'));
    }

    public function postUpdate(UserProfileRequest $request, User $user){
        if($user->id == Auth::id()){
            abort(404);
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->address = $request->address;

        $result = $user->save();

        if ($result) {
            Alert::success('Thành công', 'Cập nhật người dùng thành công');

            return to_route('admin.users.index')->with('message', 'Cập nhật người dùng thành công!');
        } else {
            return to_route('admin.users.index')->with('error', 'Cập nhật người dùng không thành công!');
        }
    }

    public function profile(){
        $user = Auth::user();
        $title = 'Thông tin cá nhân';
        return view('admin.users.profile', compact('title', 'user'));
    }

    public function postProfile(UserProfileRequest $request){
        $user = User::find(Auth::id());

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

    public function changePassword(){
        $user = Auth::user();
        $title = 'Đổi mật khẩu';
        return view('admin.users.change_password', compact('title', 'user'));
    }

    public function postChangePassword(ChangePasswordRequest $request){
        $user = Auth::user();
        $user->password = Hash::make($request->password_new);
        $result = $user->save();

        if ($result) {
            Alert::success('Thành công', 'Thay đổi mật khẩu thành công');

            return back()->with('message', 'Thay đổi mật khẩu thành công!');
        } else {
            return back()->with('message', 'Thay đổi mật khẩu không thành công!');
        }
    }
}
