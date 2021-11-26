<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    use HasFactory;

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function paymentMethod() {

        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
