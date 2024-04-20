<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBundling extends Model
{
    use HasFactory;

    protected $table = 'produk_bundling';

    protected $fillable = [
        'bundling_id', 'produk_satuan_id', 'jenis', 'qty_satuan'
    ];

    public function bundling()
    {
        return $this->belongsTo(Bundling::class, 'bundling_id', 'id');
    }

    public function produk_satuan()
    {
        return $this->belongsTo(ProdukSatuan::class, 'produk_satuan_id', 'id');
    }
}
