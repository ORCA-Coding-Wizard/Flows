<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'flower_id', 'bouquet_package_id', 'quantity', 'price'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }

    public function bouquetPackage()
    {
        return $this->belongsTo(BouquetPackage::class);
    }
}
