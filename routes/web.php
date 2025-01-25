<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuratCutiController;
use App\Http\Controllers\UsulanController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/datatable/arsip', [ArsipController::class, 'data'])->name('arsip.data');
    Route::resource('arsip', ArsipController::class);

    Route::get('/usulan', [UsulanController::class, 'index'])->name('usulan.index');
    Route::get('/riwayat-usulan', [UsulanController::class, 'riwayat'])->name('usulan.riwayat');

    // Surat Cuti
    Route::get('usulan/surat-cuti/create', [SuratCutiController::class, 'create'])->name('suratCuti.create');
    Route::get('usulan/surat-cuti/{id}', [SuratCutiController::class, 'show'])->name('suratCuti.show');
    Route::post('usulan/surat-cuti', [SuratCutiController::class, 'store'])->name('suratCuti.store');
    Route::get('usulan/surat-cuti/{id}/tolak', [SuratCutiController::class, 'tolak'])->name('suratCuti.tolak');
    Route::get('usulan/surat-cuti/{id}/setujuiAdmin', [SuratCutiController::class, 'setujuiAdmin'])->name('suratCuti.setujuiAdmin');
    Route::get('usulan/surat-cuti/{id}/setujui', [SuratCutiController::class, 'setujui'])->name('suratCuti.setujui');
    Route::get('usulan/surat-cuti/{id}/print', [SuratCutiController::class, 'print'])->name('suratCuti.print');
});
