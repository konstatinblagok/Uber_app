<?php

namespace App\Http\Controllers\Cook;

use Exception;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function index(Request $request) {

        $withdraw = WithdrawRequest::with(['currency'])->where('user_id', Auth::user()->id)->paginate(10);

        $data = [

            'withdraw' => $withdraw,
        ];
        
        return view('cook.account.index', $data);
    }

    public function withdrawAmount(Request $request) {

        $currencies = Currency::where('status', 1)->get();

        $data = [

            'currencies' => $currencies,
        ];
        
        return view('cook.account.withdraw', $data);
    }

    public function withdraw(Request $request) {

        try {

            $withdraw = new WithdrawRequest();

            $withdraw->user_id = Auth::user()->id;
            $withdraw->currency_id = $request->currency;
            $withdraw->amount = $request->amount;
            $withdraw->status = 'Pending';

            $withdraw->save();

            $userData = User::findOrFail(Auth::user()->id);

            $userData->remaining_amount = (double)$userData->remaining_amount - (double)$request->amount;

            $userData->save();

            return redirect()->back()->with('success', 'Your withdrawal request is successfully transfered to admin.');
        }
        catch(Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
