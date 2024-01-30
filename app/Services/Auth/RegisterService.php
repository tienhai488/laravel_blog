<?php

namespace App\Services\Auth;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    public function addUser($dataUser)
    {
        return User::create($dataUser);
    }

    public function sendMail($email, $content)
    {
        Mail::to($email)->send(new SendMail($content));
    }
}
