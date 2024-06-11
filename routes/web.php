<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/home', function () {
    return view('welcome');
});

// Route::get('/home', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'processLogin'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/pesan', [PesananController::class, 'showPesananForm'])->name('pesan');
Route::post('/pesan-add', [PesananController::class, 'store'])->name('pesan-store');
Route::get('/pesan-hasil', [PesananController::class, 'hasil'])->name('pesan-hasil');
Route::post('/pesan-download', [PesananController::class, 'download'])->name('pesan-download');

Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth');