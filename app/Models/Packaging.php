<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;

    protected $table = 'packaging';

    protected $fillable = [
        'kategori_packaging_id', 'kode', 'nama'
    ];

    public function kategori_packaging()
    {
        return $this->belongsTo(KategoriPackaging::class, 'kategori_packaging_id', 'id');
    }
}
