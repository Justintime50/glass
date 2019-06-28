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
Route::get('/create-post', 'PostsController@create');
Route::get('/{user}/{slug}', 'PostsController@read');
Route::get('/edit-post', 'PostsController@edit');
Route::get('/delete-post', 'PostsController@delete');
