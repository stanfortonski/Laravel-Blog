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
    Route::get('/set-lang/{lang}', 'AdminController@setLang')->name('set-lang');

    Route::middleware('auth')->group(function(){
        Route::get('/', 'AdminController@index')->name('index');

        Route::get('/files-manager', 'AdminController@filesManager')->name('files-manager');

        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function(){
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::put('/posts/{post}/image', 'PostsController@updateImage')->name('posts.image.update');
        Route::delete('/posts/{post}/image', 'PostsController@destroyImage')->name('posts.image.destroy');
        Route::resource('posts', 'PostsController')->except('show');

        Route::delete('/post-content/{postContent}', 'ContentController@deletePostContent')->name('post-content.destroy');

        Route::middleware('role:admin')->group(function(){
            Route::delete('/content/{content}', 'ContentController@deleteCategoryContent')->name('content.destroy');

            Route::put('/users/{user}/image', 'UsersController@updateImage')->name('users.image.update');
            Route::delete('/users/{user}/image', 'UsersController@destroyImage')->name('users.image.destroy');
            Route::put('/users/{user}/password', 'UsersPasswordController')->name('users.password');
            Route::resource('users', 'UsersController')->except('show');

            Route::put('/categories/{category}/image', 'CategoriesController@updateImage')->name('categories.image.update');
            Route::delete('/categories/{category}/image', 'CategoriesController@destroyImage')->name('categories.image.destroy');
            Route::resource('categories', 'CategoriesController')->except('show');
        });

        Route::group([
            'as' => 'user-panel.',
            'prefix' => 'user-panel'
        ], function(){
            Route::get('/', 'UserPanelController@index')->name('index');
            Route::put('/', 'UserPanelController@update')->name('update');
            Route::put('/password', 'UserPanelController@updatePassword')->name('password');
            Route::put('/image', 'UserPanelController@updateImage')->name('image.update');
            Route::delete('/image', 'UserPanelController@destroyImage')->name('image.destroy');
        });
    });
});
