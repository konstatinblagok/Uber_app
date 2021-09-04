<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function accountApprovedByAdmin($secret) {

        $approvedUser = User::where('admin_approved_verification_code', $secret)->first();

        $message = 'Sorry this account cannot be identified.';
  
        if($approvedUser){
              
            if($approvedUser->is_approved == 0) {

                $approvedUser->is_approved = 1;
                $approvedUser->user_status_id = 2;
                $approvedUser->approved_at = date('Y-m-d H:i:s');

                $approvedUser->save();
                
                $message = "Account is approved by admin.";

                sendApprovalEmailResponse($approvedUser->name, $approvedUser->email);
            } 
            else {

                $message = "This account is already approved.";
            }
        }
  
        return $message;
    }

    public function emailVerificationByUser($secret) {

        $approvedUser = User::where('email_verification_code', $secret)->first();

        $message = 'Sorry this account cannot be identified.';
  
        if($approvedUser){
              
            if($approvedUser->email_verified_at == NULL) {

                $approvedUser->email_verified_at = date('Y-m-d H:i:s');

                $approvedUser->save();
                
                $message = "Email is verified.";
            } 
            else {

                $message = "Email is already verified.";
            }
        }
  
        return $message;
    }

    public function resendVerificationEmail() {

        sendVerificationEmail(Auth::user()->email);

        return redirect()->back()->with('success', 'Verification email sent successfully!');
    }
}
