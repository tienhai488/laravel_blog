<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;

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
    public function store(PostRequest $request)
    {
        $content = $request->content;

        $dom = new DOMDocument();

        // Load HTML content
        // libxml_use_internal_errors(true); // Disable libxml errors to handle invalid HTML
        // @$dom->loadHTML('<meta charset='utf8'>' .$content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        @$dom->loadHTML("<meta charset='utf8'>" .$content);
        // libxml_clear_errors(); // Clear libxml errors

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            if (strpos($img->getAttribute('src'), 'data:image') === 0) {
                $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                $image_name = '/storage/upload/' . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        $content = $dom->saveHTML();

        $post = new Post();

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->content = $content;
        $post->user_id = Auth::id();

        $result = $post->save();

        // $thumbnail = $request->file('thumbnail');
        // $thumbnail = $request->thumbnail;

        // $thumbnail = public_path().'/storage'.explode('storage', $thumbnail)[1];
        $post
        // ->addMedia($thumbnail)
        ->addMediaFromRequest("thumbnail")
        ->toMediaCollection();

        if($result){
            Alert::success('Thành công!', 'Thêm bài viết thành công!');
            return to_route('posts.index')->with('message', 'Thêm bài viết thành công!');
        }
        else{
            return to_route('posts.index')->with('error', 'Thêm bài viết không thành công!');
        }


        // $file = $request->file('thumbnail');
        // storage_path('/app/public/3/bdbp1.jpg');
        // $post
        // ->addMediaFromRequest('thumbnail')
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

    public function edit(Post $post, Request $request)
    {
        $title = 'Cập nhật bài viết';
        return view('posts.update', compact('title', 'post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        // $thumbnailPath = $request->thumbnail;

        // $response = Http::get($thumbnailPath);

        // // Lấy nội dung của phản hồi
        // $content = $response->body();


        // $fileName = pathinfo($thumbnailPath, PATHINFO_FILENAME);
        // $ext = pathinfo($thumbnailPath, PATHINFO_EXTENSION);

        // $file_path = public_path('storage/'."$fileName.$ext");
        // file_put_contents($file_path, $content);

        // dd($file_path);

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

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->content = $content;

        $result = $post->save();

        $post->clearMediaCollection();

        // $thumbnailPath = $request->input('thumbnail');

        // // Lấy nội dung của file
        // $thumbnailContent = Storage::get($thumbnailPath);

        // $fileName = pathinfo($thumbnailPath, PATHINFO_FILENAME);
        // $ext = pathinfo($thumbnailPath, PATHINFO_EXTENSION);
        // Storage::put( public_path().'/storage/'.$fileName .'.'. $ext, $thumbnailContent);


        // $thumbnail = $request->thumbnail;
        // $thumbnail = public_path().'/storage'.explode('storage', $thumbnail)[1];

        // $data = $post->thumbnail;


        // file_put_contents($thumbnail, $data);

        // $thumbnail = $request->file('thumbnail');

        $post
            // ->addMedia($thumbnailPath)
            ->addMediaFromRequest("thumbnail")
            ->toMediaCollection();


        if ($result) {
            Alert::success('Thành công!', 'Cập nhật bài viết thành công!');
            return to_route('posts.index')->with('message', 'Cập nhật bài viết thành công!');
        } else {
            return to_route('posts.index')->with('error', 'Cập nhật bài viết không thành công!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (empty($post)) {
            return redirect('posts.list')->with('error', 'Không tồn tại bài viết vui lòng kiểm tra lại!');
        }

        // $post->delete();
        $result = Post::destroy($post->id);

        if ($result > 0) {
            Alert::success('Thành công', 'Xóa bài viết thành công');
            $message = 'Xóa bài viết thành công!';
        } else {
            $message = 'Xóa bài viết không thành công!';
        }
        return to_route('posts.index')->with('message', $message);
    }
}
