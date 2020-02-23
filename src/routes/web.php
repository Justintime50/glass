<?php

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

// No middleware
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes();

Route::get('/', 'PostController@readPosts')->name('/');
Route::get('/posts', 'PostController@readPosts')->name('posts');
Route::get('/{user}/{slug}', 'PostController@read');


// Must be an Admin
Route::middleware('Admin')->group(function () {
    Route::get('/admin', 'AdminController@read')->name('admin');
    Route::get('/edit-post/{user}/{slug}', 'PostController@readEdit')->name('edit-post');
    Route::get('/create-post', 'PostController@readCreate')->name('create-post');
    Route::get('/images', 'PostController@readImages')->name('images');
    Route::get('/comments', 'CommentController@readComments')->name('comments');

    Route::post('/update-settings', 'AdminController@update')->name('update-settings');
    Route::post('/update-user-role', 'AdminController@updateUserRole')->name('update-user-role');
    Route::post('/create-post', 'PostController@create')->name('create-post');
    Route::post('/update-post', 'PostController@update')->name('update-post');
    Route::post('/delete-post', 'PostController@delete')->name('delete-post');
    Route::post('/upload-image', 'PostController@uploadPostImage')->name('upload-image');
    Route::post('/delete-image', 'PostController@deletePostImage')->name('delete-image');
    Route::post('/create-category', 'CategoryController@create')->name('create-category');
    Route::post('/update-category', 'CategoryController@update')->name('update-category');
    Route::post('/delete-category', 'CategoryController@delete')->name('delete-category');
    Route::post('/delete-user', 'UserController@delete')->name('delete-user');
});


// Must be logged in
Route::middleware('auth')->group(function () {
    Route::post('/create-comment', 'CommentController@create')->name('create-comment');
    Route::post('/delete-comment', 'CommentController@delete')->name('delete-comment');
    Route::post('/update-profile', 'UserController@update')->name('update-profile');
    Route::post('/update-profile-pic', 'UserController@updateProfilePic')->name('update-profile-pic');

    Route::get('/profile', 'UserController@read')->name('profile');
});
