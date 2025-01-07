<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RssFeedController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/logout', [LoginController::class, 'logout']);
Auth::routes();

// Post pages
Route::get('/', [PostController::class, 'showPosts']);
Route::get('/posts', [PostController::class, 'showPosts']);
Route::get('/posts/category/{category}', [PostController::class, 'showPostsByCategory']);
Route::get('/posts/user/{user}', [PostController::class, 'showPostsByUser']);
Route::get('/posts/{user}/{slug}', [PostController::class, 'showPost']);
// Kept for legacy links, should instead us the route prepended with `/posts`
Route::get('/{user}/{slug}', [PostController::class, 'showPost']);
Route::get('/feed', [RssFeedController::class, 'getFeed']);

// Must be an Admin
Route::middleware(Admin::class)->group(function () {
    // General
    Route::get('/admin', [AdminController::class, 'showAdminDashboard']);
    Route::patch('/settings', [AdminController::class, 'updateSettings']);
    // Posts
    Route::get('/create-post', [PostController::class, 'showCreatePage']);
    Route::post('/posts', [PostController::class, 'create']);
    Route::get('/posts/edit/{user}/{slug}', [PostController::class, 'showEditPage']);
    Route::patch('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'delete']);
    // Images
    Route::get('/images', [ImageController::class, 'showImagesPage']);
    Route::post('/images', [ImageController::class, 'uploadPostImage']);
    Route::delete('/images/{id}', [ImageController::class, 'deletePostImage']);
    // Comments
    Route::get('/comments', [CommentController::class, 'showComments']);
    // Category
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::patch('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'delete']);
    // User
    Route::patch('/users/role', [AdminController::class, 'updateUserRole']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

// Must be logged in
Route::middleware(Authenticate::class)->group(function () {
    // Comments
    Route::post('/comments', [CommentController::class, 'create']);
    Route::delete('/comments/{id}', [CommentController::class, 'delete']);
    // Logged in user
    Route::get('/profile', [UserController::class, 'showProfile']);
    Route::patch('/update-profile', [UserController::class, 'update']);
    Route::post('/update-password', [UserController::class, 'updatePassword']);
    Route::post('/update-profile-pic', [UserController::class, 'updateProfilePic']);
});
