<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show Dashboard
     *
     * @return void
     */
    public function index()
    {
        $user = Auth::user();
        $title = 'Dashboard';
        return view('admin.dashboard.dashboard', compact('title', 'user'));
    }
}
