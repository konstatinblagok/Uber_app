<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public function menu()
    {
        return $this->hasOne(Menu::class, 'currency_id');
    }

    public function reviewBasedCharge()
    {
        return $this->hasOne(ReviewBasedCharge::class, 'currency_id');
    }

    public static function getCurrencySymbol($id) {

        return Currency::find($id)->symbol;
    }
}
