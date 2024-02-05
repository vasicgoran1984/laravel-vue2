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

Route::post('app/create_tag',  [\App\Http\Controllers\TagController::class, 'create'])->name('create-tag');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
