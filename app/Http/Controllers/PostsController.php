<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    public function __construct()
    {
    }
    
    public function index(){
        $title = 'Danh sách bài viết';
        return view('posts.list', compact('title'));
    }
}