<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BillingInfo;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function viewBillingInfo(Request $request) {
        if($request->info_id){
            $billing_info = BillingInfo::findOrFail($request->info_id);
        }

        return view('layouts.dashboard.billing-info',[
            'billing_info' => $billing_info ?? Auth::user()->getBillingInfos->first(),
        ]);
    }

    public function updateBillingInfo(Request $request) {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $billing_info = [
            'name' => $request->name,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => Auth::id(),
            'paypal_account_id' => $request->has('paypal_account_id') ? $request->paypal_account_id : null,
        ];

        $status = (!$request->info_id)
            ? BillingInfo::create($billing_info)
            : BillingInfo::findOrFail($request->info_id)->update($billing_info);

        return redirect()->back()->with([
            'message' => $status ? 'Successully added/updated the information' : 'Something went wrong',
        ]);
    }

    public function viewBalance() {
        return view('layouts.dashboard.withdraw');
    }

    public function checkout(Request $request) {
        return redirect()->back()->with(
            'message',
            'Your request has been submitted to the admin for approval.
             After approval the said amount will be transfered to your paypal account'
        );
    }
}
