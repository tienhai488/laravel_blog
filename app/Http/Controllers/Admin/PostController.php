<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
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
        return view('admin.posts.index', compact('title', 'posts', 'user'));
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
    public function edit(Post $post)
    {
        $thumbnail = $post->getFirstMediaUrl('thumbnail');
        $user = Auth::user();
        $title = 'Cập nhật bài viết';
        return view('admin.posts.edit', compact('title', 'post', 'user', 'thumbnail'));
    }

    /**
     *
     *
     * @param \App\Http\Requests\PostRequest $request
     * @param Post $post
     * @return void
     */
    public function postEdit(PostRequest $request, Post $post)
    {
        $content = $request->content;
        $this->postService->handleContent($post, $content);

        $checkSendMail = $post->status->value != $request->status;

        $dataEdit = [
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'description' => $request->description,
        ];

        if ($post->isApproved()) {
            $dataEdit['publish_date'] = date('Y-m-d H:i:s');
        } else {
            $dataEdit['publish_date'] = null;
        }

        $thumbnail = $request->thumbnail;
        $this->postService->editPost($post, $dataEdit, $thumbnail);

        Alert::success('Thành công!', 'Cập nhật bài viết thành công!');
        $this->postService->sendMailChangePostStatus($post, $checkSendMail);

        return to_route('admin.posts.index')->with('message', 'Cập nhật bài viết thành công!');
    }

    public function data(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $title = $request->title ?? '';
        $email = $request->email ?? '';
        $status = $request->status ?? '';

        $posts = $this->postService->filterData($title, $email, $status);

        return DataTables::of($posts)
            ->editColumn('thumbnail', function ($post) {
                $thumbnail = $post->thumbnail;
                $slug = $post->slug;
                return '<img style="width: 200px"
                src="' . $thumbnail . '"
                alt="' . $slug . '">';
            })
            ->editColumn('author', function ($post) {
                return $post->user->name . ' (' . $post->user->email . ')';
            })
            ->editColumn('status', function (Post $post) {
                return getButtonPostStatus($post);
            })
            ->editColumn('publish_date', function ($post) {
                if (empty($post->publish_date))
                    return 'PENDING';
                return Carbon::parse($post->publish_date)->format('Y/m/d H:i:s');
            })
            ->editColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('Y/m/d H:i:s');
            })
            ->editColumn('show', function ($post) {
                return '<a href="' . route('posts.show', $post) . '" class="btn btn-primary">
                    <i class="far fa-file-alt"></i>
                </a>';
            })
            ->editColumn('edit', function ($post) {
                return '<a href="' . route('admin.posts.edit', $post) . '" class="btn btn-warning">
                    <i class="far fa-edit"></i>
                </a>';
            })
            ->rawColumns(['thumbnail', 'status', 'show', 'edit'])
            ->toJson();
    }

    public function dataClient(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $title = $request->title ?? '';
        $status = $request->status ?? '';

        $posts = $this->postService->filterDataClient($title, $status);

        return DataTables::of($posts)
            ->editColumn('title', function ($post) {
                $title = htmlspecialchars($post->title);
                return '<a
                href="' . route('posts.show', $post) . '">' . $title . '</a>';
            })
            ->editColumn('thumbnail', function ($post) {
                $thumbnail = $post->thumbnail;
                $slug = $post->slug;
                return '<img style="width: 200px"
                src="' . $thumbnail . '"
                alt="' . $slug . '">';
            })
            ->editColumn('status', function (Post $post) {
                return getButtonPostStatus($post);
            })
            ->editColumn('publish_date', function ($post) {
                if (empty($post->publish_date))
                    return 'PENDING';
                return Carbon::parse($post->publish_date)->format('Y/m/d H:i:s');
            })
            ->editColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('Y/m/d H:i:s');
            })
            ->editColumn('edit', function ($post) {
                return '<a href="' . route('posts.edit', $post) . '" class="btn btn-warning">
                    <i class="far fa-edit"></i>
                </a>';
            })
            ->editColumn('delete', function ($post) {
                return '<button class="btn btn-danger btn-delete" data-delete-url="' . route('posts.destroy', $post) . '" data-delete-type="delete-post" onclick="onModalDeletePost(event)">
                <i style="pointer-events: none" class="fas fa-trash"></i>
                </button>';
            })
            ->rawColumns(['title', 'thumbnail', 'status', 'edit', 'delete'])
            ->toJson();
    }
}
