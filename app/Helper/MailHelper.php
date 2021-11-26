<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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

function sendLoginInfoEmailByAdmin($requestUser, $password) {

    try {

        \Mail::send('emails.loginInfoByAdmin', ['requestUser' => $requestUser, 'password' => $password] ,function($message) use($requestUser) {
            $message->to($requestUser->email);
            $message->subject('Login Information');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendVerificationEmail($email) {

    $token = substr(md5(rand()),0,60);

    $user = User::where('email', $email)->update(['email_verification_code' => $token]);

    try {

        \Mail::send('emails.emailVerification', ['token' => $token] ,function($message) use($email) {
            $message->to($email);
            $message->subject('Email Verification');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendReminderOrderConfirmationEmail($userEmail, $orderID) {

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
            $message->subject('Reminder Order Confirmation Email');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendDailyOrderDetailsToAdminEmail($adminEmail) {

    try {

        $orderObject = Order::with(['billingInfo' => function($q) {

            return $q->with(['city' => function($q1) {

                return $q1->with(['state' => function($q2) {

                    return $q2->with(['country']);
                }]);

            }]);

        }, 'meal' => function($qq) {

            return $qq->with(['cookBillingInfo' => function($qq1) {

                return $qq1->with(['city' => function($qq2) {
    
                    return $qq2->with(['state' => function($qq3) {
    
                        return $qq3->with(['country']);
                    }]);

                }]);
    
            }, 'user']);

        }])->whereDate('delivery_time', date('Y-m-d'))->orderBy('delivery_time', 'ASC')->get();

        \Mail::send('emails.admin.dailyOrderDetails', ['orderObject' => $orderObject] ,function($message) use($adminEmail) {
            $message->to($adminEmail);
            $message->subject('Daily Order Details');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendEmailAmountWithDrawToUser($userEmail) {

    try {

        \Mail::send('emails.cook.amountWithdraw', [], function($message) use($userEmail) {
            $message->to($userEmail);
            $message->subject('Amount Withdraw Request');
        });
    }
    catch(\Exception $e) {

        //
    }
}

function sendEmailAmountWithDrawToAdmin($adminEmail, $userData, $amount) {

    try {

        \Mail::send('emails.admin.amountWithdraw', ['userData' => $userData, 'amount' => $amount], function($message) use($adminEmail) {
            $message->to($adminEmail);
            $message->subject('Amount Withdraw Request');
        });
    }
    catch(\Exception $e) {

        //
    }
}