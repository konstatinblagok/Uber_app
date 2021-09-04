<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Setting;
use App\Models\Country;
use App\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CookFoodSpeciality;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $foodTypes = FoodType::where('status', 1)->where('status', 1)->get();

        $contries = Country::all();

        $data = [
            
            'foodTypes' => $foodTypes,
            'contries' => $contries
        ];
        
        return view('auth.register', $data);
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'countryCode' => 'required',
            'phone' => 'bail|required|min:6|max:15', Rule::unique('users')->where(function ($query) use($request) {
                return $query->where('country_code', $request->countryCode)
                ->where('phone', $request->phone);
            }),
            'password' => 'bail|required|string|min:6',
            'password_confirmation' => 'bail|required|string|min:6|same:password',
            'userType' => 'bail|required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        else {

            $newUser = User::create([
                
                'name' => $request->name,
                'email' => $request->email,
                'country_code' => $request->countryCode,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_role_id' => $request->userType,
                'user_status_id' => (int)$request->userType == 2 ? 1 : 2,
                'is_approved' => (int)$request->userType == 2 ? 0 : 1,
                'approved_at' => (int)$request->userType == 2 ? NULL : date('Y-m-d H:i:s'),
                'admin_approved_verification_code' => substr(md5(rand()),0,60),
                'currency_id' => 1,
            ]);

            if($newUser) {

                sendLoginInfoEmail($request);
                sendVerificationEmail($request->email);

                if($newUser->isCook()) {

                    $data = array();
                    $foodSpecialityString = '';
    
                    foreach($request->foodType as $foodType) {
    
                        $data[] = ['user_id' => $newUser->id, 'food_type_id' => $foodType];
    
                        $foodSpecialityString .= FoodType::where('id', $foodType)->where('status', 1)->first() ? FoodType::where('id', $foodType)->where('status', 1)->first()->name.',' : '';
                    }
    
                    CookFoodSpeciality::insert($data);
                    
                    sendApprovalEmail(getAdminApprovalEmail(), $newUser->user_role_name, $newUser->name, $newUser->email, $foodSpecialityString, $newUser->admin_approved_verification_code);
    
                    return redirect()->route('login')->with('success', 'User registered successfully! Once admin approved your account then you will be notified through email to login.');
                } 
                else if($newUser->isCustomer()) {
    
                    Auth::login($newUser);

                    if(\Session::has('callBackUrl')) {

                        $url = \Session::get('callBackUrl');

                        \Session::forget('callBackUrl');
                        
                        return redirect()->to($url);
                    }
    
                    return redirect()->route('show.menu');
                }
            }
            else {

                return redirect()->route('register')->with('error', 'Something went wrong!');
            }
        }
    }
}
