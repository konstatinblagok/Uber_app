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
            'todays_meals' => Meal::getTodaysMeal(),
        ]);
    }

    public function viewFoodSelectionForm($meal_id = null, Request $request){
        $meal = $meal_id
            ? Meal::findOrFail($request->meal_id)
            : null;

        return view('layouts.dashboard.food-selection-form',[
            'foods' => Food::all(),
            'meal' => $meal,
        ]);
    }

    public function addFoodSelection($meal_id = null, Request $request){
        $request->validate([
            'food' => 'required',
            'pickup_time' => 'required',
            'title' => 'required|string',
            'price' => 'required|integer|min:10',
            'description' => 'string',
        ]);

        $meal = Meal::find($meal_id);
        $meal_info = [
            'todays_food' => $request->food,
            'pickup_time' => Carbon::parse($request->pickup_time),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
        ];

        if(empty($meal)){
            $meal = Meal::create($meal_info);
            $status = true;
        } else {
            $status = $meal->update($meal_info);
        }

        return redirect("/food-selection/change/{$meal->id}")->with([
            'message' => $status ? 'Successully added/updated the information' : 'Something went wrong',
        ]);
    }

    public function showMenu(Request $request) {
        $meals = [];
        return view('layouts.site.menu', [
            'meals' => $meals
        ]);
    }

    public function showMenuDetails($menuId = null){
        $meal = Meal::findOrFail($menuId);
        return view('layouts.site.menu-details', [
            'meal' => $meal,
            'recent_meals' => Meal::where('user_id', $meal->user_id)->orderBy('created_at', 'desc')->limit(4)->get(),
            'food_types' => Food::all(),
        ]);
    }
}
