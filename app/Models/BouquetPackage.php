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
        'signature',
    ];

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }

    public function flowers()
    {
        return $this->belongsToMany(Flower::class, 'bouquet_flower')
                    ->withTimestamps();
    }

    public function getTotalPriceAttribute()
    {
        $avgFlowerPrice = $this->flowers()->avg('price') ?? 0;
        $capacity = $this->bouquet->capacity ?? 0;

        return $avgFlowerPrice * $capacity;
    }
}
