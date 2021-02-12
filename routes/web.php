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

Route::post('post-image',[\App\Http\Controllers\ImageController::class, 'store'])
    ->name('image.store');
Route::get('index',[\App\Http\Controllers\ImageController::class, 'index'])
    ->name('image.index');
