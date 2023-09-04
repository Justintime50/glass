<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth routes
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Auth::routes();

// Landing pages
Route::get('/', [App\Http\Controllers\PostController::class, 'readPosts']);
Route::get('/blog', [App\Http\Controllers\PostController::class, 'readPosts']);
Route::get('/posts', [App\Http\Controllers\PostController::class, 'readPosts']);

// Misc
Route::get('/posts/{category}', [App\Http\Controllers\PostController::class, 'readPostsByCategory']);
Route::get('/{user}/{slug}', [App\Http\Controllers\PostController::class, 'read']);
Route::get('feed', [App\Http\Controllers\RssFeedController::class, 'feed']);


// Must be an Admin
Route::middleware('Admin')->group(function () {
    // General
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'showAdminDashboard']);
    Route::patch('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings']);
    // Posts
    Route::get('/create-post', [App\Http\Controllers\PostController::class, 'readCreate']);
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'create']);
    Route::get('/posts/edit/{user}/{slug}', [App\Http\Controllers\PostController::class, 'readEdit']);
    Route::patch('/posts/{id}', [App\Http\Controllers\PostController::class, 'update']);
    Route::delete('/posts/{id}', [App\Http\Controllers\PostController::class, 'delete']);
    // Images
    Route::get('/images', [App\Http\Controllers\PostController::class, 'readImages']);
    Route::post('/images', [App\Http\Controllers\PostController::class, 'uploadPostImage']);
    Route::delete('/images/{id}', [App\Http\Controllers\PostController::class, 'deletePostImage']);
    // Comments
    Route::get('/comments', [App\Http\Controllers\CommentController::class, 'readComments']);
    // Category
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'create']);
    Route::patch('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'delete']);
    // User
    Route::patch('/users/role', [App\Http\Controllers\AdminController::class, 'updateUserRole']);
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'delete']);
});


// Must be logged in
Route::middleware('auth')->group(function () {
    // Comments
    Route::post('/comments', [App\Http\Controllers\CommentController::class, 'create']);
    Route::delete('/comments/{id}', [App\Http\Controllers\CommentController::class, 'delete']);
    // Logged in user
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'read']);
    Route::patch('/update-profile', [App\Http\Controllers\UserController::class, 'update']);
    Route::post('/update-password', [App\Http\Controllers\UserController::class, 'updatePassword']);
    Route::post('/update-profile-pic', [App\Http\Controllers\UserController::class, 'updateProfilePic']);
});
