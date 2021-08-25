<?php

namespace App\Http\Controllers\Cook;

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function dashboard(Request $request) {

        $totalMeal = Meal::where('user_id', Auth::user()->id)->count();

        $mealIDArray = Meal::where('user_id', Auth::user()->id)->pluck('id')->toArray();

        $totalOrder = Order::whereIn('meal_id', $mealIDArray)->count();
        
        $data = [

            'totalMeal' => $totalMeal,
            'totalOrder' => $totalOrder,
        ];
        
        return view('cook.dashboard', $data);
    }
}
