<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tabel yang digunakan
    protected $table = 'categories';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'name',
    ];

    public function flowers()
    {
        return $this->hasMany(Flower::class);
    }
}
