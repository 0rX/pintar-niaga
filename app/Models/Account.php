<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id';

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'balance',
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function sales() {
        return $this->hasMany(Sale::class, 'account_id', 'account_id');
    }

    public function purchases() {
        return $this->hasMany(Purchase::class, 'account_id', 'account_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'account_id', 'account_id');
    }

    public function cashins() {
        return $this->hasMany(CashIn::class, 'account_id', 'account_id');
    }

}
