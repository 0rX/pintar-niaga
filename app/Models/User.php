<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Providers\RouteServiceProvider;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id'; //To override laravel's default $primaryKey = 'id'
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'birthdate',
        'profilepicture',
        'gender',
        'password',
        'is_active',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

 
    public function companies() {
        return $this->hasMany(Company::class, 'user_id', 'user_id');
    }

    public function isActive() {
        if ($this->is_active == 'true') {
            return true;
        }
        return false;
    }

    public function getRedirectRoute() {
        return RouteServiceProvider::DASHBOARD;
    }
}
