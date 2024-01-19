<?php

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    $title = "Trang chủ";
    $user = User::find(1);
    dd($user->name);
    echo "<h1>".$user->name."</h1>";
    return view('home', compact("title"));
});

Route::get('/sendmail', function () {
    $content = [
        'subject' => 'Gửi mail thành công!',
        'body' => '
        Chào bạn <b>TienHai</b><br/>
        Bạn vừa gửi mail thành công!'
    ];

    Mail::to("tienhaile488@gmail.com")->send(new SendMail($content));
});

Route::get("/admin/dashboard",function(){
    $title = "Dashboard";
    return view("dashboard", compact("title"));
});