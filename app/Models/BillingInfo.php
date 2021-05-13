<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'city',
        'state',
        'zip_code',
        'phone',
        'address',
        'user_id',
        'created_at'
    ];
}
