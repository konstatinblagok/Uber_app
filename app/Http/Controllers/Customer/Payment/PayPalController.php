<?php

namespace App\Http\Controllers\Customer\Payment;

use PayPal\Api\Item;
use App\Models\Meal;
use App\Models\User;
use PayPal\Api\Payer;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use App\Models\CookReview;
use App\Models\CookEarning;
use PayPal\Rest\ApiContext;
use PayPal\Api\Transaction;
use App\Models\BillingInfo;
use PayPal\Api\RedirectUrls;
use Illuminate\Http\Request;
use PayPal\Api\PaymentExecution;
use App\Models\ReviewBasedCharge;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Session;
use App\Models\Payment as PaymentModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PayPalController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

        $this->middleware('auth-customer');
    }
    
    public function pay(Request $request) {

        //Data Remove From Session
        Session::forget(['globalMealID', 'globalMealQuantity', 'globalMealPrice', 'globalMealReviewPrice', 'globalMealDeliveryPrice', 'globalMealTotalNetPrice', 'globalMealDeliveryTime']);
        
        //Validation
        $validator = Validator::make($request->all(), [
            
            'totalQuantityInput' => 'bail|required|numeric|min:1',
            'mealIDInput' => 'bail|required|exists:meals,id',
            'deliveryTimeInput' => 'bail|required',
        ],[

            'mealIDInput.exists' => 'Invalid Meal ID!',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        if($request->deliveryTimeInput >= date(getDeliveryStartTime()) && $request->deliveryTimeInput <= date(getDeliveryEndTime())) {
    
            //
        }
        else {
            
            return redirect()->back()->with('error', 'Delivery Time should be between '.getDeliveryStartTime().' - '.getDeliveryEndTime().'!');
        }

        //User Billing Information
        if(BillingInfo::where('user_id', Auth::user()->id)->exists()) {

            $billInfo = BillingInfo::where('user_id', Auth::user()->id)->latest('updated_at')->first();

            $isPreviousData = false;

            if($billInfo->first_name == $request->firstName) {

                if($billInfo->last_name == $request->lastName) {

                    if($billInfo->address == $request->address) {

                        if($billInfo->apartment_suite_unit == $request->apartmentSuiteUnit) {

                            if($billInfo->city_id == $request->city) {

                                if($billInfo->zip_code == $request->zipCode) {

                                    $isPreviousData = true;
                                }
                            }
                        }
                    }
                }   
            }

            if(!($isPreviousData)) {

                $billInfo = new BillingInfo();

                $billInfo->user_id = Auth::user()->id;
                $billInfo->first_name = $request->firstName;
                $billInfo->last_name = $request->lastName;
                $billInfo->address = $request->address;
                $billInfo->apartment_suite_unit = $request->apartmentSuiteUnit;
                $billInfo->city_id = $request->city;
                $billInfo->zip_code = $request->zipCode;

                $billInfo->save();
            }
        }
        else {

            $billInfo = new BillingInfo();

            $billInfo->user_id = Auth::user()->id;
            $billInfo->first_name = $request->firstName;
            $billInfo->last_name = $request->lastName;
            $billInfo->address = $request->address;
            $billInfo->apartment_suite_unit = $request->apartmentSuiteUnit;
            $billInfo->city_id = $request->city;
            $billInfo->zip_code = $request->zipCode;

            $billInfo->save();
        }

        
        $mealData = Meal::where('id', $request->mealIDInput)->first();
    
        Session::put('globalMealID', $request->mealIDInput);
        Session::put('globalMealDeliveryTime', $mealData->delivery_date.' '.$request->deliveryTimeInput.':00');
        Session::put('globalMealQuantity', $request->totalQuantityInput);
        Session::put('globalMealPrice', ((double)$mealData->price * (int)$request->totalQuantityInput));
        Session::put('globalMealDeliveryPrice', ((int)$request->totalQuantityInput * getDeliveryChargesAmount()));
        Session::put('globalMealTotalNetPrice', (Session::get('globalMealPrice') + Session::get('globalMealDeliveryPrice')));

        //Payment Code
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        //Meal Item
        $item_1 = new Item();

        $item_1->setName($request->mealNameInput.' (Based on No. of Portions)')
            ->setCurrency('EUR')
            ->setQuantity($request->totalQuantityInput)
            ->setPrice((Session::get('globalMealPrice')/$request->totalQuantityInput));

        $item_list = new ItemList();
        $item_list->addItem($item_1);

        //Delivery Charges Item
        $item_2 = new Item();

        $item_2->setName('Delivery Charges (Based on No. of Portions)')
            ->setCurrency('EUR')
            ->setQuantity($request->totalQuantityInput)
            ->setPrice((Session::get('globalMealDeliveryPrice')/$request->totalQuantityInput));

        $item_list->addItem($item_2);

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal(Session::get('globalMealTotalNetPrice'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('customer/payment/status')) // Specify return URL
            ->setCancelUrl(URL::to('customer/payment/status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {

            $payment->create($this->_api_context);
        } 
        catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                return redirect()->to('/')->with('error', 'Connection timeout!');

            } 
            else {

                return redirect()->to('/')->with('error', 'Some error occurred, sorry for inconvenience!');
            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        return redirect()->to('/')->with('error', 'Unknown error occurred!');
    }

    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {

            return redirect()->to('/')->with('error', 'Payment failed!');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);   

        $finalResult = $result;

        if ($result->getState() == 'approved') {

            //Payment Record Insertion
            $paymentModel = new PaymentModel();

            $paymentModel->payment_pay_id = $finalResult->id;
            $paymentModel->payment_transaction_id = $finalResult->transactions[0]->related_resources[0]->sale->id;
            $paymentModel->payment_method = $finalResult->payer->payment_method;
            $paymentModel->payment_status = 'Approved';
            $paymentModel->payer_id = $finalResult->payer->payer_info->payer_id;
            $paymentModel->payer_email = $finalResult->payer->payer_info->email;
            $paymentModel->payer_first_name = $finalResult->payer->payer_info->first_name;
            $paymentModel->payer_last_name = $finalResult->payer->payer_info->last_name;
            $paymentModel->payee_merchant_id = $finalResult->transactions[0]->payee->merchant_id;
            $paymentModel->total_amount = $finalResult->transactions[0]->amount->total;
            $paymentModel->currency = $finalResult->transactions[0]->amount->currency;
            $paymentModel->payment_data = $result;

            $paymentModel->save();

            $billingInfoID = BillingInfo::where('user_id', Auth::user()->id)->exists() ? BillingInfo::where('user_id', Auth::user()->id)->latest('updated_at')->first()->id : null;

            if(isset($billingInfoID)) {

                $mealData = Meal::where('id', Session::get('globalMealID'))->first();
                $userID = $mealData->user_id;
                
                // Order Record Insertion
                $order = new Order();

                $order->user_id = Auth::user()->id;
                $order->consumer_billing_info_id = $billingInfoID;
                $order->payment_id = $paymentModel->id;
                $order->meal_id = Session::get('globalMealID');
                $order->quantity = Session::get('globalMealQuantity');
                $order->meal_price = (Session::get('globalMealPrice')/Session::get('globalMealQuantity'));
                $order->delivery_cost = (Session::get('globalMealDeliveryPrice')/Session::get('globalMealQuantity'));
                $order->net_total_amount = Session::get('globalMealTotalNetPrice');
                $order->currency_id = $mealData->currency_id;
                $order->status = 'Approved';
                $order->delivery_time = Session::get('globalMealDeliveryTime');

                $order->save();

                //Meal Reserved Portions Update
                $mealPortionUpdate = Meal::findOrFail(Session::get('globalMealID'));

                $mealPortionUpdate->reserved_portions = $mealPortionUpdate->reserved_portions + Session::get('globalMealQuantity');

                $mealPortionUpdate->save();

                //Review Based Earning
                $reviewBasedPrice = ReviewBasedCharge::with('currency')->where('rating_number', getCookAverageRating($userID))->first();

                $reviewPrice = 0;
                
                if($reviewBasedPrice) {

                    $reviewPrice = $reviewBasedPrice->price;
                }
 
                //Cook Earning
                $cookEarning = new CookEarning();

                $cookEarning->user_id = $userID;
                $cookEarning->order_id = $order->id;
                $cookEarning->meal_amount = Session::get('globalMealPrice');
                $cookEarning->rating_based_amount = $reviewPrice;
                $cookEarning->currency_id = $mealData->currency_id;

                $cookEarning->save();

                $userData = User::findOrFail($userID);

                $userData->remaining_amount = $userData->remaining_amount + (double)Session::get('globalMealPrice') + (double)$reviewPrice;
                $userData->currency_id = $mealData->currency_id;
                
                $userData->save();

                Session::forget(['globalMealID', 'globalMealQuantity', 'globalMealPrice', 'globalMealReviewPrice', 'globalMealDeliveryPrice', 'globalMealTotalNetPrice', 'globalMealDeliveryTime']);

                //Send Confirmation Email to Customer
                sendOrderConfirmationEmail(Auth::user()->email, $order->id);
            }

            return redirect()->to('/')->with('success', 'Order placed successfully!');
        }

        return redirect()->to('/')->with('error', 'Payment failed!');
    }
}
