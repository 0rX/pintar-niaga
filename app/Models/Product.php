<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'company_id',
        'name',
        'description',
        'sale_price',
        'recipe',
        'image',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function soldProducts() {
        return $this->hasMany(SoldProduct::class, 'product_id', 'product_id');
    }

    public function purchasedProducts() {
        return $this->hasMany(PurchasedProduct::class, 'product_id', 'product_id');
    }
}
