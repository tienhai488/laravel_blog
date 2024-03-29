<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
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
        return view('posts.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm bài viết';
        return view('posts.create', compact('title'));
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
        $title = 'Cập nhật bài viết';
        return view('posts.edit', compact('title', 'post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $content = $request->content;
        $this->postService->handleContent($post, $content);

        $dataEdit = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
        ];

        $thumbnail = $request->thumbnail;
        $this->postService->editPost($post, $dataEdit, $thumbnail);

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

        $result = Post::destroy($post->id);

        return [
            'result' => $result,
        ];
    }
}
