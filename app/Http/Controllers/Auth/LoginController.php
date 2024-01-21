<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login()
    {
        $title = 'Đăng nhập';
        return view('auth.login', compact('title'));
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' =>
        $request->password])) {
            Alert::success('Thành công', 'Đăng nhập thành công!');
            return to_route('posts.index');
        } else {
            return back()->with('error', 'Đăng nhập không thành công, Vui lòng kiểm tra lại mật khẩu!')->with('email', $request->email);
        }
    }

    public function logout(){
        Auth::logout();
        return to_route('auth.login');
    }
}