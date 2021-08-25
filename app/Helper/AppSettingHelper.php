<?php

use App\Models\Setting;

function getAdminApprovalEmail() {

    $adminEmail = Setting::where('parameter_name', 'admin_account_approval_email')->where('status', 1)->first() ? Setting::where('parameter_name', 'admin_account_approval_email')->where('status', 1)->first()->parameter_value : 'admin@chezdon.lu';

    return $adminEmail;
}

function getMinimumWithdrawalAmount() {

    $amount = Setting::where('parameter_name', 'minimum_withdraw_amount')->where('status', 1)->first() ? Setting::where('parameter_name', 'minimum_withdraw_amount')->where('status', 1)->first()->parameter_value : 50;

    return $amount;
}

function getDeliveryChargesAmount() {

    $deliveryCharges = Setting::where('parameter_name', 'delivery_charges')->where('status', 1)->first() ? Setting::where('parameter_name', 'delivery_charges')->where('status', 1)->first()->parameter_value : 5;

    return $deliveryCharges;
}

function getDeliveryChargesCurrency() {

    $unit = Setting::where('parameter_name', 'delivery_charges_currency')->where('status', 1)->first() ? Setting::where('parameter_name', 'delivery_charges_currency')->where('status', 1)->first()->parameter_value : '€';

    return $unit;
}

function getDeliveryStartTime() {

    $time = Setting::where('parameter_name', 'delivery_start_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'delivery_start_time')->where('status', 1)->first()->parameter_value : '17:30';

    return $time;
}

function getDeliveryEndTime() {

    $time = Setting::where('parameter_name', 'delivery_end_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'delivery_end_time')->where('status', 1)->first()->parameter_value : '21:30';

    return $time;
}

function removeMealFromWebTime() {

    $time = Setting::where('parameter_name', 'meal_remove_from_web_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'meal_remove_from_web_time')->where('status', 1)->first()->parameter_value : '22:00';

    return $time;
}

function portionMailToCookTime() {

    $time = Setting::where('parameter_name', 'portion_mail_to_cook_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'portion_mail_to_cook_time')->where('status', 1)->first()->parameter_value : '13:30';

    return $time;
}

function foodPickUpStartTime() {

    $time = Setting::where('parameter_name', 'food_pickup_start_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'food_pickup_start_time')->where('status', 1)->first()->parameter_value : '16:30';

    return $time;
}

function foodPickUpEndTime() {

    $time = Setting::where('parameter_name', 'food_pickup_end_time')->where('status', 1)->first() ? Setting::where('parameter_name', 'food_pickup_end_time')->where('status', 1)->first()->parameter_value : '17:30';

    return $time;
}

function minimumRatingForCookAccountDeletion() {

    $rating = Setting::where('parameter_name', 'minimum_cook_rating')->where('status', 1)->first() ? Setting::where('parameter_name', 'minimum_cook_rating')->where('status', 1)->first()->parameter_value : '3';

    return $rating;
}