<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriPackagingController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdukBundlingController;
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


        Route::get('produk-bundling', [ProdukBundlingController::class, 'index'])
            ->name('produk_bundling');
        Route::get('produk-bundling/data', [ProdukBundlingController::class, 'data'])
            ->name('produk_bundling.data');
        Route::get('produk-bundling/tambah', [ProdukBundlingController::class, 'tambah'])
            ->name('produk_bundling.tambah');
        Route::post('produk-bundling/simpan', [ProdukBundlingController::class, 'simpan'])
            ->name('produk_bundling.simpan');
        Route::get('produk-bundling/edit/{id}', [ProdukBundlingController::class, 'edit'])
            ->name('produk_bundling.edit');
        Route::post('produk-bundling/update', [ProdukBundlingController::class, 'update'])
            ->name('produk_bundling.update');
        Route::post('produk-bundling/hapus', [ProdukBundlingController::class, 'hapus'])
            ->name('produk_bundling.hapus');


        Route::get('produk-bundling/dataProdukBundling', [ProdukBundlingController::class, 'dataProdukByBundling'])
            ->name('produk_bundling.dataProdukByBundling');
        Route::get('produk-bundling/dataProdukBundling', [ProdukBundlingController::class, 'dataProdukByBundling'])
            ->name('produk_bundling.dataProdukByBundling');
        Route::get('produk-bundling/tambah-produk-by-bundling', [ProdukBundlingController::class, 'tambahProdukByBundling'])
            ->name('produk_bundling.tambahProdukByBundling');
        Route::post('produk-bundling/simpanProdukBundling', [ProdukBundlingController::class, 'simpanProdukByByBundling'])
            ->name('produk_bundling.simpanProdukByByBundling');
        Route::get('produk-bundling/editProdukBundling/{id_bundling}', [ProdukBundlingController::class, 'editProdukBundling'])
            ->name('produk_bundling.editProdukBundling');
        Route::post('produk-bundling/updateProdukBundling', [ProdukBundlingController::class, 'updateProdukBundling'])
            ->name('produk-bundling.updateProdukBundling');
        Route::post('produk-bundling/updateProdukBundling', [ProdukBundlingController::class, 'updateProdukBundling'])
            ->name('produk-bundling.updateProdukBundling');
        Route::get('produk-bundling/list-bundling', [ProdukBundlingController::class, 'listBundling'])
            ->name('produk_bundling.listBundling');
        Route::get('produk-bundling/list-produk-satuan', [ProdukBundlingController::class, 'listProdukSatuan'])
            ->name('produk_bundling.list_produk_satuan');
        Route::post('produk-bundling/hapus_produk_bundling', [ProdukBundlingController::class, 'hapusProdukBundling'])
            ->name('produk_bundling.hapus_produk_bundling');


        Route::get('kategori-packaging', [KategoriPackagingController::class, 'index'])
            ->name('kategori_packaging');
        Route::get('kategori-packaging/data', [KategoriPackagingController::class, 'data'])
            ->name('kategori_packaging.data');
        Route::get('kategori-packaging/tambah', [KategoriPackagingController::class, 'tambah'])
            ->name('kategori_packaging.tambah');
        Route::post('kategori-packaging/simpan', [KategoriPackagingController::class, 'simpan'])
            ->name('kategori_packaging.simpan');
        Route::get('kategori-packaging/edit/{id}', [KategoriPackagingController::class, 'edit'])
            ->name('kategori_packaging.edit');
        Route::post('kategori-packaging/update', [KategoriPackagingController::class, 'update'])
            ->name('kategori_packaging.update');
        Route::post('kategori-packaging/hapus', [KategoriPackagingController::class, 'hapus'])
            ->name('kategori_packaging.hapus');


        Route::get('packaging', [PackagingController::class, 'index'])
            ->name('packaging');
        Route::get('packaging/data', [PackagingController::class, 'data'])
            ->name('packaging.data');
        Route::get('packaging/tambah', [PackagingController::class, 'tambah'])
            ->name('packaging.tambah');
        Route::post('packaging/simpan', [PackagingController::class, 'simpan'])
            ->name('packaging.simpan');
        Route::get('packaging/edit/{id}', [PackagingController::class, 'edit'])
            ->name('packaging.edit');
        Route::post('packaging/update', [PackagingController::class, 'update'])
            ->name('packaging.update');
        Route::get('packaging/listKategoriPackaging', [PackagingController::class, 'listKategoriPackaging'])
            ->name('packaging.listKategoriPackaging');
        Route::post('packaging/hapus', [PackagingController::class, 'hapus'])
            ->name('packaging.hpaus');

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
