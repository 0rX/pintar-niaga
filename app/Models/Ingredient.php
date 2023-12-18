<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $primaryKey = 'ingredient_id';

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'purchase_price',
        'amount_unit',
        'stock',
        'image',
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function usedIngredients() {
        return $this->hasMany(UsedIngredient::class, 'ingredient_id', 'ingredient_id');
    }

    public function purchasedIngredients() {
        return $this->hasMany(PurchasedIngredient::class, 'ingredient_id', 'ingredient_id');
    }
}
