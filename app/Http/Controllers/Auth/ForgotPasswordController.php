<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\SendMailResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request){
        $title = "Quên mật khẩu";
        return view("auth.forgot", compact("title"));
    }

    public function postForgotPassword(ForgotPasswordRequest $request){
        // dd($request->only('email'));
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
     
        // return $status === Password::RESET_LINK_SENT
        //             ? back()->with("message", "Vui lòng kiểm tra email để đặt lại mật khẩu!")
        //             : back()->with("error", "Không thể gửi mail ngay lúc này, Vui lòng thử lại trong trong ít phút nữa!");

        $data = $request->only('email');
        $job = (new SendMailResetPassword($data))->delay(Carbon::now()->addSeconds(20));
        dispatch($job);

        return back()->with("message", "Vui lòng kiểm tra email để đặt lại mật khẩu, nếu sau 1 phút không nhận được email thì vui lòng thử lại!");
    }
}