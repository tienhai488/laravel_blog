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
    switch ($post->status) {
        case PostStatusEnum::PENDING:
            $type = 'warning';
            break;
        case PostStatusEnum::APPROVED:
            $type = 'primary';
            break;
        case PostStatusEnum::DENIED:
            $type = 'danger';
            break;
        default:
    }
    return '<button class="btn btn-' . $type . '">' . PostStatusEnum::getDescription($post->status) . '</button>';
}

function getButtonUserStatus(User $user)
{
    $type = '';
    switch ($user->status) {
        case UserStatusEnum::PENDING:
            $type = 'warning';
            break;
        case UserStatusEnum::APPROVED:
            $type = 'primary';
            break;
        case UserStatusEnum::DENIED:
            $type = 'info';
            break;
        case UserStatusEnum::LOCKED:
            $type = 'danger';
            break;
        default:
    }

    return '<button class="btn btn-' . $type . '">' . UserStatusEnum::getDescription($user->status) . '</button>';
}

function sendMailChangePostStatus(Post $post)
{
    $message = '';
    switch ($post->status) {
        case PostStatusEnum::PENDING:
            $message = 'đã chuyển về trạng thái chờ phê duyệt';
            break;
        case PostStatusEnum::APPROVED:
            $message = 'đã được phê duyệt';
            break;
        case PostStatusEnum::DENIED:
            $message = 'không được phê duyệt';
            break;
        default:
    }
    $content = [
        'subject' => 'Thông báo thay đổi trạng thái bài viết!',
        'body' => 'Chào bạn ' . $post->user->name . '. Bài viết ' . $post->title . ' của bạn ' . $message . '!'
    ];
    Mail::to($post->user->email)->send(new SendMail($content));
}
