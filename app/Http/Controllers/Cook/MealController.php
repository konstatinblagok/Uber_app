<?php

namespace App\Http\Controllers\Cook;

use Exception;
use App\Models\Meal;
use App\Models\FoodType;
use App\Models\Currency;
use App\Models\MealMedia;
use Illuminate\Http\Request;
use App\Models\CookFoodMedia;
use App\Models\CookFoodSpeciality;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function index(Request $request) {

        $userMeal = Meal::with('foodType')->where('user_id', Auth::user()->id)->where('expired', 0)->paginate(10);

        $data = [

            'userMeal' => $userMeal,
        ];
        
        return view('cook.meal.index', $data);
    }

    public function create(Request $request) {

        $cookMealTypeArray = CookFoodSpeciality::where('user_id', Auth::user()->id)->pluck('food_type_id')->toArray();
        $foodType = FoodType::whereIn('id', $cookMealTypeArray)->get();
        $currencies = Currency::all();

        $data = [

            'foodType' => $foodType,
            'currencies' => $currencies
        ];

        return view('cook.meal.create', $data);
    }

    public function store(Request $request) {
        
        try {

            $validator = Validator::make($request->all(), [
            
                'foodType' => 'bail|required',
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'currency' => 'bail|required',
                'price' => 'bail|required|min:1',
                'portion' => 'bail|required|min:1',
                'deliveryDate' => 'bail|required',
                'mealMedia' => 'bail|required',
            ]);
    
            if ($validator->fails()) {
    
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $cookFoodMediaIDArray = array();

            if($request->file('mealMedia') != null) {

                foreach ($request->file('mealMedia') as $file) {
                    
                    $cookFoodMedia = new CookFoodMedia();

                    $cookFoodMedia->user_id = Auth::user()->id;
                    $mime = $file->getMimeType();

                    if(strpos($mime, "video") !== false){
                        
                        $cookFoodMedia->type = 'video';
                    }
                    else if(strpos($mime, "image") !== false){
                        
                        $cookFoodMedia->type = 'image';
                    }

                    $name = Auth::user()->id.'_'.date('Y_m_d_H_i_s.u').'_'.$file->getClientOriginalName();

                    $cookFoodMedia->name = $name;
                    $cookFoodMedia->path = 'public/mediaFiles/cook/meal';
                    $cookFoodMedia->size = $file->getSize();

                    $file->move('public/mediaFiles/cook/meal', $name);

                    $cookFoodMedia->save();

                    $cookFoodMediaIDArray[] = $cookFoodMedia->id;
                }   
            }

            $meal = new Meal();

            $meal->user_id = Auth::user()->id;
            $meal->food_type_id = $request->foodType;
            $meal->title = $request->title;
            $meal->description = $request->description;
            $meal->currency_id = $request->currency;
            $meal->price = $request->price;
            $meal->portions = $request->portion;
            $meal->delivery_date = $request->deliveryDate;

            $meal->save();

            if(isset($cookFoodMediaIDArray) && count($cookFoodMediaIDArray) > 0) {

                foreach($cookFoodMediaIDArray as $value) {

                    $mealMedia = new MealMedia();
    
                    $mealMedia->meal_id = $meal->id;
                    $mealMedia->cook_food_media_id = $value;
    
                    $mealMedia->save();
                }
            }

            return redirect()->back()->with('success', 'Meal Added Successfully!');
        }
        catch(Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id) {
        
        $mealData = Meal::with(['mealMedia' => function($q) {
    
            return $q->with(['cookFoodMedia']);

        }])->where('id', $id)->first();

        if($mealData->user_id == Auth::user()->id) {

            $cookMealTypeArray = CookFoodSpeciality::where('user_id', Auth::user()->id)->pluck('food_type_id')->toArray();
            $foodType = FoodType::whereIn('id', $cookMealTypeArray)->get();
            $currencies = Currency::all();

            $data = [

                'meal' => $mealData,
                'foodType' => $foodType,
                'currencies' => $currencies
            ];

            return view('cook.meal.edit', $data);
        }
        else {

            return redirect()->back()->with('error', 'You are not allowed to edit this meal!');
        }
    }

    public function removeMedia(Request $request, $id) {

        $mealID = MealMedia::where('cook_food_media_id', $id)->first()->meal_id;

        if(Meal::where('id', $mealID)->first()->user_id == Auth::user()->id) {

            $mediaType = ucfirst(CookFoodMedia::where('id', $id)->first()->type);
            $cookFoodMediaRes = CookFoodMedia::where('id', $id)->delete();
        
            $mealMedia = MealMedia::where('cook_food_media_id', $id)->delete();

            return redirect()->route('cook.meal.edit', ['id' => $mealID])->with('success', $mediaType.' removes successfully!');
        }
        else {

            return redirect()->route('cook.meal.edit', ['id' => $mealID])->with('error', 'You are not allowed to delete this item!');
        }
    }

    public function update(Request $request, $id) {

        $meal = Meal::findOrFail($id);

        if($meal->user_id == Auth::user()->id) {

            $validator = Validator::make($request->all(), [
            
                'foodType' => 'bail|required',
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'currency' => 'bail|required',
                'price' => 'bail|required|min:1',
                'portion' => 'bail|required|min:1',
                'deliveryDate' => 'bail|required',
            ]);
    
            if ($validator->fails()) {
    
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if($request->file('mealMedia') != null) {

                foreach ($request->file('mealMedia') as $file) {
                    
                    $cookFoodMedia = new CookFoodMedia();

                    $cookFoodMedia->user_id = Auth::user()->id;
                    $mime = $file->getMimeType();

                    if(strpos($mime, "video") !== false){
                        
                        $cookFoodMedia->type = 'video';
                    }
                    else if(strpos($mime, "image") !== false){
                        
                        $cookFoodMedia->type = 'image';
                    }

                    $name = Auth::user()->id.'_'.date('Y_m_d_H_i_s.u').'_'.$file->getClientOriginalName();

                    $cookFoodMedia->name = $name;
                    $cookFoodMedia->path = 'public/mediaFiles/cook/meal';
                    $cookFoodMedia->size = $file->getSize();

                    $file->move('public/mediaFiles/cook/meal', $name);

                    $cookFoodMedia->save();

                    $cookFoodMediaIDArray[] = $cookFoodMedia->id;
                }   
            }

            $meal->user_id = Auth::user()->id;
            $meal->food_type_id = $request->foodType;
            $meal->title = $request->title;
            $meal->description = $request->description;
            $meal->currency_id = $request->currency;
            $meal->price = $request->price;
            $meal->portions = $request->portion;
            $meal->delivery_date = $request->deliveryDate;

            $meal->save();

            if(isset($cookFoodMediaIDArray) && count($cookFoodMediaIDArray) > 0) {

                foreach($cookFoodMediaIDArray as $value) {

                    $mealMedia = new MealMedia();
    
                    $mealMedia->meal_id = $meal->id;
                    $mealMedia->cook_food_media_id = $value;
    
                    $mealMedia->save();
                }
            }

            return redirect()->back()->with('success', 'Meal updated successfully!');
        }
        else {

            return redirect()->back()->with('error', 'You are not allowed to edit this meal!');
        }
    }
}
