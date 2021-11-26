<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        $setting = Setting::all();

        $emailValue = '';
        $minimumWithdrawAmountValue = '';
        $deliveryServiceChargesValue = '';
        $deliveryStartTimeValue = '';
        $deliveryEndTimeValue = '';
        $mealPickupStartTimeValue = '';
        $mealPickupEndTimeValue = '';
        $paypalClientID = '';
        $paypalSecret = '';
        $paypalEnv = '';

        foreach($setting as $sett) {

            if($sett->parameter_name == 'admin_account_approval_email') {

                $emailValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'minimum_withdraw_amount') {

                $minimumWithdrawAmountValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'delivery_charges') {

                $deliveryServiceChargesValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'delivery_start_time') {

                $deliveryStartTimeValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'delivery_end_time') {

                $deliveryEndTimeValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'food_pickup_start_time') {

                $mealPickupStartTimeValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'food_pickup_end_time') {

                $mealPickupEndTimeValue = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'paypal_client_id') {

                $paypalClientID = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'paypal_secret') {

                $paypalSecret = $sett->parameter_value;
            }
            else if($sett->parameter_name == 'paypal_env') {

                $paypalEnv = $sett->parameter_value;
            }
        }

        $data = [

            'emailValue' => $emailValue,
            'minimumWithdrawAmountValue' => $minimumWithdrawAmountValue,
            'deliveryServiceChargesValue' => $deliveryServiceChargesValue,
            'deliveryStartTimeValue' => $deliveryStartTimeValue,
            'deliveryEndTimeValue' => $deliveryEndTimeValue,
            'mealPickupStartTimeValue' => $mealPickupStartTimeValue,
            'mealPickupEndTimeValue' => $mealPickupEndTimeValue,
            'paypalClientID' => $paypalClientID,
            'paypalSecret' => $paypalSecret,
            'paypalEnv' => $paypalEnv,
        ];
        
        return view('admin.setting', $data);
    }

    public function save(Request $request) {

        Setting::where('parameter_name', 'admin_account_approval_email')->update(['parameter_value' => $request->adminEmail]);
        Setting::where('parameter_name', 'minimum_withdraw_amount')->update(['parameter_value' => $request->cookMinAmount]);
        Setting::where('parameter_name', 'delivery_charges')->update(['parameter_value' => $request->deliveryServiceCharges]);
        Setting::where('parameter_name', 'delivery_start_time')->update(['parameter_value' => $request->deliveryStartTime]);
        Setting::where('parameter_name', 'delivery_end_time')->update(['parameter_value' => $request->deliveryEndTime]);
        Setting::where('parameter_name', 'food_pickup_start_time')->update(['parameter_value' => $request->pickupStartTime]);
        Setting::where('parameter_name', 'food_pickup_end_time')->update(['parameter_value' => $request->pickupEndTime]);
        Setting::where('parameter_name', 'paypal_client_id')->update(['parameter_value' => $request->paypalClientID]);
        Setting::where('parameter_name', 'paypal_secret')->update(['parameter_value' => $request->paypalSecret]);
        Setting::where('parameter_name', 'paypal_env')->update(['parameter_value' => $request->paypalEnv]);

        return redirect()->back()->with('success', 'Setting updated successfully!');
    }
}
