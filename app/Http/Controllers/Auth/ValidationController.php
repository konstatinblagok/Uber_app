<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function email(Request $request) {

        $emailResponse = userEmailExists($request->email);

        return response()->json(array('success' => $emailResponse));
    }
}
