<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\WithdrawRequest;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function allWithdrawRequest(Request $request) {

        if ($request->ajax()) {

            $data = WithdrawRequest::with(['user', 'currency', 'lastUpdatedByUser'])->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('user_name', function(WithdrawRequest $data){
                                
                                return $data->user->name;
                            })
                            ->addColumn('last_updated_by', function(WithdrawRequest $data){
                                
                                return isset($data->lastUpdatedByUser) ? $data->lastUpdatedByUser->name : '---';
                            })
                            ->addColumn('payment_method', function(WithdrawRequest $data){
                                
                                return isset($data->payment_method) ? $data->payment_method : '---';
                            })
                            ->addColumn('transaction_id', function(WithdrawRequest $data){
                                
                                return isset($data->transaction_id) ? $data->transaction_id : '---';
                            })
                            ->addColumn('remaining_balance', function(WithdrawRequest $data){
                                
                                return $data->user->currency->symbol.' '.$data->user->remaining_amount;
                            })
                            ->addColumn('total_amount', function(WithdrawRequest $data){
                                
                                return $data->currency->symbol.' '.$data->amount;
                            })                
                            ->addColumn('request_time', function(WithdrawRequest $data){
                                
                                return date('d-m-Y H:i', strtotime($data->created_at));
                            })
                            ->addColumn('withdraw_status', function(WithdrawRequest $data){
                                
                                if($data->status == 'Pending') {

                                    $type = '<span class="badge badge-primary">Pending</span>';
                                }
                                else if($data->status == 'Approved') {

                                    $type = '<span class="badge badge-info">Approved</span>';
                                }
                                else if($data->status == 'Transferred') {

                                    $type = '<span class="badge badge-success">Transferred</span>';
                                }
                                else if($data->status == 'Rejected') {
            
                                    $type = '<span class="badge badge-danger">Rejected</span>';
                                }

                                return $type;
                            })
                            ->addColumn('transfer_date', function(WithdrawRequest $data){
                                
                                if(isset($data->transfer_at)) {

                                    $type = date('d-m-Y', strtotime($data->transfer_at));
                                }
                                else {

                                    $type = '---';
                                }

                                return $type;
                            })
                            ->addColumn('action', function($row){
            
                                $btn = '<a href="' . route('admin.account.withdraw.request.detail', $row->id) . '" class="edit btn btn-primary btn-sm">View & Edit</a>';
            
                                    return $btn;
                            })
                            ->rawColumns(['withdraw_status', 'action'])
                            ->make(true);
        }

        return view('admin.account.allWithdrawRequest');
    }

    public function detailWithdrawRequest(Request $request, $id) {

        $withdraw = WithdrawRequest::with(['user' => function($q) {

            return $q->with(['latestBillingInfo' => function($q1) {

                return $q1->with('paymentMethod');

            }]);

        }, 'currency', 'lastUpdatedByUser'])->where('id', $id)->first();

        $paymentMethods = PaymentMethod::where('status', 1)->get();

        if(isset($withdraw) && $withdraw) {

            $data = [

                'withdraw' => $withdraw,
                'paymentMethods' => $paymentMethods,
            ];

            return view('admin.account.detailWithdrawRequest', $data);
        }
        else {

            return redirect()->route('admin.account.withdraw.request.all')->with('error', 'No data found!');
        }
    }

    public function updateDetailWithdrawRequest(Request $request, $id) {

        $withdraw = WithdrawRequest::find($id);

        if(isset($withdraw) && $withdraw) {

            $withdraw->status = $request->withdrawStatus;
            $withdraw->updated_by_user_id = Auth::user()->id;
            $withdraw->payment_method = $request->paymentMethod;
            $withdraw->transaction_id = $request->transactionID;
            $withdraw->transfer_at = $request->transferDate;

            $withdraw->save();

            if($withdraw->status == 'Rejected') {

                $user = User::find($withdraw->user_id);

                $user->remaining_amount = $user->remaining_amount + $withdraw->amount;

                $user->save();
            }

            return redirect()->back()->with('success', 'Request updated successfully!');
        }
        else {

            return redirect()->back()->with('error', 'No data found!');
        }
    }
}
