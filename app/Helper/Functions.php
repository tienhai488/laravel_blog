<?php

use App\Enum\PostStatusEnum;
use App\Enum\UserStatusEnum;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

function getButtonPostStatus($status)
{
    $type = '';
    if ($status == PostStatusEnum::PENDING) {
        $type = 'warning';
    }
    else if ($status == PostStatusEnum::APPROVED) {
        $type = 'primary';
    }
    else if ($status == PostStatusEnum::DENIED) {
        $type = 'danger';
    }
    echo '<button class="btn btn-'.$type.'">'.PostStatusEnum::getDescription($status).'</button>';
}

function getButtonUserStatus($status)
{
    $type = '';
    if ($status == UserStatusEnum::PENDING) {
        $type = 'warning';
    }
    else if ($status == UserStatusEnum::APPROVED) {
        $type = 'primary';
    }
    else if ($status == UserStatusEnum::DENIED) {
        $type = 'info';
    }
    else if ($status == UserStatusEnum::LOCKED) {
        $type = 'danger';
    }
    echo '<button class="btn btn-'.$type.'">'.UserStatusEnum::getDescription($status).'</button>';
}

function sendMailChangePostStatus($post){
    $status = $post->status;
    $message = '';
    if($status == PostStatusEnum::PENDING){
        $message = 'đã chuyển về trạng thái chờ phê duyệt';
    }
    else if($status == PostStatusEnum::APPROVED){
        $message = 'đã được phê duyệt';
    }
    else if($status == PostStatusEnum::DENIED){
        $message = 'không được phê duyệt';
    }
    $content = [
        'subject' => 'Thông báo thay đổi trạng thái bài viết!',
        'body' => 'Chào bạn '.$post->user->name.'. Bài viết '.$post->title.' của bạn '.$message.'!'
    ];
    Mail::to($post->user->email)->send(new SendMail($content));
}
