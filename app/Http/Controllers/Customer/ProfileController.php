<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct() {

        $this->middleware('auth-customer');
    }

    public function index(Request $request) {

        $user = Auth::user();
        
        $data = [

            'user' => $user,
        ];
        
        return view('customer.profile', $data);
    }

    public function save(Request $request) {

        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->name;

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
