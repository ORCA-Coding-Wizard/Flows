<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'image',
    ];

    /**
     * Relasi ke Category (many-to-one)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
