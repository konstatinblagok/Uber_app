<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function dashboard(Request $request) {

        $todayOrder = Order::whereDate('created_at', date('Y-m-d'))->count();
        $todayEarning = Order::whereDate('created_at', date('Y-m-d'))->sum('net_total_amount');
        $totalEarning = Order::sum('net_total_amount');
        $totalOrder = Order::count();

        $todayCook = User::where('user_role_id', 2)->whereDate('created_at', date('Y-m-d'))->count();
        $todayCustomer = User::where('user_role_id', 3)->whereDate('created_at', date('Y-m-d'))->count();
        $totalCook = User::where('user_role_id', 2)->count();
        $totalCustomer = User::where('user_role_id', 3)->count();

        $monthArray = array();
        $orderDataArray = array();

        for($i = 1; $i <= 12; $i++) {

            $monthArray[] = substr(date('F', mktime(0, 0, 0, $i, 10)), 0, 3);

            if(strtotime(date('Y-m')) < strtotime(date('Y-'.$i))) {

                $orderDataArray[] = NULL;
            }
            else {

                $orderDataArray[] = Order::whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->count();
            }
        }

        $data = [

            'todayOrder' => $todayOrder,
            'todayEarning' => $todayEarning,
            'totalOrder' => $totalOrder,
            'totalEarning' => $totalEarning,
            'todayCook' => $todayCook,
            'todayCustomer' => $todayCustomer,
            'totalCook' => $totalCook,
            'totalCustomer' => $totalCustomer,
            'monthArray' => $monthArray,
            'orderDataArray' => $orderDataArray,
        ];

        return view('admin.dashboard', $data);
    }
}
