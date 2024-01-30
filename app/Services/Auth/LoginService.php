<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function handleLogin($dataLogin)
    {
        return Auth::attempt($dataLogin);
    }
}
