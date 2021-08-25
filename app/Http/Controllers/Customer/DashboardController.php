<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct() {

        $this->middleware('auth-customer');
    }

    public function dashboard(Request $request) {

        $totalOrders = Order::where('user_id', Auth::user()->id)->count();
        $approvedOrders = Order::where('user_id', Auth::user()->id)->where('status', 'Approved')->count();
        $deliveredOrders = Order::where('user_id', Auth::user()->id)->where('status', 'Delivered')->count();

        $data = [

            'totalOrder' => $totalOrders,
            'approvedOrder' => $approvedOrders,
            'deliveredOrder' => $deliveredOrders,
        ];
        
        return view('customer.dashboard', $data);
    }
}
