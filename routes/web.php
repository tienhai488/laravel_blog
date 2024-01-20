<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Trang chủ";
    return view('home', compact("title"));
})->name("home")->middleware("auth");

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

// Auth
Route::prefix("/auth")->name("auth.")->group(function(){
    Route::get("/register", [RegisterController::class, "register"])->middleware("guest")->name("register");

    Route::post("/register", [RegisterController::class, "postRegister"])->name("postRegister");

    Route::get("/login", [LoginController::class, "login"])->middleware("guest")->name("login");

    Route::post("/login", [LoginController::class, "postLogin"])->name("postLogin");

    Route::get("/forgot-password", [ForgotPasswordController::class, "forgotPassword"])->middleware("guest")->name("forgotPassword");

    Route::post("/forgot-password", [ForgotPasswordController::class, "postForgotPassword"])->name("postForgotPassword");
    
    Route::post("/reset-password", [ResetPasswordController::class, "postResetPassword"])->name("postResetPassword");

    Route::get("/logout", [LoginController::class, "logout"])->middleware("auth")->name("logout");
}); 

Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, "resetPassword"])->middleware('guest')->name('password.reset');

Route::post('/auth/reset-password', [ResetPasswordController::class, "postResetPassword"])->middleware('guest')->name('password.update');


// Posts
Route::prefix("posts")->name("posts.")->group(function(){
    Route::get("/", [PostsController::class, "index"])->middleware(["auth", "user_status"])->name("list");
});

// Users
Route::prefix("users")->name("users.")->middleware("auth")->group(function(){
    Route::get("profile", [UsersController::class, "profile"])->name("profile");

    Route::post("profile", [UsersController::class, "postProfile"])->name("postProfile");
});