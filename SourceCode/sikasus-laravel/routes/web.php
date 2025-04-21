<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('/login', 'showLoginTypes')->name('login.types');
        Route::get('/login/{type}', 'showLoginForm')->name('login.form');
        Route::post('/login', 'login')->name('login.submit');
        Route::get('/logout', 'logout')->name('logout');
    });

Route::controller(App\Http\Controllers\DashboardController::class)
    ->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::post('/', 'search')->name('dashboard.search');
    });

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')
        ->middleware('role:admin,walikelas')
        ->name('dashboard.home');

    Route::resource('kasus', App\Http\Controllers\KasusController::class)->except('show')->middleware('role:admin,walikelas');

    Route::resource('siswa', App\Http\Controllers\SiswaController::class)->except('show')->middleware('role:admin,walikelas');

    Route::resource('walikelas', \App\Http\Controllers\WalikelasController::class)->middleware('role:admin');

    Route::resource('kelas', \App\Http\Controllers\KelasController::class)->middleware('role:admin');

    Route::get('/siswa/dashboard', [\App\Http\Controllers\SiswaController::class, 'dashboard'])->name('siswa.dashboard')->middleware('role:siswa');

});
