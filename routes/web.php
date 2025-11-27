<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MultipleUploadController;
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

// routes/web.php
Route::get('/multipleuploads', [MultipleUploadController::class, 'index'])->name('uploads');
Route::post('/uploads/store', [MultipleUploadController::class, 'store'])->name('uploads.store');
// Route untuk melihat semua files pelanggan
Route::get('/pelanggan/{id}/files', [MultipleUploadController::class, 'showByPelanggan'])->name('pelanggan.files');
Route::delete('/uploads/{id}', [MultipleUploadController::class, 'destroy'])->name('uploads.destroy');

Route::get('/debug-files', function() {
    echo "<h1>Debug File Storage</h1>";

    // Cek public disk
    echo "<h2>Public Disk Files:</h2>";
    $publicFiles = \Storage::disk('public')->allFiles();
    if (count($publicFiles) > 0) {
        echo "<ul>";
        foreach ($publicFiles as $file) {
            echo "<li>" . $file . " | URL: " . \Storage::disk('public')->url($file) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Tidak ada file di public disk</p>";
    }

    // Cek local disk
    echo "<h2>Local Disk Files:</h2>";
    $localFiles = \Storage::allFiles();
    if (count($localFiles) > 0) {
        echo "<ul>";
        foreach ($localFiles as $file) {
            echo "<li>" . $file . " | Path: " . storage_path('app/' . $file) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Tidak ada file di local disk</p>";
    }

    // Cek file dari database
    echo "<h2>Files dari Database:</h2>";
    $dbFiles = \App\Models\Multipleupload::all();
    if (count($dbFiles) > 0) {
        echo "<ul>";
        foreach ($dbFiles as $file) {
            $existsPublic = \Storage::disk('public')->exists('uploads/' . $file->filename) ? 'YES' : 'NO';
            $existsLocal = \Storage::exists('public/uploads/' . $file->filename) ? 'YES' : 'NO';
            echo "<li>" . $file->filename . " | Public: " . $existsPublic . " | Local: " . $existsLocal . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Tidak ada file di database</p>";
    }
});
