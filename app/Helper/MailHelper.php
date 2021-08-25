<?php

use App\Models\Order;

function sendApprovalEmail($adminEmail, $userType, $userName, $userEmail, $foodSpeciality, $token) {

    try {

        \Mail::send('emails.admin.cookApproval', ['userName' => $userName, 'userEmail' => $userEmail, 'foodSpeciality' => $foodSpeciality, 'token' => $token], function($message) use($adminEmail) {
            $message->to($adminEmail);
            $message->subject('Cook Approval Email');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendApprovalEmailResponse($userName, $userEmail) {

    try {

        \Mail::send('emails.cook.adminApprovalResponse', ['userName' => $userName], function($message) use($userEmail) {
            $message->to($userEmail);
            $message->subject('Account Approval Response');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendPasswordResetEmail($userEmail, $token) {

    try {

        \Mail::send('emails.passwordReset', ['token' => $token], function($message) use($userEmail) {
            $message->to($userEmail);
            $message->subject('Password Reset Email');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendOrderConfirmationEmail($userEmail, $orderID) {

    try {

        $orderObject = Order::with(['billingInfo' => function($q) {

            return $q->with(['city' => function($q1) {

                return $q1->with(['state' => function($q2) {

                    return $q2->with(['country']);
                }]);

            }]);

        }, 'meal', 'currency'])->where('id', $orderID)->first();

        \Mail::send('emails.admin.customerOrderConfirmation', ['orderObject' => $orderObject] ,function($message) use($userEmail) {
            $message->to($userEmail);
            $message->subject('Order Confirmation Email');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendCookReservedPortionEmail($userEmail, $meal) {

    try {

        \Mail::send('emails.cook.reservedPortion', ['meal' => $meal] ,function($message) use($userEmail) {
            $message->to($userEmail);
            $message->subject('No. of Portions you have to Cook');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendLoginInfoEmail($requestUser) {

    try {

        \Mail::send('emails.loginInfo', ['requestUser' => $requestUser] ,function($message) use($requestUser) {
            $message->to($requestUser->email);
            $message->subject('Login Information');
        });
    }
    catch(\Exception $e) {

        //
    }
}