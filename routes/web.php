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
    return view('welcome');
});
Route::post('/uploadFile', 'ImportController@uploadFile')->name('uploadFile');
Route::post('/import_process', 'ImportController@processImport')->name('import_process');
Route::get('/view', 'ImportController@phonePriceIp')->name('phonePriceIp');
