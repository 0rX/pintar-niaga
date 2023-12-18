<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedIngredient extends Model
{
    use HasFactory;

    protected $primaryKey="purchased_ingredient_id";

    protected $fillable = [
        'purchase_id',
        'ingredient_id',
        'quantity',
        'amount',
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'purchase_id');
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'ingredient_id');
    }
}
