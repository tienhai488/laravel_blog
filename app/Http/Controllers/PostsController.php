<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use DOMDocument;
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
        $title = 'Thêm bài viết';
        return view('posts.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $content = $request->content;

        $dom = new DOMDocument();
        $dom->loadHTML('<meta charset="utf8">'.$content);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
            $image_name = "/storage/upload/" . time(). $key.'.png';
            file_put_contents(public_path().$image_name, $data);

            $img->removeAttribute('src');
            $img->setAttribute('src',$image_name);
        }
        $content = $dom->saveHTML();

        $post = new Post();

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->content = $content;
        $post->user_id = Auth::id();

        $result = $post->save();

        $thumbnail = $request->thumbnail;
        $post
        ->addMedia(public_path().'/storage'.explode("storage", $thumbnail)[1])
        ->toMediaCollection();

        if($result){
            Alert::success('Thành công!', "Thêm bài viết thành công!");
            return to_route('posts.index')->with('message', "Thêm bài viết thành công!");
        }
        else{
            return to_route('posts.index')->with('error', "Thêm bài viết không thành công!");
        }


        // $file = $request->file("thumbnail");
        // storage_path("/app/public/3/bdbp1.jpg");
        // $post
        // ->addMediaFromRequest("thumbnail")
        // ->usingName($post->slug)
        // ->addMediaFromDisk('/assets/client/posts', 's3')
        // ->toMediaCollection();
        // $name = $file->getClientOriginalName();
        // $post
        // ->addMedia(public_path('/images/'.$name))
        // ->usingName($post->slug)
        // // ->addMediaFromDisk('/assets/client/posts', 's3')
        // ->toMediaCollection();
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
