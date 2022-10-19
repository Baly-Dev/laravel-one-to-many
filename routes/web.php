<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('posts', 'PostController');
        Route::resource('categories', 'CategoryController');
});

Route::get('{any}', function() {
    return view('guest.home');
})->where('any', '.*');