<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Menu;
use App\Models\Meal;
use App\Models\Country;
use App\Models\FoodType;
use App\Models\ContactUs;
use App\Models\CookReview;
use App\Models\BillingInfo;
use Illuminate\Http\Request;
use App\Models\FoodMenuCategory;
use App\Models\ReviewBasedCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    public function showHomePage(){
        
        try {

            return view('index');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }        
    }

    public function showAboutUsPage() {

        try {

            return view('frontend.about-us');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        } 
    }

    public function showOurVisionPage() {

        try {

            return view('frontend.our-vision');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showHowItWorkPage() {

        try {

            return view('frontend.how-it-works');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showContactUsPage() {

        try {

            return view('frontend.contact-us');
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function storeContactUs(Request $request) {

        try {

            $contact = new ContactUs();

            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;

            $contact->save();

            session()->flash("success", "Thanks for contacting us!");

            return redirect()->back();
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', 'Some went wrong!');
        }
    }

    public function showMenuPage(Request $request) {

        try {

            if($request->minRating != '') {

                $minRatingVal = (int)$request->minRating;
                $minRatingVal = $minRatingVal < 0 ? 0 : $minRatingVal;
                $minRatingVal = $minRatingVal > 5 ? 5 : $minRatingVal;

                $minRatingCookIDs = DB::table('users')
                                        ->join('cook_reviews', 'users.id', '=', 'cook_reviews.cook_user_id')
                                        ->select('users.id')
                                        ->selectRaw('AVG(cook_reviews.rating) AS average_rating')
                                        ->groupBy('users.id')
                                        ->havingRaw('AVG(cook_reviews.rating) >= ?', [$minRatingVal])
                                        ->pluck('user.id')
                                        ->toArray();
            }

            if($request->maxRating != '') {

                $maxRatingVal = (int)$request->maxRating;
                $maxRatingVal = $maxRatingVal < 0 ? 0 : $maxRatingVal;
                $maxRatingVal = $maxRatingVal > 5 ? 5 : $maxRatingVal;

                $maxRatingCookIDs = DB::table('users')
                                        ->join('cook_reviews', 'users.id', '=', 'cook_reviews.cook_user_id')
                                        ->select('users.id')
                                        ->selectRaw('AVG(cook_reviews.rating) AS average_rating')
                                        ->groupBy('users.id')
                                        ->havingRaw('AVG(cook_reviews.rating) <= ?', [$maxRatingVal])
                                        ->pluck('user.id')
                                        ->toArray();
            }

            if(isset($request->mealCategory) && $request->mealCategory != '') {

                $foodTypeArray = FoodType::where('food_menu_category_id', $request->mealCategory)->pluck('id')->toArray();
                $mealIDCategory = Meal::whereIn('food_type_id', $foodTypeArray)->pluck('id')->toArray();
            }

            if(isset($request->mealType) && $request->mealType != '') {

                $mealIDType = Meal::where('food_type_id', $request->mealType)->pluck('id')->toArray();
            }
            
            if(isset($mealIDCategory) && isset($mealIDType)) {

                $finalMealArray = array_intersect($mealIDCategory, $mealIDType);
            }
            else {

                if(isset($mealIDCategory)) {

                    $finalMealArray = $mealIDCategory;
                }
                if(isset($mealIDType)) {

                    $finalMealArray = $mealIDType;
                }
            }

            $menu = Meal::with(['mealMedia' => function($q1) {

                return $q1->with(['cookFoodMedia']);

            }, 'user', 'foodType' => function($q3) use ($request) {

                return $q3->with(['foodMenuCategory']);

            }, 'currency'])->where('expired', false);

            if(isset($finalMealArray)) {

                $menu->whereIn('id', $finalMealArray, 'and');
            }
            
            if(isset($minRatingCookIDs)) {

                $menu->whereIn('user_id', $minRatingCookIDs);
            }

            if(isset($maxRatingCookIDs)) {

                $menu->whereIn('user_id', $maxRatingCookIDs);
            }

            if(isset($request->deliveryDate) && $request->deliveryDate != '') {

                $menu->where('delivery_date', $request->deliveryDate);
            }

            $menuResult = $menu->orderBy('price', 'ASC')->paginate(10);

            $mealCategories = FoodMenuCategory::all();
            $mealType = FoodType::all();

            $data = [

                'menu' => $menuResult,
                'mealCategories' => $mealCategories,
                'mealType' => $mealType,
            ];
            
            return view('frontend.menu', $data);
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showMealDetail(Request $request, $id) {

        try {

            if(getMealAvailablePortion($id) <= 0) {

                return redirect()->route('show.menu')->with('info', 'Sold out! Someone was hungrier than you.');
            }

            $mealExist = Meal::where('id', $id)->first();

            if($mealExist->mail_to_cook == 1) {

                return redirect()->route('show.menu')->with('info', 'Reservation closed!');
            }

            if($mealExist) {

                $mealDetails = Meal::with(['foodType', 'mealMedia' => function($q2) {
    
                    return $q2->with(['cookFoodMedia']);
    
                }, 'user' => function($q5) {

                    return $q5->with('cookReview');

                }, 'currency'])->where('id', $id)->first();

                $userReview = $userReviewAverage = CookReview::where('cook_user_id', $mealDetails->user->id)->average('rating');
                $userReviewCount = CookReview::where('cook_user_id', $mealDetails->user->id)->count();

                if($userReviewAverage > 0 && $userReviewAverage >= 3) {

                    $userReviewAverage = floor($userReviewAverage);
                }
                else {

                    $userReview = 5;
                }

                $reviewBasedPrice = ReviewBasedCharge::with('currency')->where('rating_number', $userReviewAverage)->first();
                $countries = Country::where('status', 1)->get();
                $cookReviews = CookReview::with(['user'])->where('meal_id', $id)->get();

                if(Auth::check()) {

                    $billingInfo = BillingInfo::with(['city' => function($query) {

                        return $query->with(['state' => function($query1) {
    
                            return $query1->with(['country']);
                        }]);
    
                    }])->where('user_id', Auth::user()->id)->latest('updated_at')->first();
                }

                $data = [
    
                    'mealDetails' => $mealDetails,
                    'reviewBasedPrice' => $reviewBasedPrice,
                    'userReview' => $userReview,
                    'userReviewCount' => $userReviewCount,
                    'countries' => $countries,
                    'billingInfo' => isset($billingInfo) ? $billingInfo : null,
                    'cookReviews' => $cookReviews,
                ];
                
                return view('frontend.mealDetails', $data);
            }
            
            else {

                return redirect()->back()->with('error', 'No meal details found');
            }
        }

        catch(Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
