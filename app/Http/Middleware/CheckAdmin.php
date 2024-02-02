<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    protected User $user;
    public function handle(Request $request, Closure $next): Response
    {
        $this->user = Auth::user();
        if (!$this->user->isAdmin()) {
            abort(404);
        }
        return $next($request);
    }
}