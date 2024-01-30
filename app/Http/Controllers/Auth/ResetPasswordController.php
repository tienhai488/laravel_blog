<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    protected ResetPasswordService $resetPasswordService;

    public function __construct()
    {
        $this->resetPasswordService = new ResetPasswordService();
    }

    public function resetPassword(string $token)
    {
        $title = 'Đặt lại mật khẩu';
        return view('auth.reset_password', compact('title', 'token'));
    }

    public function postResetPassword(ResetPasswordRequest $request)
    {
        $dataReset = $request->only('email', 'password', 'confirm_password', 'token');

        $status = $this->resetPasswordService->handleResetPassword($dataReset);

        if ($status === Password::PASSWORD_RESET) {
            Alert::success('Thành công', 'Đặt lại mật khẩu thành công');
            return to_route('auth.login')->with('message', 'Thay đổi mật khẩu thành công, bạn có thể đăng nhập ngay bây giờ!');
        }
        return back()->with('error', 'Thay đổi mật khẩu không thành công, Vui lòng thử lại!');
    }
}
