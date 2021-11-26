<?php

use App\Models\User;

function userEmailExists($email, $requestSource = NULL, $userID = NULL) {

    $responseValue = false;

    if(isset($requestSource) && $requestSource != NULL && $requestSource == 'adminEdit') {

        if(User::where('id', '!=', $userID)->where('email', $email)->exists()) {

            $responseValue = true;
        }
        else {
    
            $responseValue = false;
        }
    }
    else {

        if(User::where('email', $email)->exists()) {

            $responseValue = true;
        }
        else {
    
            $responseValue = false;
        }
    }

    return $responseValue;
}

function userPhoneExists($phone, $countryCode, $requestSource = NULL, $userID = NULL) {

    $responseValue = false;

    if(isset($requestSource) && $requestSource != NULL && ($requestSource == 'profile' || $requestSource == 'adminEdit')) {

        if(User::where('id', '!=', $userID)->where(['country_code' => $countryCode, 'phone' => $phone])->exists()) {

            $responseValue = true;
        }
        else {
    
            $responseValue = false;
        }
    }
    else {

        if(User::where(['country_code' => $countryCode, 'phone' => $phone])->exists()) {

            $responseValue = true;
        }
        else {
    
            $responseValue = false;
        }
    }

    return $responseValue;
}