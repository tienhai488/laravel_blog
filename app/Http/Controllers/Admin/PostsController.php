<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Jobs\SendMailChangePostStatus;
use App\Jobs\SendMailResetPassword;
use App\Mail\SendMail;
use App\Models\Post;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user');
        if ($request->title != '') {
            $posts = $posts->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->email != '') {
            $email = $request->email;
            $posts = $posts->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });
        }
        if ($request->status != '') {
            $posts = $posts->where('status', $request->status);
        }

        $posts = $posts->get();
        $user = Auth::user();
        $title = 'Danh sách bài viết';
        return view('admin.posts.list', compact('title', 'posts', 'user'));
    }

    public function update(Post $post)
    {
        $user = Auth::user();
        $title = 'Cập nhật bài viết';
        return view('admin.posts.update', compact('title', 'post', 'user'));
    }

    public function postUpdate(PostRequest $request, Post $post)
    {
        $content = $request->content;

        $dom = new DOMDocument();
        @$dom->loadHTML("<meta charset='utf8'>" . $content);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            if (strpos($img->getAttribute('src'), 'data:image/') === 0) {

                $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                $image_name = '/storage/upload/' . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        $content = $dom->saveHTML();

        $checkSendMail = $post->status->value != $request->status;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->status = $request->status;
        $post->description = $request->description;
        $post->content = $content;

        if ($post->status == PostStatusEnum::APPROVED) {
            $post->publish_date = date("Y-m-d H:i:s");
        } else {
            $post->publish_date = null;
        }

        $result = $post->save();

        $post->clearMediaCollection();

        $post
            ->addMediaFromRequest("thumbnail")
            ->toMediaCollection();

        if ($result) {
            Alert::success('Thành công!', 'Cập nhật bài viết thành công!');
            if ($checkSendMail) {
                $job = (new SendMailChangePostStatus($post))->delay(Carbon::now()->addSeconds(10));
                dispatch($job);
            }
            return to_route('admin.posts.index')->with('message', 'Cập nhật bài viết thành công!');
        } else {
            return to_route('admin.posts.index')->with('error', 'Cập nhật bài viết không thành công!');
        }
    }
}
