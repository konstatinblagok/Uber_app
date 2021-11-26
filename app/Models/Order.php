<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user() {
        
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function billingInfo() {
        
        return $this->belongsTo(BillingInfo::class, 'consumer_billing_info_id', 'id');
    }

    public function payment() {
        
        return $this->belongsTo(Payment::class, 'payment_id', 'id')->select(['id', 'payment_transaction_id', 'payment_method', 'payment_status', 'payer_id', 'payer_email', 'payer_first_name', 'payer_last_name', 'payee_merchant_id', 'total_amount', 'currency', 'created_at']);
    }

    public function meal() {
        
        return $this->belongsTo(Meal::class, 'meal_id', 'id');
    }

    public function currency() {
        
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function review() {

        return $this->hasOne(CookReview::class, 'order_id');
    }
}
