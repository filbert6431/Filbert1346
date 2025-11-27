<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});
Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1?}', function ($param1 = '') {
    return 'Nama saya: ' . $param1;
});
Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
})->name("testing");

route::get('/home', function () {
    return view('home');
})->name("home");

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('pelanggan', PelangganController::class);


Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::resource('user', UserController::class);
