<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    use HasFactory;

    protected $primaryKey = "sold_product_id";

    protected $fillable = [
        'product_id',
        'sale_id',
        'quantity',
        'amount',
    ];

    public function sale() {
        return $this->belongsTo(Sale::class, 'sale_id', 'sale_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
