<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function profile(Request $request) {

        $contries = Country::where('status', 1)->get();

        $data = [

            'contries' => $contries,
        ];
        
        return view('admin.profile', $data);
    }

    public function saveProfile(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users,email,'.Auth::user()->id,
            'countryCode' => 'required',
            'phone' => 'bail|required|min:6|max:15', Rule::unique('users')->where(function ($query) use($request) {

                return $query->where('id', '!=', Auth::user()->id)->where('country_code', $request->countryCode)->where('phone', $request->phone);
            }),
            'password' => 'nullable|string|min:6',
            'confirmPassword' => 'nullable|string|min:6|same:password',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->country_code = $request->countryCode;
        $user->phone = $request->phone;

        if(isset($request->password) && trim($request->password) != '' && isset($request->confirmPassword) && trim($request->confirmPassword) != '') {

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User profile updated successfully!');
    }
}
