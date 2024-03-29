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
    protected User $user;
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }
        $this->user = Auth::user();

        $check = true;
        $message = '';
        switch ($this->user->status) {
            case UserStatusEnum::PENDING:
                $check = false;
                $message = 'Tài khoản của bạn chưa được phê duyệt, không thể đăng nhập ngay lúc này!';
                break;
            case UserStatusEnum::DENIED:
                $check = false;
                $message = 'Tài khoản của bạn đã bị từ chối liên hệ chúng tôi để biết thêm chi tiết!';
                break;
            case UserStatusEnum::LOCKED:
                $check = false;
                $message = 'Tài khoản của bạn đã bị khóa!';
                break;
            default:
        }

        if ($check) {
            return $next($request);
        }

        Auth::logout();
        return to_route('auth.login')->with('error', $message);
    }
}