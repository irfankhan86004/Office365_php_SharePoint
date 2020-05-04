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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/indexOne', 'HomeController@indexOne')->name('indexOne');
Route::get('/demo', 'SharePointController@index')->name('demo');
Route::get('/dir', 'DirectoryController@index')->name('dir');
Route::post('/open_child', 'DirectoryController@open_child')->name('open_child');
Route::post('/upload_file', 'DirectoryController@upload_file')->name('upload_file');
Route::get('/tree_view', 'DirectoryController@tree_view')->name('tree_view');
