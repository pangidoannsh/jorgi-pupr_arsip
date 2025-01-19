<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/datatable/arsip', [ArsipController::class, 'data'])->name('arsip.data');
    Route::resource('arsip', ArsipController::class);
});
