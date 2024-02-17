<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function login()
    {
        $title = 'Đăng nhập';
        return view('auth.login', compact('title'));
    }

    public function postLogin(LoginRequest $request)
    {
        if ($this->loginService->handleLogin($request)) {
            Alert::success('Thành công', 'Đăng nhập thành công!');
            return to_route('posts.index');
        }
        return back()->with('error', 'Đăng nhập không thành công, Vui lòng kiểm tra lại mật khẩu!')->with('email', $request->email);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return to_route('auth.login');
    }
}
