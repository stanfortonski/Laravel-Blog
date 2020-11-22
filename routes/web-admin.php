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

Route::group([
    'domain' => 'admin.'.config('app.url'),
    'namespace' => 'Admin',
    'as' => 'admin.'
], function(){
    Route::get('/', 'AdminController@index')->name('index');

    Route::resource('posts', 'PostsController')->except('show');

    Route::middleware('role:admin')->group(function(){
        Route::resource('users', 'UsersController')->except('show');
        Route::resource('categories', 'CategoriesController')->except('show');
    });
});
