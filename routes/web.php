<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Trang chủ";
    $user = User::find(1);
    dd($user->name);
    echo "<h1>".$user->name."</h1>";
    return view('home', compact("title"));
})->name("home");

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

Route::prefix("/auth")->name("auth.")->group(function(){
    Route::get("/register", [AuthController::class, "register"])->name("register");

    Route::post("/register", [AuthController::class, "postRegister"])->name("postRegister");

    Route::get("/login", [AuthController::class, "login"])->name("login");

    Route::post("/login", [AuthController::class, "postLogin"])->name("postLogin");

    Route::get("/forgot", [AuthController::class, "forgot"])->name("forgot");

    Route::post("/forgot", [AuthController::class, "postForgot"])->name("postForgot");

    Route::get("/logout", [AuthController::class, "logout"])->name("logout");
});

Route::prefix("posts")->name("posts.")->group(function(){
    Route::get("/", [PostsController::class, "index"])->middleware(["auth", "user_status"])->name("list");
});