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

    public function kategori_produk(){
        return $this->belongsTo(KategoriProduk::class, 'kategori_id', 'id');
    }
}
