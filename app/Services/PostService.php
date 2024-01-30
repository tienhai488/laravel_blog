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

    public function handleContent($content)
    {
        $dom = new DOMDocument();

        @$dom->loadHTML("<meta charset='utf8'>" . $content);

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
        return $dom->saveHTML();
    }

    public function addPost($dataPost)
    {
        $post = Post::create($dataPost);
        if (empty($post)) {
            return false;
        }

        $post
            ->addMediaFromRequest("thumbnail")
            ->toMediaCollection();
        return true;
    }

    public function updatePost(Post $post, $dataUpdate)
    {
        $result = $post->update($dataUpdate);

        $post->clearMediaCollection();

        $post
            ->addMediaFromRequest("thumbnail")
            ->toMediaCollection();

        return $result;
    }

    public function sendMailChangePostStatus(Post $post = null, $checkSendMail = false)
    {
        if ($checkSendMail) {
            $job = (new SendMailChangePostStatus($post))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);
        }
    }
}
