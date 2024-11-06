<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogLandingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Middleware\TwoFactorMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/', [BlogLandingController::class, "index"]);
Route::get('/berita/{slug}', [BlogLandingController::class, "blogDetail"]);
Route::get('/kategori/{slug}', [BlogLandingController::class, "kategori"]);
Route::get('/tags/{slug}', [BlogLandingController::class, "tag"]);

Route::group(["middleware" => ['auth', 'verified', "2FA"], "prefix" => "/dashboard"], function () {
    Route::get('/', function () {

        return view('dashboard');
    })->name('dashboard');

    Route::resource('/berita', BeritaController::class);
    Route::resource('/tag', TagController::class);
    Route::resource('/kategori', KategoriController::class);
});

// Route::group(["middleware"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
