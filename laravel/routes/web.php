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
Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/', 'PostsController@readPosts');
Route::get('/posts', 'PostsController@readPosts');
Route::get('/{user}/{slug}', 'PostsController@read');


// Must be an Admin
Route::middleware('Admin')->group(function () {
    Route::get('/admin', 'AdminController@read');
    Route::post('/update-settings', 'AdminController@update');
    Route::get('/edit-post/{user}/{slug}', 'PostsController@readEdit');
    Route::get('/create-post', function () {
        return view('create-post');
    });

    Route::post('/create-post', 'PostsController@create');
    Route::post('/update-post', 'PostsController@update');
    Route::post('/delete-post', 'PostsController@delete');

    Route::get('/comments', 'CommentsController@readComments');
});


// Must be logged in
Route::middleware('auth')->group(function () {
    Route::post('/create-comment', 'CommentsController@create');
    Route::post('/delete-comment', 'CommentsController@delete');
    Route::post('/update-profile', 'UsersController@update');
    
    Route::get('/profile', 'UsersController@read');
});