<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorPost
{
    protected User $user;
    public function handle(Request $request, Closure $next): Response
    {
        $this->user = Auth::user();
        if ($this->user->isAdmin()) {
            return $next($request);
        }
        $post = $request->route("post");
        if ($this->user->id != $post->user_id) {
            abort(404);
        }
        return $next($request);
    }
}
