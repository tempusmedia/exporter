<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::get('export', 'HomeController@export')->name('export');
Route::get('download/{filename}', 'HomeController@download')->name('download');
Route::get('delete/{siteExport}', 'HomeController@delete')->name('delete');
Route::resource('site', 'SiteController');
Route::get('index' , 'HomeController@index')->name('index');
