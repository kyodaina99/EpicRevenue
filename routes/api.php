<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


// Api Routes
Route::get('/wall/checker.js', 'Api\ApiController@checkerJs');
Route::any('/wall/checker', 'Api\ApiController@checker');
Route::get('/wall/IR-mobile-wall.css', 'Api\ApiController@wallCss');
Route::get('/wall/mobile-redirect.css', 'Api\ApiController@mobileCss');
Route::get('/wall/{key}', 'Api\ApiController@wall');
Route::get('/wall/{key}/json', 'Api\ApiController@wallJson');
Route::any('/key/{id?}', 'Api\ApiController@key');
