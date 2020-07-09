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
    return view('search');
});

Route::post('/', 'QuestionController@query')->name('question.query');

Auth::routes();

Route::get('/download/{id}', 'DownloadController@download')->name('download');

Route::get('/users', 'UserController@index')->name('users.index');
Route::patch('/users/disable/{id}', 'UserController@disable')->name('users.disable');
Route::patch('/users/enable/{id}', 'UserController@enable')->name('users.enable');
