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

//Route::post('app/create_tag', [\App\Http\Controllers\TagController::class, 'create']);

Route::post('create_tag',  [\App\Http\Controllers\TagController::class, 'store']);
Route::get('get_tags',  [\App\Http\Controllers\TagController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});

Route::get('{any?}', function () {
    return view('welcome');
})->where('any', '.*');




//Route::resource('tag', \App\Http\Controllers\TagController::class);

