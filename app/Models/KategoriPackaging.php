<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPackaging extends Model
{
    use HasFactory;

    protected $table = 'kategori_packaging';

    protected $fillable = [
        'kategori'
    ];

    public function packaging()
    {
        return $this->hasMany(Packaging::class, 'kategori_packaging_id', 'id');
    }
}
