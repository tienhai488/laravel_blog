<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function register()
    {
        $title = 'Đăng kí';
        return view('auth.register', compact('title'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $result = $user->save();

        if ($result) {
            Alert::success('Thành công', 'Thêm người dùng thành công');

            $content = [
                'subject' => 'Chào bạn!',
                'body' => 'Cảm ơn bạn đã đăng kí!'
            ];

            Mail::to($user->email)->send(new SendMail($content));

            return to_route('auth.login')->with('message', 'Bạn đã đăng kí tài khoản thành công, bạn có thể đăng nhập khi đã được phê duyệt!');
        } else {
            Alert::error('Thất bại', 'Thêm người dùng thất bại');

            return to_route('auth.register')->with('message', 'Hệ thống xảy ra lỗi vui lòng thử lại!');
        }
    }
}