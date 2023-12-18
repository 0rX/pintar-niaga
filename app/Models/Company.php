<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'email',
        'logo',
        'website',
        'description',
        'is_active',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function accounts() {
        return $this->hasMany(Account::class, 'company_id', 'company_id');
    }

    public function categories() {
        return $this->hasMany(Category::class, 'company_id', 'company_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'company_id', 'company_id');
    }

    public function ingredients() {
        return $this->hasMany(Ingredient::class, 'company_id', 'company_id');
    }

    public function isActive() {
        if ($this->is_active == 'true') {
            return true;
        }
        return false;
    }
}
