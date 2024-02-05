<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        return view('home', compact('title'));
    }
}
