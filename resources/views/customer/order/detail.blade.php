@extends('layouts.app')
@section('content')

<style>

    h4 {

        color: #936f3b;
        font-size: 16px;
    }

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.customer.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Order Details</h3>
                                <hr>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-2 form-group">
                                <a href="{{ route('customer.order.history') }}" type="button" class="btn btn-chezdon form-control">Back to list</a>
                            </div>
                        </div>
                        <div class="row">

                            {{-- Order Information --}}
                            <div class="col-md-12 form-group">
                                <h4>Order Details</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>No of Portions : <span>{{ $order->quantity }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Meal Price (Each Portion) : <span>{{ $order->currency->symbol }} {{ $order->meal_price }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p title="(Packaging + delivery + responsibility of the hygiene standard for the cooks)">Service Charges (Each Portion) : <span>{{ $order->currency->symbol }} {{ $order->delivery_cost }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Total Net Amount : <span>{{ $order->currency->symbol }} {{ $order->net_total_amount }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Order Status : <span>{{ $order->status }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Delivery Time : <span>{{ date('d-m-Y H:i:s', strtotime($order->delivery_time)) }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Delivered At : <span>{{ $order->delivered_at == NULL ? '---' : $order->delivered_at }}</span></p>
                            </div>

                            <hr>

                            {{-- Payment Information --}}
                            <div class="col-md-12 form-group">
                                <h4>Payment Information</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Payment Method : <span>{{ $order->payment->payment_method }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Transaction ID : <span>{{ $order->payment->payment_transaction_id }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Payment Status : <span>{{ $order->payment->payment_status }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Payer First Name : <span>{{ $order->payment->payer_first_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Payer Last Name : <span>{{ $order->payment->payer_last_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Payer Email : <span>{{ $order->payment->payer_email }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Amount : <span>{{ $order->payment->total_amount.' '.$order->payment->currency }}</span></p>
                            </div>

                            <hr>

                            {{-- Billing Information --}}
                            <div class="col-md-12 form-group">
                                <h4>Billing Information</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>First Name : <span>{{ $order->billingInfo->first_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Last Name : <span>{{ $order->billingInfo->last_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Address : <span>{{ $order->billingInfo->address }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Apartment, Suite, Unit : <span>{{ $order->billingInfo->apartment_suite_unit == '' ? '---' : $order->billingInfo->apartment_suite_unit }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>City : <span>{{ $order->billingInfo->city->name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Zip Code : <span>{{ $order->billingInfo->zip_code }}</span></p>
                            </div>

                            {{-- Meal & Cook Information --}}
                            <div class="col-md-12 form-group">
                                <h4>Meal & Cook Information</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Meal Title : <span>{{ $order->meal->title }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Meal Type : <span>{{ $order->meal->foodType->name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Meal Price : <span>{{ $order->meal->currency->symbol }} {{ $order->meal->price }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>Cook Name : <span>{{ $order->user->name }}</span></p>
                            </div>

                            <div class="col-md-12 form-group">
                                <p>Meal Description : <span>{{ $order->meal->description }}</span></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection