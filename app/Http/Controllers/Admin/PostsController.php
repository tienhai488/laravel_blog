<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    protected PostService $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    /**
     * get list Post
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $filter = [
            'title' => $request->title,
            'email' => $request->email,
            'status' => $request->status,
        ];

        $posts = $this->postService->getAllPost($filter);
        $user = Auth::user();
        $title = 'Danh sách bài viết';
        return view('admin.posts.list', compact('title', 'posts', 'user'));
    }

    /**
     * get update post
     *
     * @param Post $post
     * @return void
     */
    /**
     * Undocumented function
     *
     * @param Post $post
     * @return void
     */
    public function update(Post $post)
    {
        $user = Auth::user();
        $title = 'Cập nhật bài viết';
        return view('admin.posts.update', compact('title', 'post', 'user'));
    }

    /**
     *
     *
     * @param \App\Http\Requests\PostRequest $request
     * @param Post $post
     * @return void
     */
    public function postUpdate(PostRequest $request, Post $post)
    {
        $content = $request->content;
        $content = $this->postService->handleContent($content);

        $checkSendMail = $post->status->value != $request->status;

        $dataUpdate = [
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'description' => $request->description,
            'content' => $content,
        ];

        if ($post->isApproved()) {
            $dataUpdate['publish_date'] = date('Y-m-d H:i:s');
        } else {
            $dataUpdate['publish_date'] = null;
        }

        $result = $this->postService->updatePost($post, $dataUpdate);

        if ($result) {
            Alert::success('Thành công!', 'Cập nhật bài viết thành công!');
            $this->postService->sendMailChangePostStatus($post, $checkSendMail);

            return to_route('admin.posts.index')->with('message', 'Cập nhật bài viết thành công!');
        }
        return to_route('admin.posts.index')->with('error', 'Cập nhật bài viết không thành công!');
    }
}
