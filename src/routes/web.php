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
    Route::post('/update-settings', 'AdminController@update')->name('update-settings');
    Route::get('/edit-post/{user}/{slug}', 'PostController@readEdit');
    Route::get('/create-post', function () {
        return view('create-post');
    })->name('create-post');

    Route::post('/create-post', 'PostController@create')->name('create-post');
    Route::post('/update-post', 'PostController@update')->name('update-post');
    Route::post('/delete-post', 'PostController@delete')->name('delete-post');

    Route::get('/comments', 'CommentController@readComments')->name('comments');
});


// Must be logged in
Route::middleware('auth')->group(function () {
    Route::post('/create-comment', 'CommentController@create')->name('create-comment');
    Route::post('/delete-comment', 'CommentController@delete')->name('delete-comment');
    Route::post('/update-profile', 'UserController@update')->name('update-profile');
    Route::post('/update-profile-pic', 'UserController@updateProfilePic');

    Route::get('/profile', 'UserController@read')->name('profile');
});
