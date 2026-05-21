<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TpbController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\RpjmdController;
use App\Http\Controllers\CapaianController;
use App\Http\Controllers\CapaianKabupatenController;
use App\Http\Controllers\WilayahController;

Route::get('/', [AuthController::class,'login'])->name('login');
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('user', UserController::class);
    Route::put('/user/{User}', 'App\Http\Controllers\UserController@update');
    Route::get('/user/umum/{id}', 'App\Http\Controllers\UserController@umum')->name('user.umum');
    Route::put('/perbaharui/{id}', 'App\Http\Controllers\UserController@perbaharui');
    Route::get('/user/akun/{id}', 'App\Http\Controllers\UserController@akun')->name('user.akun');
    Route::put('/perbaiki/{id}', 'App\Http\Controllers\UserController@perbaiki');

    Route::resource('tpb', TpbController::class);
    Route::put('/tpb/{Tpb}', 'App\Http\Controllers\TpbController@update');

    Route::resource('target', TargetController::class);
    Route::put('/target/{Target}', 'App\Http\Controllers\TargetController@update');

    Route::post('/indikator/import', [IndikatorController::class, 'import'])->name('indikator.import');
    Route::post('/indikator/verify/{id}', [IndikatorController::class, 'verify'])->name('indikator.verify');
    Route::post('/indikator/reject/{id}', [IndikatorController::class, 'reject'])->name('indikator.reject');
    Route::resource('indikator', IndikatorController::class);
    Route::put('/indikator/{Indikator}', 'App\Http\Controllers\IndikatorController@update');

    Route::get('/rpjmd/download-template', [RpjmdController::class, 'downloadTemplate'])->name('rpjmd.download-template');
    Route::post('/rpjmd/import', [RpjmdController::class, 'import'])->name('rpjmd.import');
    Route::resource('rpjmd', RpjmdController::class);
    Route::put('/rpjmd/{Rpjmd}', 'App\Http\Controllers\RpjmdController@update');

    Route::resource('capaian', CapaianController::class);
    Route::put('/capaian/{Capaian}', 'App\Http\Controllers\CapaianController@update');

    Route::resource('wilayah', WilayahController::class);

    Route::resource('capaian_kabupaten', CapaianKabupatenController::class);
    Route::post('/capaian_kabupaten/verify/{id}', [CapaianKabupatenController::class, 'verify'])->name('capaian_kabupaten.verify');
    Route::post('/capaian_kabupaten/reject/{id}', [CapaianKabupatenController::class, 'reject'])->name('capaian_kabupaten.reject');
});