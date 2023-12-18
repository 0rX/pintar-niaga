<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey='purchase_id';

    protected $fillable = [
        'account_id',
        'company_id',
        'total_amount',
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    public function purchasedProducts() {
        return $this->hasMany(PurchasedProduct::class, 'purchase_id', 'purchase_id');
    }
}
