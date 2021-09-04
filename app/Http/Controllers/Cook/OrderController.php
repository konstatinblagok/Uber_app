<?php

namespace App\Http\Controllers\Cook;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CookReview;

class OrderController extends Controller
{
    public function __construct() {

        $this->middleware('auth-cook');
    }

    public function orderHistory(Request $request) {

        $orderList = Order::with(['billingInfo', 'payment', 'meal' => function ($q1) {

            return $q1->with(['user', 'foodType']);

        }, 'review'])->where('user_id', Auth::user()->id)->paginate(10);

        $data = [

            'orderList' => $orderList,
        ];

        return view('cook.order.history', $data);
    }

    public function orderReview(Request $request, $id) {

        $order = Order::findOrFail($id);

        if($order) {

            if($order->user_id == Auth::user()->id) {

                if($order->status == 'Delivered') {

                    $data = [

                        'order' => $order,
                    ];

                    return view('cook.order.review', $data);
                }
                else {
    
                    return redirect()->route('cook.order.history')->with('error', 'You can only give review when the order has been delivered!');
                }
            }
            else {

                return redirect()->route('cook.order.history')->with('error', 'You have not authorized for this order!');
            }
        }
        else {

            return redirect()->route('cook.order.history')->with('error', 'Order not found!');
        }
    }

    public function orderDetail(Request $request, $id) {

        $order = Order::findOrFail($id);

        if($order) {

            if($order->user_id == Auth::user()->id) {

                $order = Order::with(['billingInfo' => function ($q) {

                    return $q->with('city');

                }, 'payment', 'meal' => function ($q1) {

                    return $q1->with(['user', 'foodType', 'currency']);
        
                }, 'currency'])->where('id', $id)->where('user_id', Auth::user()->id)->first();

                $data = [
        
                    'order' => $order,
                ];
        
                return view('cook.order.detail', $data);
            }
            else {

                return redirect()->route('cook.order.history')->with('error', 'You have not authorized for this order!');
            }
        }
        else {

            return redirect()->route('cook.order.history')->with('error', 'Order not found!');
        }
    }

    public function saveReview(Request $request) {

        $order = Order::with(['meal'])->where('id', $request->orderID)->first();
        
        if($order) {

            if($order->user_id == Auth::user()->id) {

                if($order->status == 'Delivered') {

                    if(!(CookReview::where('order_id', $order->id)->exists())) {

                        $cookReview = new CookReview();

                        $cookReview->consumer_user_id = Auth::user()->id;
                        $cookReview->cook_user_id = $order->meal->user_id;
                        $cookReview->order_id = $order->id;
                        $cookReview->meal_id = $order->meal_id;
                        $cookReview->rating = $request->rating;
                        $cookReview->comments = $request->comment;

                        $cookReview->save();

                        $order->status = 'Completed';
                        $order->save();

                        $cookAverageRating = CookReview::where('cook_user_id', $order->meal->user_id)->avg('rating');

                        if($cookAverageRating < minimumRatingForCookAccountDeletion()) {

                            $user = User::findOrFail($order->meal->user_id);

                            $user->user_status_id = 4;
                            $user->user_status_remarks = 'Rating of foods is less than '.minimumRatingForCookAccountDeletion();

                            $user->save();
                        }

                        $status = true;
                        $message = 'Thanks for your feedback!';
                        $url = route('cook.order.history');
                    }
                    else {

                        $status = false;
                        $message = 'This order has been already rated.';
                        $url = '';
                    }
                }
                else {
    
                    $status = false;
                    $message = 'You can only give review when the order has been delivered!';
                    $url = '';
                }
            }
            else {

                $status = false;
                $message = 'You have not authorized for this order!';
                $url = '';
            }
        }
        else {

            $status = false;
            $message = 'Invalid Order ID!';
            $url = '';
        }

        return response()->json(['status' => $status, 'message' => $message, 'url' => $url]);
    }
}
