<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picture_url',
        'address',
        'phone',
        'biography',
        'user_active',
        'type',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(){
        return $this->type == 'u_admin';
    }

    public function isCook(){
        return $this->type == 'u_cook';
    }

    public function isCustomer(){
        return $this->type == 'u_customer';
    }

    public function getUserType(){
        return $this->hasOne(UserType::class, 'id', 'type');
    }

    public function cook_details(){
        return $this->hasOne(CookDetail::class, 'user_id');
    }

    public function ratings(){
        return $this->hasMany(CookRating::class, 'cook_id');
    }

    public function speclities(){
        return $this->hasMany(CookSpeciality::class, 'cook_id');
    }

    public function getRating(){
        $rating = (5*252 + 4*124 + 3*40 + 2*29 + 1*33) / (252+124+40+29+33);
        return $rating;
    }

    public function getBillingInfos(){
        return $this->hasMany(BillingInfo::class, 'user_id');
    }
}
