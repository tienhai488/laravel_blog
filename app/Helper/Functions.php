<?php

use App\Enum\PostStatusEnum;
use App\Enum\UserStatusEnum;
use App\Mail\SendMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Undocumented function
 *
 * @param [type] $status
 * @return void
 */
function getButtonPostStatus(Post $post)
{
    $type = '';
    if ($post->isPending()) {
        $type = 'warning';
    } else if ($post->isApproved()) {
        $type = 'primary';
    } else if ($post->isDenied()) {
        $type = 'danger';
    }
    echo '<button class="btn btn-' . $type . '">' . PostStatusEnum::getDescription($post->status) . '</button>';
}

function getButtonUserStatus(User $user)
{
    $type = '';
    if ($user->isPending()) {
        $type = 'warning';
    } else if ($user->isApproved()) {
        $type = 'primary';
    } else if ($user->isDenied()) {
        $type = 'info';
    } else if ($user->isLocked()) {
        $type = 'danger';
    }
    echo '<button class="btn btn-' . $type . '">' . UserStatusEnum::getDescription($user->status) . '</button>';
}

function sendMailChangePostStatus(Post $post)
{
    $message = '';
    if ($post->isPending()) {
        $message = 'đã chuyển về trạng thái chờ phê duyệt';
    } else if ($post->isApproved()) {
        $message = 'đã được phê duyệt';
    } else if ($post->isDenied()) {
        $message = 'không được phê duyệt';
    }
    $content = [
        'subject' => 'Thông báo thay đổi trạng thái bài viết!',
        'body' => 'Chào bạn ' . $post->user->name . '. Bài viết ' . $post->title . ' của bạn ' . $message . '!'
    ];
    Mail::to($post->user->email)->send(new SendMail($content));
}
