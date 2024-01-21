<?php

namespace App\Http\Middleware;

use App\Enum\UserStatusEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return $next($request);
        }
        $user = Auth::user();
        
        $check = true;
        $message = '';
        if($user->status == UserStatusEnum::PENDING){
            $check = false;
            $message = 'Tài khoản của bạn chưa được phê duyệt, không thể đăng nhập ngay lúc này!';
        }
        else if($user->status == UserStatusEnum::DENIED){
            $check = false;
            $message = 'Tài khoản của bạn đã bị từ chối liên hệ chúng tôi để biết thêm chi tiết!';
        }
        else if($user->status == UserStatusEnum::LOCKED){
            $check = false;
            $message = 'Tài khoản của bạn đã bị khóa!';
        }

        if($check){
            return $next($request);
        }
        
        Auth::logout();
        return to_route('auth.login')->with('error', $message);
    }
}