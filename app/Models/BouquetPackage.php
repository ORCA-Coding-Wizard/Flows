<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouquetPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'bouquet_id',
        'user_id',
        'name',
        'price',      // <-- tambahkan ini
        'signature',
    ];

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }

    public function flowers()
    {
        return $this->belongsToMany(
            Flower::class,
            'bouquet_flower',        // nama pivot table
            'bouquet_package_id',    // kolom pivot yang mengacu ke BouquetPackage
            'flower_id'              // kolom pivot yang mengacu ke Flower
        )->withTimestamps();
    }
}
