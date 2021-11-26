<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct() {

        $this->middleware('auth-admin');
    }

    public function all(Request $request) {

        if ($request->ajax()) {

            $data = Order::with(['payment', 'meal' => function($q) {

                return $q->with(['user', 'foodMenuCategory', 'foodType']);

            }, 'user', 'currency', 'billingInfo' => function($q1) {

                return $q1->with('city');

            }])->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('user_name', function(Order $data){
                                
                                return $data->user->name;
                            })
                            ->addColumn('meal_title', function(Order $data){
                                
                                return $data->meal->title;
                            })
                            ->addColumn('payment_method', function(Order $data){
                                
                                return $data->payment->payment_method;
                            })
                            ->addColumn('transaction_id', function(Order $data){
                                
                                return $data->payment->payment_transaction_id;
                            })
                            ->addColumn('payer_email', function(Order $data){
                                
                                return $data->payment->payer_email;
                            })
                            ->addColumn('total_amount', function(Order $data){
                                
                                return $data->payment->total_amount.' '.$data->payment->currency;
                            })
                            ->addColumn('delivery_date_time', function(Order $data){
                                
                                return date('d-m-Y H:i', strtotime($data->delivery_time));
                            })
                            ->addColumn('order_status', function(Order $data){
                                
                                if($data->status == 'Pending') {

                                    $type = '<span class="badge badge-primary">Pending</span>';
                                }
                                else if($data->status == 'Approved') {

                                    $type = '<span class="badge badge-info">Approved</span>';
                                }
                                else if($data->status == 'Processing') {

                                    $type = '<span class="badge badge-warning">Processing</span>';
                                }
                                else if($data->status == 'Delivered') {
            
                                    $type = '<span class="badge badge-success">Delivered</span>';
                                }
                                else if($data->status == 'Cancel') {

                                    $type = '<span class="badge badge-danger">Cancel</span>';
                                }
                                else if($data->status == 'Completed') {
            
                                    $type = '<span class="badge badge-secondary">Completed</span>';
                                }

                                return $type;
                            })
                            ->addColumn('action', function($row){
            
                                $btn = '<a href="' . route('admin.order.view.edit', $row->id) . '" class="edit btn btn-primary btn-sm">View & Edit</a>';
            
                                    return $btn;
                            })
                            ->rawColumns(['order_status', 'action'])
                            ->make(true);
        }

        return view('admin.order.index');
    }

    public function viewEdit(Request $request, $id) {

        $order = Order::find($id);

        if(isset($order) && $order) {

            $data = [

                'order' => $order,
            ];
    
            return view('admin.order.viewEdit', $data);
        }
        else {

            return redirect()->route('admin.order.all')->with('error', 'No data found!');
        }
    }

    public function saveViewEdit(Request $request, $id) {
        
        $order = Order::find($id);

        if(isset($order) && $order) {

            $order->status = $request->orderStatus;
            $order->status_remarks = $request->statusRemarks;
            
            if(isset($request->deliveredAtDate) && isset($request->deliveredAtTime)) {

                $order->delivered_at = $request->deliveredAtDate.' '.$request->deliveredAtTime;
            }

            $order->save();

            return redirect()->back()->with('success', 'Order updated successfully!');
        }
        else {

            return redirect()->route('admin.order.all')->with('error', 'No data found!');
        }
    }
}
