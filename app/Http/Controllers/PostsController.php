<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    protected PostService $postService;
    protected $user;

    public function __construct()
    {
        $this->postService = new PostService();
        $this->middleware('check_author_post')->except(['index', 'create', 'store']);
        $this->user = Auth::user();
    }

    public function index()
    {
        $title = 'Danh sách bài viết ';
        $titleDelete = 'Delete Post!';
        $textDelete = 'Are you sure you want to delete?';
        confirmDelete($titleDelete, $textDelete);
        return view('posts.list', compact('title'));
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
        $dataPost = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'content' => ''
        ];

        $thumbnail = $request->thumbnail;
        $post = $this->postService->addPost($dataPost, $thumbnail);

        $content = $request->content;
        $this->postService->handleContent($post, $content);

        Alert::success('Thành công!', 'Thêm bài viết thành công!');
        return to_route('posts.index')->with('message', 'Thêm bài viết thành công!');
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
     * Undocumented function
     *
     * @param Post $post
     * @param Request $request
     * @return void
     */
    public function edit(Post $post, Request $request)
    {
        $thumbnail = $post->getFirstMediaUrl('thumbnail');
        $title = 'Cập nhật bài viết';
        return view('posts.update', compact('title', 'post', 'thumbnail'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $content = $request->content;
        $this->postService->handleContent($post, $content);

        $dataUpdate = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
        ];

        $thumbnail = $request->thumbnail;
        $this->postService->updatePost($post, $dataUpdate, $thumbnail);

        Alert::success('Thành công!', 'Cập nhật bài viết thành công!');
        return to_route('posts.index')->with('message', 'Cập nhật bài viết thành công!');
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
        }
        $message = 'Xóa bài viết không thành công!';
        return to_route('posts.index')->with('message', $message);
    }
}