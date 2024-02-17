<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home')->middleware(['auth', 'check_user_status']);

// admin
Route::prefix('/admin')->middleware(['auth', 'check_user_status', 'check_admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [AdminUserController::class, 'profile'])->name('profile');

    Route::post('/profile', [AdminUserController::class, 'postProfile']);

    Route::get('/change-password', [AdminUserController::class, 'changePassword'])->name('change_password');

    Route::post('/change-password', [AdminUserController::class, 'postChangePassword']);

    // users
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');

        Route::get('/edit/{user}', [AdminUserController::class, 'edit'])->name('edit');

        Route::put('/edit/{user}', [AdminUserController::class, 'postEdit'])->name('post_edit');

        Route::get("/data", [AdminUserController::class, 'data'])->name('data');
    });

    // posts
    Route::prefix('/posts')->name('posts.')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('index');

        Route::get('/edit/{post}', [AdminPostController::class, 'edit'])->name('edit');

        Route::put('/edit/{post}', [AdminPostController::class, 'postEdit'])->name("post_edit");

        Route::get("/data", [AdminPostController::class, 'data'])->name('data');

        Route::get('/data-client', [AdminPostController::class, 'dataClient'])->name('data_client');
    });
});

// Auth
Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->middleware('guest')->name('register');

    Route::post('/register', [RegisterController::class, 'postRegister']);

    Route::get('/login', [LoginController::class, 'login'])->middleware('guest')->name('login');

    Route::post('/login', [LoginController::class, 'postLogin']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->middleware('guest')->name('forgot_password');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'postForgotPassword']);

    Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.reset');

Route::post('/auth/reset-password', [ResetPasswordController::class, 'postResetPassword'])->middleware('guest')->name('password.edit');


// Posts
Route::resource('posts', PostController::class)->middleware(['auth', 'check_user_status']);

Route::prefix('/news')->name('news.')->group(function () {
    Route::get('/', [NewController::class, 'index'])->name('list');

    Route::get('/{post:slug}', [NewController::class, 'show'])->middleware('check_post_status_approved')->name('detail');
});

// Users
Route::prefix('users')->name('users.')->middleware(['auth', 'check_user_status'])->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile');

    Route::post('profile', [UserController::class, 'postProfile']);

    Route::delete('delete-all-post', [UserController::class, 'deleteAllPost'])->name('delete_all_post');
});

// File manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth', 'check_user_status']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
