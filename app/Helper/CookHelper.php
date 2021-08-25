<?php 

use App\Models\BillingInfo;
use App\Models\CookReview;
use Illuminate\Support\Facades\Auth;

function checkCookBillingInfoStatus() {

    $status = false;

    if(Auth::user()->isCook()) {

        if(BillingInfo::where('user_id', Auth::user()->id)->exists()) {

            $status = true;
        }
        else {

            $status = false;
        }
    }

    return $status;
}

function getCookAverageRating($userID) {

    $averageRating = CookReview::where('cook_user_id', $userID)->avg('rating');

    $averageRating = floor($averageRating);

    return $averageRating;
}