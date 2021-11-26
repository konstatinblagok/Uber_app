<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Meal;
use App\Models\Currency;
use App\Models\FoodType;
use App\Models\MealMedia;
use Illuminate\Http\Request;
use App\Models\CookFoodMedia;
use App\Models\FoodMenuCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        if ($request->ajax()) {

            $data = Meal::with(['foodMenuCategory', 'user', 'currency', 'foodType', 'mealMedia'])->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('cook_name', function(Meal $data){
                                
                                return $data->user->name;
                            })
                            ->addColumn('category', function(Meal $data){
                                
                                return $data->foodMenuCategory->name;
                            })
                            ->addColumn('type', function(Meal $data){
                                
                                return $data->foodType->name;
                            })
                            ->addColumn('total_amount', function(Meal $data){
                                
                                return $data->currency->symbol.' '.$data->price;
                            })
                            ->addColumn('delivery_date', function(Meal $data){
                                
                                return date('d-m-Y', strtotime($data->delivery_date));
                            })
                            ->addColumn('status', function(Meal $data){
                                
                                if($data->expired == 0) {

                                    $type = '<span class="badge badge-success">Active</span>';
                                }
                                else {

                                    $type = '<span class="badge badge-danger">Expired</span>';
                                }

                                return $type;
                            })
                            ->addColumn('expired_time', function(Meal $data){

                                return isset($data->expired_at) ? date('d-m-Y H:i', strtotime($data->expired_at)) : '---';
                            })
                            ->addColumn('action', function($row){
            
                                $btn = '<a href="' . route('admin.meal.edit', $row->id) . '" class="edit btn btn-primary btn-sm">View & Edit</a>';
            
                                return $btn;
                            })
                            ->rawColumns(['status', 'action'])
                            ->make(true);
        }

        return view('admin.meal.all');
    }

    public function create(Request $request) {

        $users = User::where('user_role_id', cookUserRoleID())->get();
        $categories = FoodMenuCategory::where('status', 1)->get();
        $types = FoodType::where('status', 1)->get();
        $currencies = Currency::where('status', 1)->get();

        $data = [

            'users' => $users,
            'categories' => $categories,
            'types' => $types,
            'currencies' => $currencies,
        ];

        return view('admin.meal.create', $data);
    }

    public function save(Request $request) {

        try {

            $validator = Validator::make($request->all(), [
            
                'cook' => 'required',
                'category' => 'required',
                'type' => 'required',
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'currency' => 'required',
                'price' => 'bail|required|min:1',
                'portions' => 'bail|required|min:1',
                'pickupDate' => 'required',
                'mealMedia' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $cookFoodMediaIDArray = array();

            if($request->file('mealMedia') != null) {

                foreach ($request->file('mealMedia') as $file) {
                    
                    $cookFoodMedia = new CookFoodMedia();

                    $cookFoodMedia->user_id = $request->cook;
                    $mime = $file->getMimeType();

                    if(strpos($mime, "video") !== false){
                        
                        $cookFoodMedia->type = 'video';
                    }
                    else if(strpos($mime, "image") !== false){
                        
                        $cookFoodMedia->type = 'image';
                    }

                    $name = $request->cook.'_'.date('Y_m_d_H_i_s.u').'_'.$file->getClientOriginalName();

                    $cookFoodMedia->name = $name;
                    $cookFoodMedia->path = 'public/mediaFiles/cook/meal';
                    $cookFoodMedia->size = $file->getSize();

                    $file->move('public/mediaFiles/cook/meal', $name);

                    $cookFoodMedia->save();

                    $cookFoodMediaIDArray[] = $cookFoodMedia->id;
                }   
            }

            $meal = new Meal();

            $meal->user_id = $request->cook;
            $meal->food_category_id = $request->category;
            $meal->food_type_id = $request->type;
            $meal->title = $request->title;
            $meal->description = $request->description;
            $meal->currency_id = $request->currency;
            $meal->price = $request->price;
            $meal->portions = $request->portions;
            $meal->delivery_date = $request->pickupDate;

            $meal->save();

            if(isset($cookFoodMediaIDArray) && count($cookFoodMediaIDArray) > 0) {

                foreach($cookFoodMediaIDArray as $value) {

                    $mealMedia = new MealMedia();
    
                    $mealMedia->meal_id = $meal->id;
                    $mealMedia->cook_food_media_id = $value;
    
                    $mealMedia->save();
                }
            }

            return redirect()->back()->with('success', 'Meal added successfully!');
        }
        catch(Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function edit(Request $request, $id) {

        $mealData = Meal::with(['mealMedia' => function($q) {
    
            return $q->with(['cookFoodMedia']);

        }, 'user'])->where('id', $id)->first();

        if($mealData) {

            $users = User::where('user_role_id', cookUserRoleID())->get();
            $types = FoodType::where('status', 1)->get();
            $categories = FoodMenuCategory::where('status', 1)->get();
            $currencies = Currency::where('status', 1)->get();

            $data = [

                'meal' => $mealData,
                'types' => $types,
                'currencies' => $currencies,
                'categories' => $categories,
                'users' => $users,
            ];

            return view('admin.meal.edit', $data);
        }
        else {

            return redirect()->back()->with('error', 'No data found!');
        }
    }

    public function update(Request $request, $id) {

        try {

            $validator = Validator::make($request->all(), [
            
                'cook' => 'required',
                'category' => 'required',
                'type' => 'required',
                'title' => 'bail|required|string',
                'description' => 'bail|required|string',
                'currency' => 'required',
                'price' => 'bail|required|min:1',
                'portions' => 'bail|required|min:1',
                'pickupDate' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $cookFoodMediaIDArray = array();

            if($request->file('mealMedia') != null) {

                foreach ($request->file('mealMedia') as $file) {
                    
                    $cookFoodMedia = new CookFoodMedia();

                    $cookFoodMedia->user_id = $request->cook;
                    $mime = $file->getMimeType();

                    if(strpos($mime, "video") !== false){
                        
                        $cookFoodMedia->type = 'video';
                    }
                    else if(strpos($mime, "image") !== false){
                        
                        $cookFoodMedia->type = 'image';
                    }

                    $name = $request->cook.'_'.date('Y_m_d_H_i_s.u').'_'.$file->getClientOriginalName();

                    $cookFoodMedia->name = $name;
                    $cookFoodMedia->path = 'public/mediaFiles/cook/meal';
                    $cookFoodMedia->size = $file->getSize();

                    $file->move('public/mediaFiles/cook/meal', $name);

                    $cookFoodMedia->save();

                    $cookFoodMediaIDArray[] = $cookFoodMedia->id;
                }   
            }

            $meal = Meal::findOrFail($id);

            $meal->user_id = $request->cook;
            $meal->food_category_id = $request->category;
            $meal->food_type_id = $request->type;
            $meal->title = $request->title;
            $meal->description = $request->description;
            $meal->currency_id = $request->currency;
            $meal->price = $request->price;
            $meal->portions = $request->portions;
            $meal->delivery_date = $request->pickupDate;

            $meal->save();

            if(isset($cookFoodMediaIDArray) && count($cookFoodMediaIDArray) > 0) {

                foreach($cookFoodMediaIDArray as $value) {

                    $mealMedia = new MealMedia();
    
                    $mealMedia->meal_id = $meal->id;
                    $mealMedia->cook_food_media_id = $value;
    
                    $mealMedia->save();
                }
            }

            return redirect()->back()->with('success', 'Meal added successfully!');
        }
        catch(Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function removeMedia(Request $request, $id) {

        $mealID = MealMedia::where('cook_food_media_id', $id)->first()->meal_id;

        $mediaType = ucfirst(CookFoodMedia::where('id', $id)->first()->type);
        $cookFoodMediaRes = CookFoodMedia::where('id', $id)->delete();
        
        $mealMedia = MealMedia::where('cook_food_media_id', $id)->delete();

        return redirect()->route('admin.meal.edit', ['id' => $mealID])->with('success', $mediaType.' removes successfully!');
    }
}
