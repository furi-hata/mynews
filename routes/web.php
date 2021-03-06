<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin' , 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create'); // 4-15追記
    Route::get('news', 'Admin\NewsController@index'); // 4-17追記
    Route::get('news/edit', 'Admin\NewsController@edit'); // 4-18追記
    Route::post('news/edit', 'Admin\NewsController@update'); // 4-18追記
    Route::get('news/delete', 'Admin\NewsController@delete'); // 4-18追記
    Route::get('profile/create','Admin\ProfileController@add');
    Route::post('profile/create','Admin\ProfileController@create'); // 4-15追記
    Route::get('profile', 'Admin\ProfileController@index'); // 4-17追記
    Route::get('profile/edit','Admin\ProfileController@edit');
    Route::post('profile/edit','Admin\ProfileController@update'); // 4-15追記
    Route::get('profile/delete', 'Admin\ProfileController@delete'); // 4-18追記
  });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'NewsController@index'); // 4-20追記
