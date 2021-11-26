<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function email(Request $request) {

        $emailResponse = userEmailExists($request->email, $request->requestSource, $request->userID);

        return response()->json(array('success' => $emailResponse));
    }

    public function phone(Request $request) {
        
        $phoneResponse = userPhoneExists($request->phone, $request->countryCode, $request->requestSource, $request->userID);

        return response()->json(array('success' => $phoneResponse));
    }
}
