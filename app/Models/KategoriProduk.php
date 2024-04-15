<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'kategori'
    ];

    public function produk_satuan()
    {
        return $this->hasOne(ProdukSatuan::class, 'kategori_id', 'id');
    }
}
