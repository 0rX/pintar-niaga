<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedIngredient extends Model
{
    use HasFactory;

    protected $primaryKey = "used_ingredient_id";

    protected $fillable = [
        'ingredient_id',
        'sale_id',
        'quantity',
    ];

    public function sale() {
        return $this->belongsTo(Sale::class, 'sale_id', 'sale_id');
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'ingredient_id');
    }
}
