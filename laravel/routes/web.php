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

Route::get('/', 'PostsController@readPosts')->name('/');
Route::get('/posts', 'PostsController@readPosts')->name('posts');
Route::get('/{user}/{slug}', 'PostsController@read');


// Must be an Admin
Route::middleware('Admin')->group(function () {
    Route::get('/admin', 'AdminController@read')->name('admin');
    Route::post('/update-settings', 'AdminController@update')->name('update-settings');
    Route::get('/edit-post/{user}/{slug}', 'PostsController@readEdit');
    Route::get('/create-post', function () {
        return view('create-post');
    })->name('create-post');

    Route::post('/create-post', 'PostsController@create')->name('create-post');
    Route::post('/update-post', 'PostsController@update')->name('update-post');
    Route::post('/delete-post', 'PostsController@delete')->name('delete-post');

    Route::get('/comments', 'CommentsController@readComments')->name('comments');
});


// Must be logged in
Route::middleware('auth')->group(function () {
    Route::post('/create-comment', 'CommentsController@create')->name('create-comment');
    Route::post('/delete-comment', 'CommentsController@delete')->name('delete-comment');
    Route::post('/update-profile', 'UsersController@update')->name('update-profile');
    
    Route::get('/profile', 'UsersController@read')->name('profile');
});
