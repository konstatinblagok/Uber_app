<?php

use App\Models\User;

function userEmailExists($email) {

    $responseValue = false;
    
    if(User::where('email', $email)->exists()) {

        $responseValue = true;
    }
    else {

        $responseValue = false;
    }

    return $responseValue;
}