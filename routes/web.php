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

Route::get('/', function () {
    return view('home');
})->name('main');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    dump('contact');
})->name('contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/get-quick-report', 'PageController@index')->name('quickReport');
