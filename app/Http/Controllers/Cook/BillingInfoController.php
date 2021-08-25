<?php

namespace App\Http\Controllers\Cook;

use App\Models\Country;
use App\Models\BillingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BillingInfoController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function index(Request $request) {

        $countries = Country::where('status', 1)->get();
        $billingInfo = BillingInfo::with(['city' => function($query) {

            return $query->with(['state' => function($query1) {

                return $query1->with(['country']);
            }]);

        }])->where('user_id', Auth::user()->id)->first();

        $data = [

            'countries' => $countries,
            'billingInfo' => $billingInfo
        ];
        
        return view('cook.billingInfo', $data);
    }

    public function saveInfo(Request $request) {

        $msg = '';

        if(BillingInfo::where('user_id', Auth::user()->id)->exists()) {

            $billInfo = BillingInfo::where('user_id', Auth::user()->id)->first();
            $msg = 'Billing Information updated successfully!';
        }
        else {

            $billInfo = new BillingInfo();
            $msg = 'Billing Information added successfully!';
        }

        $billInfo->user_id = Auth::user()->id;
        $billInfo->first_name = $request->firstName;
        $billInfo->last_name = $request->lastName;
        $billInfo->address = $request->address;
        $billInfo->apartment_suite_unit = $request->apartmentSuiteUnit;
        $billInfo->city_id = $request->city;
        $billInfo->zip_code = $request->zipCode;
        $billInfo->payment_method_id = $request->paymentMethodType;
        $billInfo->paypal_email = $request->paypalEmail;
        $billInfo->card_number = $request->creditCardNumber;
        $billInfo->card_expiry_date = $request->creditCardMonth.'/'.$request->creditCardYear;
        $billInfo->card_cvv = $request->creditCardCVV;

        $billInfo->save();

        return redirect()->route('cook.dashboard')->with('success', $msg);
    }
}
