<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    public function currency() {
        
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function user() {
        
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lastUpdatedByUser() {
        
        return $this->belongsTo(User::class, 'updated_by_user_id', 'id');
    }
}
