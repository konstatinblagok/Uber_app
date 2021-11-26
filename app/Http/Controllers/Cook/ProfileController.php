<?php

namespace App\Http\Controllers\Cook;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function index(Request $request) {

        $user = Auth::user();
        $contries = Country::where('status', 1)->get();
        
        $data = [

            'user' => $user,
            'contries' => $contries,
        ];
        
        return view('cook.profile', $data);
    }

    public function save(Request $request) {

        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->country_code = $request->countryCode;
        $user->phone = $request->phone;

        if($request->newPassword != null) {

            if($request->currentPassword != null) {

                if(strlen($request->newPassword) >= 6) {

                    if($request->newPassword == $request->confirmNewPassword) {

                        if(Hash::check($request->currentPassword, $user->password)) {
                            
                            $user->password = Hash::make($request->newPassword);
                        }
                        else {

                            return redirect()->back()->with('error', 'Current password is incorrect!');
                        }
                    }
                    else {

                        return redirect()->back()->with('error', 'Password and confirm password are not the same!');
                    }
                }
                else {

                    return redirect()->back()->with('error', 'Password must be at least 6 characters long!');
                }
            }
            else {

                return redirect()->back()->with('error', 'Please enter your current password!');
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
