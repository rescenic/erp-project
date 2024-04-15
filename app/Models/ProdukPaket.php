<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPaket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $fillable = [
        'kode', 'nama', 'sku'
    ];

    public function produk_satuan(){
        return $this->belongsToMany(ProdukSatuan::class, 'produk_paket', 'paket_id', 'produk_satuan_id');
    }
}
