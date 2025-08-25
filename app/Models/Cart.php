<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bouquet_package_id',
        'flower_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bouquetPackage()
    {
        return $this->belongsTo(BouquetPackage::class);
    }

    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }
}
