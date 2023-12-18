<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
