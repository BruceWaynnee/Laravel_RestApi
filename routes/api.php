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

Route::group([
    'namespace' => 'API',
], function(){
    // product api routes
    Route::group([
        'prefix' => 'products',
    ], function(){
        Route::get('/', 'ProductController@index')->name('product-list');
        Route::post('/', 'ProductController@store')->name('product-create');
        Route::get('/{id}', 'ProductController@show')->name('product-show');
        Route::patch('/{id}/edit', 'ProductController@update')->name('product-update');
        Route::delete('/{id}', 'ProductController@destroy')->name('product-delete');
    });
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
