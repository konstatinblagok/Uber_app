<?php

namespace App\Http\Controllers\Ajax;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryStateCityController extends Controller
{
    public function getState(Request $request) {

        $states = State::where('country_id', $request->countryID)->where('status', 1)->get();

        return response()->json(['states' => $states]);
    }

    public function getCity(Request $request) {

        $cities = City::where('state_id', $request->stateID)->where('status', 1)->get();

        return response()->json(['cities' => $cities]);
    }
}
