<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorPost
{
    public function handle(Request $request, Closure $next): Response
    {
        $post = $request->route("post");
        if(Auth::id() != $post->user_id){
            abort(404);
        }
        return $next($request);
    }
}