<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPaket extends Model
{
    use HasFactory;

    protected $table = 'produk_paket';

    protected $fillable = [
        'paket_id', 'produk_satuan_id', 'qty_satuan'
    ];

    public function paket(){
        return $this->belongsTo(Paket::class, 'paket_id', 'id');
    }

    public function produk_satuan(){
        return $this->belongsTo(ProdukSatuan::class, 'produk_satuan_id', 'id');
    }
}
