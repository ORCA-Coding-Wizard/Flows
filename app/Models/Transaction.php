<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'bouquet_package_id',
        'flower_id',
        'quantity',
        'total_price',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relasi ke bouquet package
     */
    public function bouquetPackage()
    {
        return $this->belongsTo(BouquetPackage::class, 'bouquet_package_id');
    }


    /**
     * Relasi ke flower (bunga satuan)
     */
    public function flower()
    {
        return $this->belongsTo(Flower::class, 'flower_id');
    }
}
