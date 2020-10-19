<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::post('/login', 'API\v1\Auth\AuthController@login')->name('login');

    Route::group(['middleware' => 'auth:sanctum'], function() {

        Route::post('/register', 'API\v1\Auth\AuthController@register')->name('register');
        Route::get('/logout', 'API\v1\Auth\AuthController@logout')->name('logout');

        Route::group(['middleware' => 'cekRole:1'], function() {
            Route::group(['prefix' => 'master', 'as' => 'master.'], function() {
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
            });

            Route::resource('/book', 'API\v1\Main\BookController')
                ->except(['create', 'show']);
            Route::resource('/member', 'API\v1\Main\MemberController')
                ->except(['create', 'show']);
            Route::resource('/user', 'API\v1\Main\UserController')
                ->except(['create', 'show']);

            Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function() {
                Route::get('/stock', 'API\v1\Inventory\StockController@index');
                Route::get('/stock/{id}', 'API\v1\Inventory\StockController@show');
                Route::post('/stock-in', 'API\v1\Inventory\StockController@stockIn');
                Route::post('/stock-out', 'API\v1\Inventory\StockController@stockOut');
            });

            Route::group(['prefix' => 'setting', 'as' => 'setting.'], function() {
                Route::get('/duration', 'API\v1\Setting\DurationController@index');
                Route::post('/duration', 'API\v1\Setting\DurationController@store');
            });
        });
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
