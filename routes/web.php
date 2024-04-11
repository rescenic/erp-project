<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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
    Route::post('permission/simpan', [PermissionController::class, 'simpan'])
        ->name('permission.simpan');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])
        ->name('permission.edit');
    Route::post('permission/update', [PermissionController::class, 'update'])
        ->name('permission.update');
    Route::post('permission/hapus', [PermissionController::class, 'hapus'])
        ->name('permission.hapus');
    Route::get('permission.data', [PermissionController::class, 'dataPermission'])
        ->name('permission.data');


    Route::get('role', [RoleController::class, 'index'])
        ->name('role');
    Route::get('role/tambah', [RoleController::class, 'tambah'])
        ->name('role.tambah');
    Route::get('role/listPermission', [RoleController::class, 'listPermission'])
        ->name('role.listPermission');
    Route::post('role/simpan', [RoleController::class, 'simpan'])
        ->name('role.simpan');
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])
        ->name('role.edit');
    Route::post('role/update', [RoleController::class, 'update'])
        ->name('role.update');
    Route::post('role/hapus', [RoleController::class, 'hapus'])
        ->name('role.hapus');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
