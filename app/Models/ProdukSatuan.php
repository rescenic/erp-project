<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSatuan extends Model
{
    use HasFactory;

    protected $table = 'produk_satuan';

    protected $fillable = [
        'kode', 'sku', 'nama', 'kategori_id',
        'no_bpom'
    ];

    public function kategori_produk()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id', 'id');
    }

    public function produk_paket()
    {
        return $this->belongsToMany(ProdukPaket::class, 'produk_paket', 'paket_id', 'produk_satuan_id');
    }

    public function produk_bundling()
    {
        return $this->hasMany(ProdukBundling::class, 'produk_satuan_id', 'id');
    }

    public function packaging()
    {
        return $this->belongsToMany(Packaging::class, 'packaging_produk', 'produk_satuan_id', 'packaging_id');
    }
}
