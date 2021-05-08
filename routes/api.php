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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\APIController@login');
Route::post('/register', 'API\APIController@register');
Route::middleware('auth:sanctum')->post('/logout', 'API\APIController@logout');
Route::post('/locations', 'API\APIController@locations');

Route::middleware('auth:sanctum')->post('/onpageseo', 'PageController@index');
Route::middleware('auth:sanctum')->post('/get-onpageseo-response', 'PageController@index');
Route::middleware('auth:sanctum')->post('/get-fullonpageseo', 'HomeController@fullPageStatistics');

Route::middleware('auth:sanctum')->post('/google-business-review', 'HomeController@getGoogleReviews');
Route::middleware('auth:sanctum')->post('/get-google-business-review', 'HomeController@getGoogleReviews');
Route::middleware('auth:sanctum')->post('/get-competitor-domain', 'HomeController@getCompetitorsdomain');
