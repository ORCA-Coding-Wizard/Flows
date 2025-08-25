<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'bouquet_package_id',
        'flower_id',
        'quantity',
        'price'
    ];

    // Relasi ke transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke paket buket
    public function bouquetPackage()
    {
        return $this->belongsTo(BouquetPackage::class);
    }

    // Relasi ke bunga
    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }
}

