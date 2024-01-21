<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    public function resetPassword(string $token){
        $title = 'Đặt lại mật khẩu';
        return view('auth.reset_password', compact('title', 'token'));
    }

    public function postResetPassword(ResetPasswordRequest $request){
        $status = Password::reset(
            $request->only('email', 'password', 'confirm_password', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                // ->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        if($status === Password::PASSWORD_RESET){
            Alert::success('Thành công', 'Đặt lại mật khẩu thành công');
            return to_route('auth.login')->with('message', 'Thay đổi mật khẩu thành công, bạn có thể đăng nhập ngay bây giờ!');
        }
        else{
            return back()->with('error', 'Thay đổi mật khẩu không thành công, Vui lòng thử lại!');
        }
    }
}