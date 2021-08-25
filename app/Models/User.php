<?php

namespace App\Models;

use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role_id',
        'user_status_id',
        'admin_approved_verification_code',
        'is_approved',
        'approved_at',
        'currency_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'admin_approved_verification_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['user_status_name', 'user_role_name'];

    public function getUserStatusNameAttribute() {

        $roleName = UserStatus::where('id', $this->user_status_id)->first()->name;

        return $roleName;
    }

    public function getUserRoleNameAttribute() {

        $roleName = UserRole::where('id', $this->user_role_id)->first()->name;

        return $roleName;
    }

    public function isAdmin() {

        return $this->user_role_id == 1;
    }

    public function isCook() {

        return $this->user_role_id == 2;
    }

    public function isCustomer() {

        return $this->user_role_id == 3;
    }

    public function isApproved() {
        
        return $this->is_approved == 1;
    }

    public function isDeleted() {

        return $this->user_status_id == 4;
    }

    public function getUserType(){
        
        return $this->hasOne(UserType::class, 'id', 'type');
    }

    public function meal(){
        
        return $this->hasMany(Meal::class, 'user_id');
    }
    
    public function cookReview() {

        return $this->hasMany(CookReview::class, 'cook_user_id');
    }

    public function currency() {
        
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function getBillingInfos(){
        return $this->hasMany(BillingInfo::class, 'user_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
