<?php

namespace App\Http\Controllers;

use App\Enum\PostStatusEnum;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $posts = Post::where("status", PostStatusEnum::APPROVED)->get();
        $title = "Tin mới";
        return view("news.list", compact("title", "posts"));
    }

    public function detail(Post $post){
        $title = "Chi tiết bài viết";
        return view("posts.show", compact("title", "post"));
    }
}