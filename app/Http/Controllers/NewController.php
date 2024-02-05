<?php

namespace App\Http\Controllers;

use App\Enum\PostStatusEnum;
use App\Models\Post;

class NewController extends Controller
{
    public function index()
    {
        $posts = Post::where("status", PostStatusEnum::APPROVED)->get();
        $title = "Tin mới";
        return view("news.index", compact("title", "posts"));
    }

    public function show(Post $post)
    {
        $title = "Chi tiết bài viết";
        return view("posts.show", compact("title", "post"));
    }
}
