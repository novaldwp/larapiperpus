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
                    ->except(['show', 'create']);
                Route::resource('/category', 'API\v1\Master\CategoryController')
                    ->except(['create', 'show']);
                Route::resource('/gender', 'API\v1\Master\GenderController')
                    ->except(['create', 'show']);
                Route::resource('/publisher', 'API\v1\Master\PublisherController')
                    ->except(['create', 'show']);
                Route::resource('/bookshelf', 'API\v1\Master\BookshelfController')
                    ->except(['create', 'show']);

                Route::get('/test', function() {
                    return "coba duluu";
                });
            });

            Route::resource('/book', 'API\v1\Main\BookController')
                ->except(['create', 'show']);
            Route::resource('/member', 'API\v1\Main\MemberController')
                ->except(['create', 'show']);
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
