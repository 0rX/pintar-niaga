<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    
    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'account_id',
        'company_id',
        'total_amount',
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    public function soldProducts() {
        return $this->hasMany(SoldProduct::class, 'sale_id', 'sale_id');
    }

    public function usedIngredients() {
        return $this->hasMany(UsedIngredient::class, 'sale_id', 'sale_id');
    }
}
