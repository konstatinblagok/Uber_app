<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    public function index() {

        //Meal Related Task
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

                $expireDate = strtotime(date($meal->delivery_date) . ' + '.mealRemoveFromWebAfterDays().' days');

                if (time() > $expireDate) {

                    $meal->expired = true;
                    $meal->expired_at = date('Y-m-d H:i:s');

                    $meal->save();
                }
            }
        }

        //Order Related Task
        $allOrders = Order::with(['meal' => function($q) {

            return $q->with('user');

        }, 'user'])->whereDate('delivery_time', date('Y-m-d'))->where('reminder_email', 0)->whereIn('status', ['Pending', 'Approved', 'Processing'])->get();

        foreach($allOrders as $order) {

            sendReminderOrderConfirmationEmail($order->user->email, $order->id);
            sendReminderOrderConfirmationEmail($order->meal->user->email, $order->id);

            $order->reminder_email = 1;

            $order->save();
        }

        //Admin Order Email Task
        if(strtotime(date('Y-m-d H:i:s')) >= strtotime(date('Y-m-d 16:00:00')) && Order::whereDate('delivery_time', date('Y-m-d'))->where('admin_email', 0)->exists()) {

            sendDailyOrderDetailsToAdminEmail(getAdminApprovalEmail());

            Order::whereDate('delivery_time', date('Y-m-d'))->update(['admin_email' => 1]);
        }
    }
}
