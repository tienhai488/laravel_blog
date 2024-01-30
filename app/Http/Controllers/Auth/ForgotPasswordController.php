<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Services\Auth\ForgotService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected ForgotService $forgotService;

    public function __construct()
    {
        $this->forgotService = new ForgotService();
    }
    public function forgotPassword(Request $request)
    {
        $title = 'Quên mật khẩu';
        return view('auth.forgot', compact('title'));
    }

    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        $data = $request->only('email');

        $this->forgotService->sendMailResetPassword($data);

        return back()->with('message', 'Vui lòng kiểm tra email để đặt lại mật khẩu, nếu sau 1 phút không nhận được email thì vui lòng thử lại!');
    }
}
