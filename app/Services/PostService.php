<?php

namespace App\Services;

use App\Jobs\SendMailChangePostStatus;
use App\Models\Post;
use Carbon\Carbon;
use DOMDocument;

class PostService
{
    public function getAllPost($filter)
    {
        if (empty($filter)) {
            return Post::all();
        }

        $posts = Post::with('user');
        if ($filter['title'] != '') {
            $posts = $posts->where('title', 'like', '%' . $filter['title'] . '%');
        }

        if ($filter['email'] != '') {
            $email = $filter['email'];
            $posts = $posts->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });
        }

        if ($filter['status'] != '') {
            $posts = $posts->where('status', $filter['status']);
        }

        return $posts->get();
    }

    public function handleContent(Post $post, $content)
    {
        $dom = new DOMDocument();

        @$dom->loadHTML("<meta charset='utf8'>" . $content);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            if (strpos($img->getAttribute('src'), 'data:image') === 0) {
                $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                $image_name = time() . $key;

                $mediaItem = $post
                    ->addMediaFromString($data)
                    ->usingFileName($image_name)
                    ->toMediaCollection('images', 'public');

                $img->removeAttribute('src');
                $url = $mediaItem->getUrl();
                $img->setAttribute('src', parse_url($url)['path']);
            }
        }
        $content = $dom->saveHTML();
        $post->content = $content;
        $post->save();
    }

    public function addPost($dataPost, $thumbnail)
    {
        $post = Post::create($dataPost);
        $post
            ->addMedia(public_path("") . $thumbnail)
            ->usingName($post->slug)
            ->toMediaCollection("thumbnail");

        return $post;
    }

    public function updatePost(Post $post, $dataUpdate, $thumbnail)
    {
        $post->update($dataUpdate);
        if ($post->getFirstMediaUrl('thumbnail') != $thumbnail) {
            $post->clearMediaCollection('thumbnail');
            $post
                ->addMedia(public_path("") . $thumbnail)
                ->usingName($post->slug)
                ->toMediaCollection("thumbnail");
        }
        return $post;
    }

    public function sendMailChangePostStatus(Post $post = null, $checkSendMail = false)
    {
        if ($checkSendMail) {
            $job = (new SendMailChangePostStatus($post))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);
        }
    }
}
