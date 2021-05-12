<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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
            'is_active' => '1'
        ];
    }

    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'exists:users,' . $this->username() . ',is_active,1',
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
        ]);
    }

    protected function authenticated(Request $request, $user) {
        if ( $user->isCook() ) {
            $isFoodSelected = Meal::where('user_id', $user)
                ->whereDate('created_at',now())
                ->exists();

            if(!$isFoodSelected){
                return redirect()->route('view-food-selection');
            }
        }

        return redirect($this->redirectTo);
    }
}
