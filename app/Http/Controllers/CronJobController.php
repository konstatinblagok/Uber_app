<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    public function index() {

        $allMeals = Meal::with(['user'])->where('expired', 0)->get();

        foreach($allMeals as $meal) {

            if(strtotime($meal->delivery_date) == strtotime(date('Y-m-d'))) {

                if(strtotime(date('Y-m-d H:i:s')) >= strtotime(date('Y-m-d '.portionMailToCookTime().':00')) && $meal->mail_to_cook == 0) {

                    sendCookReservedPortionEmail($meal->user->email, $meal);

                    $meal->mail_to_cook = true;

                    $meal->save();
                }
            }
            else {

                $expireDate = strtotime(date($meal->delivery_date) . ' + 7 days');

                if (time() > $expireDate) {

                    $meal->expired = true;
                    $meal->expired_at = date('Y-m-d H:i:s');

                    $meal->save();
                }
            }
        }
    }
}
