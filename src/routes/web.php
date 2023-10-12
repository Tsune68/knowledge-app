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


Route::group(['middleware' => 'guest'], function () {
    Route::get('/slack/redirect', [App\Http\Controllers\OAuthController::class, 'redirect']);
    Route::get('/slack/callback', [App\Http\Controllers\OAuthController::class, 'callback']);
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\PostController::class, 'showTopPage'])->name('index');
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
        Route::get('/', [App\Http\Controllers\UserController::class, 'showAllUsers'])->name('index');
        Route::get('{id}', [App\Http\Controllers\UserController::class, 'findByUserId'])->name('show');
        Route::delete('/', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete');
        Route::put('/{id}', [App\Http\Controllers\UserController::class, 'updateUser'])->name('update');
    });
});
