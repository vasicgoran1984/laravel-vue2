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

//Route::post('create_tag',  [\App\Http\Controllers\TagController::class, 'store']);
//Route::get('get_tags',  [\App\Http\Controllers\TagController::class, 'index']);
//Route::get('/', function () {
//    return view('welcome');
//});

Route::resource('tag', \App\Http\Controllers\TagController::class);
Route::post('update_tag',  [\App\Http\Controllers\TagController::class, 'editTag']);
Route::post('delete_tag',  [\App\Http\Controllers\TagController::class, 'destroy']);

// Category
Route::resource('category', \App\Http\Controllers\CategoryController::class);
Route::post('update_category',  [\App\Http\Controllers\CategoryController::class, 'editCategory']);
Route::post('delete_category',  [\App\Http\Controllers\CategoryController::class, 'destroy']);
Route::post('app/upload',  [\App\Http\Controllers\CategoryController::class, 'upload']);
Route::post('app/delete_image',  [\App\Http\Controllers\CategoryController::class, 'deleteImage']);


// User
Route::resource('user', \App\Http\Controllers\UserController::class);
Route::post('update_user',  [\App\Http\Controllers\UserController::class, 'editUser']);
Route::post('app/admin_login',  [\App\Http\Controllers\UserController::class, 'adminLogin']);

Route::get('/logout',  [\App\Http\Controllers\UserController::class, 'logOut']);
Route::get('/login',  [\App\Http\Controllers\UserController::class, 'login']);
Route::get('/',  [\App\Http\Controllers\UserController::class, 'login']);
Route::any('{slug}',  [\App\Http\Controllers\UserController::class, 'login']);







