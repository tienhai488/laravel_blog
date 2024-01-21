<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    public function index()
    {
        $title = 'Danh sách bài viết ';
        $user = Auth::user();
        $posts = $user->posts;
        $titleDelete = 'Delete Post!';
        $textDelete = 'Are you sure you want to delete?';
        confirmDelete($titleDelete, $textDelete);
        return view('posts.list', compact('title', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $title = 'Chi tiết bài viết';
        return view('posts.show', compact('title', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $title = 'Cập nhật bài viết';
        return view('posts.show', compact('title', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(empty($post)){
            return redirect('posts.list')->with('error', 'Không tồn tại bài viết vui lòng kiểm tra lại!');
        }

        // $post->delete();
        $result = Post::destroy($post->id);

        if($result > 0){
            Alert::success('Thành công', 'Xóa bài viết thành công');
            $message = 'Xóa bài viết thành công!';
        }
        else{
            $message = 'Xóa bài viết không thành công!';
        }
        return to_route('posts.index')->with('message', $message);
    }
}