<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function profile()
    {
        $user = Auth::user();
        $title = 'Thông tin cá nhân';
        return view('users.profile', compact('title', 'user'));
    }

    public function postProfile(UserProfileRequest $request)
    {
        $user = User::find(Auth::id());

        $dataUpdate = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
        ];

        $result = $this->userService->updateUser($user, $dataUpdate);

        if ($result) {
            Alert::success('Thành công', 'Cập nhật thông tin thành công');

            return back()->with('message', 'Cập nhật thông tin thành công!');
        }
        return back()->with('message', 'Cập nhật thông tin không thành công!');
    }

    public function deleteAllPost()
    {
        $user = Auth::user();
        $posts = $user->posts;
        if ($posts->count() == 0) {
            return to_route('posts.index')->with('error', "Không tồn tại bài viết nào!");
        }

        $result = $this->userService->handleDeleteAllPost($user);

        if ($result > 0) {
            Alert::success('Thành công', 'Đã xóa thành công tất cả bài viết của bạn!');
            $message = 'Xóa bài viết thành công!';
        } else {
            $message = 'Xóa tất cả bài viết của bạn không thành công!';
        }
        return to_route('posts.index')->with('message', $message);
    }
}
