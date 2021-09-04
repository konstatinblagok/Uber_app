<?php

namespace App\Http\Controllers\Auth;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = !empty(request()->return_url) ?request()->return_url :RouteServiceProvider::HOME;
    }

    /**
     * Custom credentials to validate the status of user.
     * @param Request $request
     * @return array
     */
    public function credentials(Request $request) {
        
        return [

            'email'     => $request->email,
            'password'  => $request->password,
        ];
    }

    protected function attemptLogin(Request $request)
    {   
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user) {
        
        if($user->isApproved()) {

            if($user->isDeleted()) {

                $deleteReason = 'Your account has been deleted! ';

                if($user->user_status_remarks != NULL) {

                    $deleteReason .= $user->user_status_remarks.' ';
                }

                $deleteReason .= 'Please contact to admin! ';

                Auth::logout();

                return redirect()->route('login')->with('error', $deleteReason);
            }
            else {

                \Session::forget('url.intented');

                if($user->isCook()) {

                    if(checkCookBillingInfoStatus()) {

                        if(\Session::has('callBackUrl')) {

                            $url = \Session::get('callBackUrl');

                            \Session::forget('callBackUrl');

                            if(strpos($url, 'menu') !== false || strpos($url, 'meal') !== false) {

                                return redirect()->to($url);
                            }
                        }
    
                        return redirect()->route('cook.dashboard');
                    }
                    else {

                        if(\Session::has('callBackUrl')) {

                            $url = \Session::get('callBackUrl');

                            \Session::forget('callBackUrl');
                            
                            if(strpos($url, 'menu') !== false || strpos($url, 'meal') !== false) {

                                return redirect()->to($url);
                            }
                        }
    
                        return redirect()->route('cook.billing.info.index')->with('error', 'Please provide your billing information!');
                    }
                }
                else if($user->isCustomer()) {

                    if(\Session::has('callBackUrl')) {

                        $url = \Session::get('callBackUrl');

                        \Session::forget('callBackUrl');
                        
                        if(strpos($url, 'menu') !== false || strpos($url, 'meal') !== false) {

                            return redirect()->to($url);
                        }
                    }
    
                    return redirect()->route('show.menu');
                }
            }
        }
        else {

            Auth::logout();

            return redirect()->route('login')->with('error', 'Your account is not approved by admin!');
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->with('error', 'Email or password is incorrect!');
    }
}
