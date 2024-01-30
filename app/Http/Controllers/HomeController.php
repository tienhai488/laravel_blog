<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Trang chủ';
        return view('home', compact('title'));
    }
}
