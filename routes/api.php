<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::post('/login', 'API\v1\Auth\AuthController@login')->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function() {

        Route::post('/register', 'API\v1\Auth\AuthController@register')->name('register');
        Route::get('/logout', 'API\v1\Auth\AuthController@logout')->name('logout');

        Route::group(['middleware' => 'cekRole:1'], function() {
            Route::group(['prefix' => 'master'], function() {
                Route::resource('/author', 'API\v1\Master\AuthorController')
                    ->except(['show']);
                Route::get('/test', function() {
                    return "coba duluu";
                });
            });
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
