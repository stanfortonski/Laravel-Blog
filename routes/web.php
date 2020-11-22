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

Route::domain(config('app.url'))->group(function(){
    Route::get('/', 'AppController@index')->name('index');
    Route::get('/about', 'AppController@about')->name('about');
    Route::get('/privacy-policy', 'AppController@privacyPolicy')->name('privacy-policy');
    Route::get('/authors/{author}', 'AuthorsController')->name('author');

    Route::resource('posts', 'PostsController')->only(['index', 'show']);
    Route::resource('categories', 'CategoriesController')->only(['index', 'show']);
});
