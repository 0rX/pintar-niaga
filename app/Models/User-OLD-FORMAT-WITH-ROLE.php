<?php

// I decided to remake my User model.
// since apparently I should not have mixed the company owner and company employees
// in one same Database Model. Because company owner can own one or many companies,
// while employees belongs to one company. Which will absolutely make the relationship
// diagram look broken as fuck.
//
// I keep this one for reference use. Please be reminded that I should never delete this model
// before I finish remaking the new one
// ~ Sandy Fox

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

    const Manager = 'manager';
    const Staff = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'company_id',
        'name',
        'email',
        'phone',
        'address',
        'birthdate',
        'profilepicture',
        'gender',
        'password',
        'role',
        'gender',
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
    
    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function companies() {
        return $this->hasMany(Company::class);
    }

    public function getRedirectRoute() {
        return match((string)$this->role) {
            'manager' => RouteServiceProvider::MDASHBOARD,
            'staff' => RouteServiceProvider::HOME,
        };
    }
    
    public function hasAnyRole($role) {
        if ($role == $this->role) {
            return true;
        }
        return false;
    }
}
