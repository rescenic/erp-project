<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundling extends Model
{
    use HasFactory;

    protected $table = 'bundling';

    protected $fillable = [
        'kode', 'sku', 'nama', 'jenis'
    ];

    public function produk_bundling(){
        return $this->hasMany(ProdukBundling::class, 'bundling_id', 'id');
    }
}
