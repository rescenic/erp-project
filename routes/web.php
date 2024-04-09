<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('permission', [PermissionController::class, 'index'])
        ->name('permission');
    Route::get('permission/tambah', [PermissionController::class, 'tambah'])
        ->name('permission.tambah');
    Route::get('permission/simpan', [PermissionController::class, 'simpan'])
        ->name('permission.simpan');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])
        ->name('permission.edit');
    Route::post('permission/update', [PermissionController::class, 'update'])
        ->name('permission.update');
    Route::get('permission/hapus/{id}', [PermissionController::class, 'hapus'])
        ->name('permission.hapus');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
