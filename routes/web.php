<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SuratCutiController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsulanController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");

    Route::get('/datatable/arsip', [ArsipController::class, 'data'])->name('arsip.data');
    Route::resource('arsip', ArsipController::class);

    Route::get('/datatable/klasifikasi', [KlasifikasiController::class, 'data'])->name('klasifikasi.data');
    Route::resource('klasifikasi', KlasifikasiController::class);

    Route::get('/usulan', [UsulanController::class, 'index'])->name('usulan.index');
    Route::get('/riwayat-usulan', [UsulanController::class, 'riwayat'])->name('usulan.riwayat');

    Route::put("/profile", [UsersController::class, "profile"])->name("profile.update");

    Route::get('/datatable/users', [UsersController::class, 'data'])->name('users.data');
    Route::resource('users', UsersController::class);

    Route::get('/datatable/unit', [UnitKerjaController::class, 'data'])->name('unit.data');
    Route::resource('unit', UnitKerjaController::class);

    Route::get('/datatable/jabatan', [JabatanController::class, 'data'])->name('jabatan.data');
    Route::resource('jabatan', JabatanController::class);

    // Surat Cuti
    Route::get('usulan/surat-cuti/create', [SuratCutiController::class, 'create'])->name('suratCuti.create');
    Route::get('usulan/surat-cuti/{id}', [SuratCutiController::class, 'show'])->name('suratCuti.show');
    Route::post('usulan/surat-cuti', [SuratCutiController::class, 'store'])->name('suratCuti.store');
    Route::get('usulan/surat-cuti/{id}/tolak', [SuratCutiController::class, 'tolak'])->name('suratCuti.tolak');
    Route::get('usulan/surat-cuti/{id}/setujuiAdmin', [SuratCutiController::class, 'setujuiAdmin'])->name('suratCuti.setujuiAdmin');
    Route::get('usulan/surat-cuti/{id}/setujui', [SuratCutiController::class, 'setujui'])->name('suratCuti.setujui');

    // PRINT
    Route::get('surat-cuti/{id}/print', [SuratCutiController::class, 'print'])->name('suratCuti.print');

    //NOTIFIKASI
    Route::get("/notif", [NotificationController::class, "index"])->name("notif.index");
    Route::get("/notif/{id}/read", [NotificationController::class, "markAsRead"])->name("notif.markAsRead");
    Route::get("/notif/read-all", [NotificationController::class, "markAllRead"])->name("notif.markAllRead");
});
