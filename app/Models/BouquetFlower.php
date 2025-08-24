<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouquetFlower extends Model
{
    use HasFactory;

    protected $table = 'bouquet_flower';

    protected $fillable = [
        'bouquet_package_id',
        'flower_id',
    ];

    public function bouquetPackage()
    {
        return $this->belongsTo(BouquetPackage::class);
    }

    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }
}
