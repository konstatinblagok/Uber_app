<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function viewFoodSelection(){
        return view('layouts.dashboard.food-selection',[
            'foods' => Food::all(),
            'todays_meal' => Meal::getTodaysMeal(),
        ]);
    }

    public function addFoodSelection(Request $request){
        $request->validate([
            'food' => 'required',
            'pickup_time' => 'required',
        ]);

        $todays_meal = Meal::getTodaysMeal();
        $meal_info = [
            'todays_food' => $request->food,
            'pickup_time' => Carbon::parse($request->pickup_time),
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $status = empty($todays_meal)
                ?Meal::insert($meal_info)
                :$todays_meal->update($meal_info);

        return redirect()->back()->with([
            'message' => $status ? 'Successully added/updated the information' : 'Something went wrong',
        ]);
    }
}
