<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukSatuanController;
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


    //
    Route::get('kategori', [KategoriController::class, 'index'])
        ->name('kategori');
    Route::get('kategori/data', [KategoriController::class, 'data'])
        ->name('kategori.data');
    Route::get('kategori/tambah', [KategoriController::class, 'tambah'])
        ->name('kategori.tambah');
    Route::post('kategori/simpan', [KategoriController::class, 'simpan'])
        ->name('kategori.simpan');
    Route::get('kategori/edit/{id}', [KategoriController::class, 'edit'])
        ->name('kategori.edit');
    Route::post('kategori/update', [KategoriController::class, 'update'])
        ->name('kategori.update');
    Route::post('kategori/hapus', [KategoriController::class, 'hapus'])
        ->name('kategori.hapus');

    Route::get('produk-satuan', [ProdukSatuanController::class, 'index'])
        ->name('produk_satuan');
    Route::get('produk-satuan/data', [ProdukSatuanController::class, 'data'])
        ->name('produk_satuan.data');
    Route::get('produk-satuan/tambah', [ProdukSatuanController::class, 'tambah'])
        ->name('produk_satuan.tambah');
    Route::post('produk-satuan/simpan', [ProdukSatuanController::class, 'simpan'])
        ->name('produk_satuan.simpan');
    Route::get('produk-satuan/edit/{id}', [ProdukSatuanController::class, 'edit'])
        ->name('produk_satuan.edit');
    Route::post('produk-satuan/update', [ProdukSatuanController::class, 'update'])
        ->name('produk_satuan.update');
    Route::get('produk-satuan/listKategori', [ProdukSatuanController::class, 'listKategori'])
        ->name('produk_satuan.listKategori');
    Route::get('produk-satuan/kategoriByProdukSatuan', [ProdukSatuanController::class, 'kategoriByProdukSatuan'])
        ->name('produk_satuan.kategoriByProdukSatuan');

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
    Route::get('role/data', [RoleController::class, 'data'])
        ->name('role.data');
    Route::get('role/tambah', [RoleController::class, 'tambah'])
        ->name('role.tambah');
    Route::get('role/listPermission', [RoleController::class, 'listPermission'])
        ->name('role.listPermission');
    Route::get('role/listPermissionsByRole', [RoleController::class, 'listPermissionsByRole'])
        ->name('role.listPermissionsByRole');
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
