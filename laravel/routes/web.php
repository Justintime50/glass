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

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

// Admin
Route::get('/admin', function () {
    return view('admin');
});

// Posts
Route::get('/posts', 'PostsController@readPosts');
Route::get('/{user}/{slug}', 'PostsController@read');
Route::get('/edit-post/{user}/{slug}', 'PostsController@readEdit');

Route::post('/create-post', 'PostsController@create');
Route::post('/update-post', 'PostsController@update');
Route::post('/delete-post', 'PostsController@delete');
