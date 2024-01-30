<?php

namespace App\Services\Auth;

use App\Jobs\SendMailResetPassword;
use Carbon\Carbon;

class ForgotService
{
    public function sendMailResetPassword($data)
    {
        $job = (new SendMailResetPassword($data))->delay(Carbon::now()->addSeconds(10));
        dispatch($job);
    }
}
