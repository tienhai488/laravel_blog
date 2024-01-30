<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostsController as AdminPostsController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'check_user_status']);

// admin
Route::prefix('/admin')->middleware(['auth', 'check_user_status', 'check_admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [AdminUsersController::class, 'profile'])->name('profile');

    Route::post('/profile', [AdminUsersController::class, 'postProfile']);

    Route::get('/change-password', [AdminUsersController::class, 'changePassword'])->name('change_password');

    Route::post('/change-password', [AdminUsersController::class, 'postChangePassword']);

    // users
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [AdminUsersController::class, 'index'])->name('index');

        Route::get('/update/{user}', [AdminUsersController::class, 'update'])->name('update');

        Route::put('/update/{user}', [AdminUsersController::class, 'postUpdate'])->name('post_update');
    });

    // posts
    Route::prefix('/posts')->name('posts.')->group(function () {
        Route::get('/', [AdminPostsController::class, 'index'])->name('index');

        Route::get('/update/{post}', [AdminPostsController::class, 'update'])->name('update');

        Route::put('/update/{post}', [AdminPostsController::class, 'postUpdate'])->name("post_update");
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

Route::post('/auth/reset-password', [ResetPasswordController::class, 'postResetPassword'])->middleware('guest')->name('password.update');


// Posts
Route::resource('posts', PostsController::class)->middleware(['auth', 'check_user_status']);

Route::prefix('/news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('list');

    Route::get('/{post:slug}', [NewsController::class, 'detail'])->middleware('check_post_status_approved')->name('detail');
});

// Users
Route::prefix('users')->name('users.')->middleware(['auth', 'check_user_status'])->group(function () {
    Route::get('profile', [UsersController::class, 'profile'])->name('profile');

    Route::post('profile', [UsersController::class, 'postProfile']);

    Route::delete('delete-all-post', [UsersController::class, 'deleteAllPost'])->name('delete_all_post');
});

// File manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth', 'check_user_status']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
