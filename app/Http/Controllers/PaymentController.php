<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Facades\PayPal;
use \App\Http\Controllers\EmailController;

class PaymentController extends Controller {
    public $provider;
    private $meal;
    private $portions;

    public function __construct() {
        $this->provider = PayPal::setProvider();
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->setAccessToken($this->provider->getAccessToken());
    }
    public function orderPayment(Request $request) {
        $this->portions = $request->input('portions', 1);
        $this->meal = Meal::findOrFail($request->input('meal_id', null));

        $response = $this->provider->createOrder([
            "intent"=> "CAPTURE",
            'application_context' => [
                    'brand_name' => config('app.name'),
                    'locale' => 'en-US',
//                    'landing_page' => 'BILLING',
//                    'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('order.payment.success'),
                    'cancel_url' => route('order.payment.cancel'),
            ],
            "purchase_units"=> [
                0 => [
                'reference_id' => uniqid(),
                'description' => "{$this->portions} x {$this->meal->id} ({$this->meal->type->name}) Purchase",
                'custom_id' => config('app.name') . '-'. uniqid(),
                'soft_descriptor' => "{$this->meal->type->id} Purchase",
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '100.00',
                    'breakdown' => [
                        'item_total' => [
                                'currency_code' => 'USD',
                                'value' => '90.00',
                            ],
//                        'shipping' => [
//                                'currency_code' => 'USD',
//                                'value' => '20.00',
//                            ],
//                        'handling' => [
//                                'currency_code' => 'USD',
//                                'value' => '10.00',
//                            ],
                        'tax_total' => [
                                'currency_code' => 'USD',
                                'value' => '10.00',
                            ],
//                        'shipping_discount' => [
//                                'currency_code' => 'USD',
//                                'value' => '10.00',
//                            ],
                    ],
                ],
                'items' => [
                    0 => [
                        'name' => $this->meal->type->name,
                        'description' => $this->meal->type->name,
                        'sku' => "sku-".uniqid(),
                        'unit_amount' =>[
                            'currency_code' => 'USD',
                            'value' => '90.00',
                        ],
                        'tax' =>[
                            'currency_code' => 'USD',
                            'value' => '10.00',
                        ],
                        'quantity' => '1',
                        'category' => 'PHYSICAL_GOODS',
                    ],
                ],
//                'shipping' =>
//                    array(
//                        'method' => 'United States Postal Service',
//                        'address' =>
//                            array(
//                                'address_line_1' => '123 Townsend St',
//                                'address_line_2' => 'Floor 6',
//                                'admin_area_2' => 'San Francisco',
//                                'admin_area_1' => 'CA',
//                                'postal_code' => '94107',
//                                'country_code' => 'US',
//                            ),
//                    ),
                ]
            ]
        ]);

        if($response['status'] = 'CREATED'){
            Session::put('order_details', (object)[
                'order_id' => $response['id'],
                'meal_id' => $this->meal->id,
                'portions' => $this->portions,
            ]);
            return redirect(collect($response['links'])->firstWhere('rel', 'approve')['href']);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function orderCancel() {
        $order_details = Session::get('order_details');
        return redirect()->route('show-menu-details', $order_details->meal_id)->with([
            'status' => 'warning',
            'message' => 'Your payment is canceled. You can create cancel page here.'
        ]);
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function orderSuccess(Request $request) {
        $order_details = Session::get('order_details');
        $response = $this->provider->capturePaymentOrder($order_details->order_id);
        $payment_status = [
            'status' => 'error',
            'message' => 'Something went wrong.'
        ];

        if (!empty($response['status']) && $response['status'] == 'COMPLETED') {
            EmailController::sendMealPurchaseNotification($this->meal);
            $payment_status = [
                'status' => 'success',
                'message' => 'Successfully Purchased the meal.'
            ];
        }

        return redirect()->route('show-menu-details', $order_details->meal_id)->with($payment_status);
    }
}
