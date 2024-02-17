<?php

namespace App\Services\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function handleLogin(Request $request)
    {
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $remember = $request->boolean("remember");
        return Auth::attempt($dataLogin, $remember);
    }
}
