<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    
    protected $fillable = [
        'account_id',
        'company_id',
        'title',
        'description',
        'total_amount',
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }
}
