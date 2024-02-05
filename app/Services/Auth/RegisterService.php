<?php

namespace App\Services\Auth;

use App\Jobs\SendMailRegister;
use App\Mail\SendMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    public function addUser($dataUser)
    {
        return User::create($dataUser);
    }

    public function sendMail($email, $content)
    {
        $job = (new SendMailRegister($email, $content))->delay(Carbon::now()->addSeconds(10));
        dispatch($job);
    }
}
