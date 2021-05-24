<?php

namespace App\Http\Controllers;

use App\Mail\MealPurchaseNotification;
use App\Mail\UserActiveNotification;
use App\Mail\UserSignupNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Send an e-mail reminder to the user.
     * @param  User $user
     */
    public static function sendSignupNotification($user) {
        $admin_users = User::where('type', 'u_admin')->get();
        foreach($admin_users as $admin_user){
            Mail::queue(new UserSignupNotification($admin_user, $user));
        }
    }

    public static function sendUserActiveNotification($user) {
        Mail::queue(new UserActiveNotification($user));
    }

    public static function sendMealPurchaseNotification($meal) {
        Mail::queue(new MealPurchaseNotification($meal));
    }
}
