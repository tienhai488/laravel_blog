<?php

namespace App\Jobs;

use App\Enum\PostStatusEnum;
use App\Mail\SendMail;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailChangePostStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        $message = "";
        if ($this->post->isPending()) {
            $message = "đã chuyển về trạng thái chờ phê duyệt";
        } else if ($this->post->isApproved()) {
            $message = "đã được phê duyệt";
        } else if ($this->post->isDenied()) {
            $message = "không được phê duyệt";
        }
        $content = [
            'subject' => 'Thông báo thay đổi trạng thái bài viết!',
            'body' => 'Chào bạn ' . $this->post->user->name . '. Bài viết ' . $this->post->title . ' của bạn ' . $message . '!'
        ];
        Mail::to($this->post->user->email)->send(new SendMail($content));
    }
}
