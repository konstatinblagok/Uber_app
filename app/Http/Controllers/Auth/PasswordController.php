<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function __construct() {

        $this->middleware('guest');
    }

    public function email(Request $request) {

        return view('auth.password.email');
    }

    public function sendResetLink(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'email' => 'bail|required|string|email|max:255|exists:users,email',
        ],
        [
            'email.exists' => 'The entered email not exists!',    
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        $user->password_reset_token = substr(md5(rand()),0,60);

        $user->save();

        sendPasswordResetEmail($user->email, $user->password_reset_token);

        return redirect()->route('index')->with('success', 'Password reset link sent successfully!');
    }

    public function reset(Request $request, $token) {

        if(User::where('password_reset_token', $token)->exists()) {

            $data = [

                'token' => $token,
            ];

            return view('auth.password.reset', $data);
        }
        else {

            abort('404');
        }
    }

    public function resetPassword(Request $request) {

        $validator = Validator::make($request->all(), [
            
            'token' => 'bail|required|string|exists:users,password_reset_token',
            'password' => 'bail|required|string|min:6',
            'password_confirmation' => 'bail|required|string|min:6|same:password',
        ],
        [
            'token.exists' => 'Invalid password reset token',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::where('password_reset_token', $request->token)->first();

        $user->password = Hash::make($request->password);
        $user->password_reset_token = NULL;

        $user->save();

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }
}
