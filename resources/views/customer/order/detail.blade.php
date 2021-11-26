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
                            <div class="col-md-6">
                                <h3>@lang('lang.Order Details')</h3>
                                <hr>
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3 form-group">
                                <a href="{{ route('customer.order.history') }}" type="button" class="btn btn-chezdon form-control">@lang('lang.Back to list')</a>
                                <hr>
                            </div>
                        </div>
                        <div class="row">

                            {{-- Order Information --}}
                            <div class="col-md-12 form-group">
                                <h4>@lang('lang.Order Details')</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.No. of Portion') : <span>{{ $order->quantity }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Meal Price (Each Portion)') : <span>{{ $order->currency->symbol }} {{ $order->meal_price }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p title="(Packaging + delivery + responsibility of the hygiene standard for the cooks)">@lang('lang.Service Charges (Each Portion)') : <span>{{ $order->currency->symbol }} {{ $order->delivery_cost }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Total Net Amount') : <span>{{ $order->currency->symbol }} {{ $order->net_total_amount }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Order Status') : <span>{{ $order->status }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Delivery Time') : <span>{{ date('d-m-Y H:i:s', strtotime($order->delivery_time)) }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Delivered At') : <span>{{ $order->delivered_at == NULL ? '---' : $order->delivered_at }}</span></p>
                            </div>

                            <hr>

                            {{-- Payment Information --}}
                            <div class="col-md-12 form-group">
                                <h4>@lang('lang.Payment Information')</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Payment Method') : <span>{{ $order->payment->payment_method }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Transaction ID') : <span>{{ $order->payment->payment_transaction_id }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Payment Status') : <span>{{ $order->payment->payment_status }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Payer First Name') : <span>{{ $order->payment->payer_first_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Payer Last Name') : <span>{{ $order->payment->payer_last_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Payer Email') : <span>{{ $order->payment->payer_email }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Amount') : <span>{{ $order->payment->total_amount.' '.$order->payment->currency }}</span></p>
                            </div>

                            <hr>

                            {{-- Billing Information --}}
                            <div class="col-md-12 form-group">
                                <h4>@lang('lang.Billing Information')</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.First Name') : <span>{{ $order->billingInfo->first_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Last Name') : <span>{{ $order->billingInfo->last_name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Address') : <span>{{ $order->billingInfo->address }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Apartment'), @lang('lang.Suite'), @lang('lang.Unit') : <span>{{ $order->billingInfo->apartment_suite_unit == '' ? '---' : $order->billingInfo->apartment_suite_unit }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.City') : <span>{{ $order->billingInfo->city->name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Zip')/@lang('lang.Postal Code') : <span>{{ $order->billingInfo->zip_code }}</span></p>
                            </div>

                            <hr>

                            {{-- Meal & Cook Information --}}
                            <div class="col-md-12 form-group">
                                <h4>@lang('lang.Meal & Cook Information')</h4>
                                <hr>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Meal Title') : <span>{{ $order->meal->title }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Meal Category') : <span>{{ $order->meal->foodMenuCategory->name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Meal Type') : <span>{{ $order->meal->foodType->name }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Meal Price') : <span>{{ $order->meal->currency->symbol }} {{ $order->meal->price }}</span></p>
                            </div>

                            <div class="col-md-6 form-group">
                                <p>@lang('lang.Cook Name') : <span>{{ $order->user->name }}</span></p>
                            </div>

                            <div class="col-md-12 form-group">
                                <p>@lang('lang.Meal Description') : <span>{{ $order->meal->description }}</span></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection