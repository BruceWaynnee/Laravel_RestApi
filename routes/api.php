<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication Routes
Route::group([
    'prefix' => 'users',
], function(){
    Route::post('/register', 'AuthController@register')->name('user-register');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/logout', 'AuthController@logout')->name('logout')->middleware('auth:sanctum');
});

// API Routers
Route::group([
    'namespace' => 'API',
], function(){

    // product api routes
    Route::group([
        'prefix' => 'products',
    ], function(){
        Route::get('/', 'ProductController@index')->name('product-list');
        Route::post('/', 'ProductController@store')->name('product-create')->middleware('auth:sanctum');
        Route::get('/{id}', 'ProductController@show')->name('product-show');
        Route::get('/search/{field}/{value}', 'ProductController@search')->name('product-search');
        Route::patch('/{id}/edit', 'ProductController@update')->name('product-update')->middleware('auth:sanctum');
        Route::delete('/{id}', 'ProductController@destroy')->name('product-delete')->middleware('auth:sanctum');
    });

    // category api routes
    Route::group([
        'prefix' => 'categories',
    ], function(){
        Route::get('/', 'CategoryController@index')->name('category-list');
        Route::post('/', 'CategoryController@store')->name('category-create')->middleware('auth:sanctum');
        Route::get('/{id}', 'CategoryController@show')->name('category-show');
        Route::get('search/{field}/{value}', 'CategoryController@search')->name('category-search');
        Route::patch('/{id}/edit', 'CategoryController@update')->name('category-update')->middleware('auth:sanctum');
        Route::delete('/{id}', 'CategoryController@destroy')->name('category-delete')->middleware('auth:sanctum');
    });

    // size api routes
    Route::group([
        'prefix' => 'sizes',
    ], function(){
        Route::get('/', 'SizeController@index')->name('size-list');
        Route::post('/', 'SizeController@store')->name('size-create')->middleware('auth:sanctum');
        Route::get('/{id}', 'SizeController@show')->name('size-show');
        Route::get('/search/{field}/{value}', 'SizeController@search')->name('size-search');
        Route::patch('/{id}/edit', 'SizeController@update')->name('size-update')->middleware('auth:sanctum');
        Route::delete('/{id}', 'SizeController@destroy')->name('size-delete')->middleware('auth:sanctum');
    });

    // color api routes
    Route::group([
        'prefix' => 'colors',
    ], function(){
        Route::get('/', 'ColorController@index')->name('color-list');
        Route::post('/', 'ColorController@store')->name('color-create')->middleware('auth:sanctum');
        Route::get('/{id}', 'ColorController@show')->name('color-show');
        Route::get('/search/{field}/{value}', 'ColorController@search')->name('color-search');
        Route::patch('/{id}/edit', 'ColorController@update')->name('color-update')->middleware('auth:sanctum');
        Route::delete('/{id}', 'ColorController@destroy')->name('color-delete')->middleware('auth:sanctum');
    });

    // brand api routes
    Route::group([
        'prefix' => 'brands'
    ], function(){
        Route::get('/', 'BrandController@index')->name('brand-list');
        Route::post('/', 'BrandController@store')->name('brand-create')->middleware('auth:sanctum');
        Route::get('/{id}', 'BrandController@show')->name('brand-show');
        Route::get('/search/{field}/{value}', 'BrandController@search')->name('brand-search');
        Route::patch('/{id}/edit', 'BrandController@update')->name('brand-update')->middleware('auth:sanctum');
        Route::delete('/{id}', 'BrandController@destroy')->name('brand-delete')->middleware('auth:sanctum');
    });

    // ... api routes
});