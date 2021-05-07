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
    if (auth()->user()) {
        $contacts = \App\Contact::all();
        return view('contactdetails', compact('contacts'));
    } else {
        return view('contact');
    }

})->name('contact');

Route::post('/contact', 'PageController@contact')->name('contact.post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/reviews', 'HomeController@reviews')->name('reviews');
Route::get('/competitors-domain', 'HomeController@competitorsdomain')->name('competitorsdomain');
Route::post('/competitors-domain', 'HomeController@getCompetitorsdomain')->name('getCompetitorsdomain');
Route::post('/reviews', 'HomeController@getKeyWordReview')->name('getKeyWordReview');
Route::get('/full-page-report/{id}', 'HomeController@fullPageStatistics')->name('fullPageStatistics');
Route::post('/get-quick-report', 'PageController@index')->name('quickReport');
