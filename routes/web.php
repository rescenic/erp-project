<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukPaketController;
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
    return redirect()->route('login');
});

Route::prefix('internal')
    ->middleware('auth')
    ->group(function () {
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
        Route::get('produk_satuan/detail/{id}', [ProdukSatuanController::class, 'detail'])
            ->name('produk_satuan.detail');
        Route::post('produk-satuan/update', [ProdukSatuanController::class, 'update'])
            ->name('produk_satuan.update');
        Route::get('produk-satuan/listKategori', [ProdukSatuanController::class, 'listKategori'])
            ->name('produk_satuan.listKategori');
        Route::get('produk-satuan/kategoriByProdukSatuan', [ProdukSatuanController::class, 'kategoriByProdukSatuan'])
            ->name('produk_satuan.kategoriByProdukSatuan');



        Route::get('produk-paket', [ProdukPaketController::class, 'index'])
            ->name('produk_paket');
        Route::get('produk-paket/data', [ProdukPaketController::class, 'data'])
            ->name('produk_paket.data');
        Route::get('produk-paket/tambah', [ProdukPaketController::class, 'tambah'])
            ->name('produk_paket.tambah');
        Route::post('produk-paket/simpan', [ProdukPaketController::class, 'simpan'])
            ->name('produk_paket.simpan');
        Route::get('produk-paket/edit/{id}', [ProdukPaketController::class, 'edit'])
            ->name('produk_paket.edit');

        Route::get('produk-paket/tambah-produk-by-paket', [ProdukPaketController::class, 'tambahProdukByPaket'])
            ->name('produk_paket.tambah_produk_by_paket');
        Route::post('produk-paket/simpan-produk-by-paket', [ProdukPaketController::class, 'simpanProdukByPaket'])
            ->name('produk_paket.simpan_produk_by_paket');
        Route::get('produk-paket/listPaket', [ProdukPaketController::class, 'listPaket'])
            ->name('produk-paket.listPaket');
        Route::get('produk-paket/listProdukSatuan', [ProdukPaketController::class, 'listProdukSatuan'])
            ->name('produk-paket.listProdukSatuan');
        Route::get('produk-paket/data-produk-paket', [ProdukPaketController::class, 'data_produk_by_paket'])
            ->name('produk-paket.data_produk_paket');
        Route::post('produk-paket/hapus-produk-paket', [ProdukPaketController::class, 'hapus_produk_paket'])
            ->name('produk_paket.hapus_produk_paket');
        Route::get('produk-paket/edit-produk-paket/{id_produk_paket}', [ProdukPaketController::class, 'editProdukByPaket'])
            ->name('produk_paket.edit_produk_paket');
        Route::get('produk-paket/produkByPaket', [ProdukPaketController::class, 'produkSatuanByPaket'])
            ->name('produk-paket.produkByPaket');
        Route::get('produk-paket/paketByProdukPaket', [ProdukPaketController::class, 'paketByProdukPaket'])
            ->name('produk-paket.paketByProdukPaket');
        Route::post('produk-paket/updatePaketProduk', [ProdukPaketController::class, 'updateProdukByPaket'])
            ->name('produk_paket.update_paket_produk');



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
