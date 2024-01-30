<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    protected RegisterService $registerService;

    public function __construct()
    {
        $this->registerService = new RegisterService();
    }

    public function register()
    {
        $title = 'Đăng kí';
        return view('auth.register', compact('title'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $email = $request->email;
        $dataUser = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ];

        $result = $this->registerService->addUser($dataUser);

        if ($result) {
            Alert::success('Thành công', 'Thêm người dùng thành công');

            $content = [
                'subject' => 'Chào bạn!',
                'body' => 'Cảm ơn bạn đã đăng kí!'
            ];

            $this->registerService->sendMail($email, $content);

            return to_route('auth.login')->with('message', 'Bạn đã đăng kí tài khoản thành công, bạn có thể đăng nhập khi đã được phê duyệt!');
        }
        Alert::error('Thất bại', 'Thêm người dùng thất bại');

        return to_route('auth.register')->with('message', 'Hệ thống xảy ra lỗi vui lòng thử lại!');
    }
}
