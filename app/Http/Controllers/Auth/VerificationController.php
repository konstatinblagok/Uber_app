<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
