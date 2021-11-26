@extends('layouts.app')
@section('content')

<style>

    .menusection h3, {

        text-align: left;
        margin: 10px 0px;
        color: #936f3b;
    }

    .menusection h5 {

        text-align: left;
        margin: 10px 0px;
        font-family: futura, sans-serif;
    }

    a {
        text-decoration: none !important;
        color: inherit
    }

    a:hover {
        color: #455A64
    }

    .card {
        border-radius: 5px;
        background-color: #fff;
        padding-left: 30px;
        padding-right: 30px;
        padding-top: 15px;
        padding-bottom: 15px
    }

    .rating-box {
        width: 130px;
        height: 130px;
        margin-right: auto;
        margin-left: auto;
        background-color: #FBC02D;
        color: #fff
    }

    .rating-label {
        font-weight: bold
    }

    .rating-bar {
        width: 300px;
        padding: 8px;
        border-radius: 5px
    }

    .bar-container {
        width: 100%;
        background-color: #f1f1f1;
        text-align: center;
        color: white;
        border-radius: 20px;
        cursor: pointer;
        margin-bottom: 5px
    }

    .bar-5 {
        width: 70%;
        height: 13px;
        background-color: #FBC02D;
        border-radius: 20px
    }

    .bar-4 {
        width: 30%;
        height: 13px;
        background-color: #FBC02D;
        border-radius: 20px
    }

    .bar-3 {
        width: 20%;
        height: 13px;
        background-color: #FBC02D;
        border-radius: 20px
    }

    .bar-2 {
        width: 10%;
        height: 13px;
        background-color: #FBC02D;
        border-radius: 20px
    }

    .bar-1 {
        width: 0%;
        height: 13px;
        background-color: #FBC02D;
        border-radius: 20px
    }

    td {
        padding-bottom: 10px
    }

    .star-active {
        color: #FBC02D;
        margin-top: 10px;
        margin-bottom: 10px
    }

    .star-active:hover {
        color: #F9A825;
        cursor: pointer
    }

    .star-inactive {
        color: #CFD8DC;
        margin-top: 10px;
        margin-bottom: 10px
    }

    .blue-text {
        color: #0091EA
    }

    .content {
        font-size: 18px
    }

    .profile-pic {
        width: 90px;
        height: 90px;
        border-radius: 100%;
        margin-right: 30px
    }

    .pic {
        width: 80px;
        height: 80px;
        margin-right: 10px
    }

    .vote {
        cursor: pointer
    }

    .error {

        color: red;
    }

</style>

<main>
    <div class="section" id="menu">
        <div id="menuword">
            <p>{{ $mealDetails->title }}</p>
        </div>
    </div>
    <div class="menusection">

        <div class="container-fluid mt-5 mb-5">

            <div class="row">

                <div class="col-md-5">

                    @if(count($mealDetails->mealMedia) > 0)

                        <ul class="bo-slider">

                            @foreach($mealDetails->mealMedia as $media)

                                @if($media->cookFoodMedia != null)

                                    <li data-url="{{ asset($media->cookFoodMedia->path.'/'.$media->cookFoodMedia->name) }}" data-type="{{ $media->cookFoodMedia->type }}"></li>

                                @endif

                            @endforeach

                        </ul>

                    @else

                        <h3>@lang('lang.No Media Found!')</h3>

                    @endif

                </div>

                <div class="col-md-7 ml-2">

                    <h5>{{$mealDetails->foodType->name}}</h5>

                    <h3>{{$mealDetails->title}}</h3>

                    <p>@lang('lang.Meal Price') : {{$mealDetails->currency->symbol}} {{$mealDetails->price}} / @lang('lang.Portion')</p>
                    <p title="(Packaging + delivery + responsibility of the hygiene standard for the cooks)">@lang('lang.Service Charges') : {{  getDeliveryChargesCurrency()  }} {{  getDeliveryChargesAmount()  }} / @lang('lang.Portion')</p>
                    <p>@lang('lang.Available Portions') : {{ getMealAvailablePortion($mealDetails->id) }}</p>

                    <div class="row">

                        @if(Auth::check())

                            @if(Auth::user()->id != $mealDetails->user_id)

                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-4 form-group">

                                            <input type="text" class="form-control timepicker" name="timePicker" id="timePicker" placeholder="@lang('lang.Select Delivery Time')">
            
                                        </div>
                                        
                                        <div class="col-md-2 form-group">

                                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" max="{{ getMealAvailablePortion($mealDetails->id) }}" value="1">
            
                                        </div>
            
                                        <div class="col-md-3 form-group">
            
                                            <button type="submit" class="btn btn-chezdon form-control checkoutModalBtn">@lang('lang.Checkout')</button>
            
                                        </div>

                                    </div>

                                </div>

                                <!-- Checkout Modal -->
                                <div class="modal" id="checkOutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">@lang('lang.Checkout Details')</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="checkOutForm" action="{{ route('customer.payment.paypal.pay') }}" method="post">

                                            <div class="modal-body">

                                                @csrf

                                                <div class="container">

                                                    <div class="row">

                                                        <input type="hidden" id="mealNameInput" name="mealNameInput">
                                                        <input type="hidden" id="mealIDInput" name="mealIDInput">
                                                        <input type="hidden" id="mealDeliveryTimeStampInput" name="mealDeliveryTimeStampInput">

                                                        <div class="col-md-12">

                                                            <p>@lang('lang.Quantity') : <span id="totalQuantity"></span></p>
                                                            <input type="hidden" id="totalQuantityInput" name="totalQuantityInput">

                                                        </div>

                                                        <div class="col-md-6">

                                                            <p>@lang('lang.Total Meal Amount') : <span id="totalMealPrice"></span></p>
                                                            <input type="hidden" id="totalMealPriceInput" name="totalMealPriceInput">

                                                        </div>

                                                        <div class="col-md-6">

                                                            <p title="(Packaging + delivery + responsibility of the hygiene standard for the cooks)">@lang('lang.Total Service Charges') : <span id="totalDeliveryPrice"></span></p>
                                                            <input type="hidden" id="totalDeliveryPriceInput" name="totalDeliveryPriceInput">

                                                        </div>

                                                        <div class="col-md-6">

                                                            <p>@lang('lang.Net Total') : <span id="netTotalPrice"></span></p>
                                                            <input type="hidden" id="netTotalPriceInput" name="netTotalPriceInput">

                                                        </div>

                                                        <div class="col-md-6">

                                                            <p>@lang('lang.Delivery Date Time') : <span>{{date('d-m-Y', strtotime($mealDetails->delivery_date))}}</span><span id="deliveryTime"></span></p>
                                                            <input type="hidden" id="deliveryTimeInput" name="deliveryTimeInput">

                                                        </div>

                                                        <div class="col-md-12">

                                                            <hr>

                                                        </div>

                                                    </div>

                                                </div>

                                                @if(Auth::user()->isCustomer())

                                                    <div class="container">

                                                        <div class="row">

                                                            <div class="form-group col-md-12">
                                                                <h3>@lang('lang.Billing Information')</h3>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="firstName" class="col-12 col-form-label">@lang('lang.First Name') <small class="text-danger">*</small></label> 
                                                                <input id="firstName" name="firstName" placeholder="@lang('lang.First Name')" class="form-control" type="text" value="{{ isset($billingInfo->first_name) ? $billingInfo->first_name : '' }}">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="lastName" class="col-12 col-form-label">@lang('lang.Last Name') <small class="text-danger">*</small></label> 
                                                                <input id="lastName" name="lastName" placeholder="@lang('lang.Last Name')" class="form-control" value="{{ isset($billingInfo->last_name) ? $billingInfo->last_name : '' }}">
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="address" class="col-12 col-form-label">@lang('lang.Address') <small class="text-danger">*</small></label> 
                                                                <input id="address" name="address" placeholder="@lang('lang.Street Address'), @lang('lang.P.O box')" class="form-control" type="text" value="{{ isset($billingInfo->address) ? $billingInfo->address : '' }}">
                                                                <input id="apartmentSuiteUnit" name="apartmentSuiteUnit" placeholder="@lang('lang.Apartment'), @lang('lang.Suite'), @lang('lang.Unit (Optional)')" class="form-control" type="text" value="{{ isset($billingInfo->apartment_suite_unit) ? $billingInfo->apartment_suite_unit : '' }}">
                                                            </div>

                                                            <input type="hidden" id="getToken" value="{{ csrf_token() }}">
                                                            
                                                            <div class="form-group col-md-4">
                                                                <label for="country" class="col-12 col-form-label">@lang('lang.Country') <small class="text-danger">*</small></label> 
                                                                <select name="country" id="country" class="form-control">
                                                                <option value="">@lang('lang.Choose your Country')...</option>
                                                                @if(count($countries) > 0)
                                                                    @foreach ($countries as $country)
                                                                    <option value="{{$country->id}}" {{ isset($billingInfo->city) && isset($billingInfo->city->state) && isset($billingInfo->city->state->country) && $billingInfo->city->state->country->id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-8">
                                                                <label for="state" class="col-12 col-form-label">@lang('lang.State')/@lang('lang.Province') <small class="text-danger">*</small></label> 
                                                                <select name="state" id="state" class="form-control">
                                                                <option value="">@lang('lang.Choose your State')/@lang('lang.Province')...</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label for="city" class="col-12 col-form-label">@lang('lang.City') <small class="text-danger">*</small></label> 
                                                                <select name="city" id="city" class="form-control">
                                                                <option value="">@lang('lang.Choose your City')...</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-8">
                                                                <label for="zipCode" class="col-12 col-form-label">@lang('lang.Zip')/@lang('lang.Postal Code')</label> 
                                                                <input id="zipCode" name="zipCode" placeholder="@lang('lang.Zip')/@lang('lang.Postal Code')" class="form-control" type="text" value="{{ isset($billingInfo->zip_code) ? $billingInfo->zip_code : '' }}">
                                                            </div>

                                                        </div>

                                                    </div>

                                                @endif
                                            
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('lang.Cancel')</button>
                                            <button type="submit" class="btn btn-chezdon">@lang('lang.Continue to Checkout')</button>
                                            </div>

                                        </form>

                                    </div>
                                    </div>
                                </div>

                            @endif

                        @else

                            <div class="col-md-6 form-group">

                                <a href="{{ route('login') }}" class="btn btn-chezdon form-control">@lang('lang.Sign in to Order')</a>

                            </div>

                        @endif

                    </div>

                    <p class="mt-4">@lang('lang.Cook') : {{$mealDetails->user->name}}</p>

                    <p class="mt-4">@lang('lang.Cook Rating') : {{ number_format((float)$userReview, 2, '.', '')  }} ({{ $userReviewCount }})</p>
                    
                    <p class="mt-4">@lang('lang.Delivery Date') : {{date('d-m-Y', strtotime($mealDetails->delivery_date))}}</p>

                </div>

            </div>

        </div>

        <div class="container-fluid mt-5 mb-5">

            <div class="row">

                <div class="col-md-10">

                    <h3>@lang('lang.Description')</h3>

                </div>

                <div class="col-md-10">

                    <p>{{$mealDetails->description}}</p>

                </div>

            </div>

        </div>

        <div class="container-fluid mt-5 mb-5">

            <div class="row">

                <div class="col-md-10">

                    <h3>@lang('lang.Reviews')</h3>

                </div>

                <div class="col-md-10">

                    @if (count($cookReviews) > 0)
                        @foreach ($cookReviews as $review)
                            
                            <div class="card mt-3">
                                <div class="row d-flex">
                                    <div class="d-flex flex-column">
                                        <h3 class="mt-1 mb-0">{{ $review->user->name }}</h3>
                                        <div>
                                            <p class="text-left">
                                                <span class="text-muted">({{ $review->rating }})</span>
                                                
                                                @php
                                                    $inActiveStar = 5 - (int)$review->rating;
                                                @endphp
                                                
                                                @for ($i = 1; $i <= $review->rating; $i++)
                                                    <span class="fa fa-star star-active"></span>
                                                @endfor

                                                @for ($i = 0; $i < $inActiveStar; $i++)
                                                    <span class="fa fa-star star-inactive"></span>
                                                @endfor
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <p class="text-muted">{{ date('d-m-Y', strtotime($review->created_at)) }}</p>
                                    </div>
                                </div>
                                <div class="row text-left">
                                    <p class="content">{{ $review->comments }}</p>
                                </div>
                            </div>

                        @endforeach

                    @else    
                        <h3>@lang('lang.No Reviews Found!')</h3>
                    @endif

                </div>

            </div>

        </div>

    </div>
</main>

@include('includes.site.jsRoutes')

@endsection

@push('scripts')
    
    <script>

        var startTime = '{!! getDeliveryStartTime() !!}';
        var endTime = '{!! getDeliveryEndTime() !!}';

        $(document).ready(function(){
            $('input.timepicker').timepicker({
                timeFormat: 'HH:mm',
                minTime: startTime,
                maxTime: endTime,
                interval: 5 // 15 minutes
            });
        });

    </script>

@endpush

@push('scripts')

    <script>

        var requestStateID = {!! isset($billingInfo->city) && isset($billingInfo->city->state) ? $billingInfo->city->state->id : 0 !!};
        var requestCityID = {!! isset($billingInfo->city) ? $billingInfo->city_id : 0 !!};

    </script>

    <script src="{{ asset('public/site-asset/js/validation/getCity.js') }}"></script>
    
@endpush

@push('scripts')
    
    <script>

        $(function(){
            $('.bo-slider').boSlider();
        });


    </script>

@endpush

@push('scripts')
    
    <script>

        $(document).ready(function() {

            // Select your input element.
            var number = document.getElementById('quantity');

            // Listen for input event on numInput.
            number.onkeydown = function(e) {
                if(!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58) 
                || e.keyCode == 8)) {
                    return false;
                }
            }

            var mealID = {!! $mealDetails->id !!};
            var mealAvailablePortion = {!! getMealAvailablePortion($mealDetails->id) !!}
            var mealName = '{!! $mealDetails->title !!}';
            var mealType = '{!! $mealDetails->foodType->name !!}';
            var mealDeliveryTimeStamp = '{!! $mealDetails->delivery_timestamp !!}';
            var mealPortionPrice = {!! $mealDetails->price !!};
            var deliveryPortionPrice = {!! getDeliveryChargesAmount() !!};
            var mealPriceCurrency = '{!! $mealDetails->currency->symbol !!}';
            var deliveryPriceCurrency = '{!! getDeliveryChargesCurrency()!!}';

            $('.checkoutModalBtn').click(function(e) {

                if($.trim($('#timePicker').val()) != '') {

                    e.preventDefault();

                    var quantity = $('#quantity').val();
                    quantity = parseInt(quantity) || 1;
                    quantity = Math.abs(quantity);

                    if(quantity > mealAvailablePortion) {

                        quantity = mealAvailablePortion;
                    }

                    var totalMealPrice = quantity * mealPortionPrice;
                    var totalDeliveryPrice = quantity * deliveryPortionPrice;

                    if(mealType.toLowerCase() == 'dessert' || mealType.toLowerCase() == 'desert') {

                        if(totalMealPrice >= 12 && quantity > 1) {

                            var totalFreeDeliveryQuantityTemp = Math.floor(totalMealPrice / 12);

                            if(totalFreeDeliveryQuantityTemp >= quantity) {

                                totalFreeDeliveryQuantityTemp = totalFreeDeliveryQuantityTemp - 1;
                            }

                            var deductedPrice = totalFreeDeliveryQuantityTemp * deliveryPortionPrice;

                            totalDeliveryPrice = (totalDeliveryPrice - deductedPrice) > deliveryPortionPrice ? totalDeliveryPrice - deductedPrice : deliveryPortionPrice;
                        }
                    }

                    var netTotalPrice = totalMealPrice + totalDeliveryPrice;
                    
                    $('#totalMealPrice').html(mealPriceCurrency +' '+ totalMealPrice);
                    $('#totalMealPriceInput').val(totalMealPrice);
                    $('#totalDeliveryPrice').html(deliveryPriceCurrency +' '+ totalDeliveryPrice);
                    $('#totalDeliveryPriceInput').val(totalDeliveryPrice);
                    $('#netTotalPrice').html(mealPriceCurrency +' '+ netTotalPrice);
                    $('#netTotalPriceInput').val(netTotalPrice);
                    $('#deliveryTime').html($.trim($('#timePicker').val()));
                    $('#deliveryTimeInput').val($.trim($('#timePicker').val()));
                    $('#totalQuantity').html(quantity);
                    $('#totalQuantityInput').val(quantity);
                    $('#mealNameInput').val(mealName);
                    $('#mealIDInput').val(mealID);
                    $('#mealDeliveryTimeStampInput').val(mealDeliveryTimeStamp);

                    $('#checkOutModal').modal('show');
                }
                else {

                    if(CurrentLanguage == 'fr') {

                        alert('Veuillez sélectionner le délai de livraison !');
                    }
                    else {

                        alert('Please select delivery time!');
                    }
                }
            });
        });

    </script>

@endpush

@push('scripts')
  
<script>

    $(document).ready(function () {

        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        @if(Auth::check() && Auth::user()->isCustomer())

        //Form Validation
        $('#checkOutForm').validate({

            rules: {

                firstName: {

                    required: true,
                    minlength: 3
                },
                lastName: {

                    required: true,
                    minlength: 3
                },
                address:{
                  
                    required: true,
                    minlength: 5
                },
                country: {

                    required: true,
                },
                state: {

                    required: true,
                },
                city: {

                    required: true,
                },
            },
            messages: {

                firstName: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le prénom est requis';
                        }
                        else {

                            return 'First Name is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le prénom doit être supérieur ou égal à 3 caractères';
                        }
                        else {

                            return 'First Name must be greater than or equal to 3 characters';
                        }   
                    }
                },
                lastName: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom de famille est requis';
                        }
                        else {

                            return 'Last Name is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom de famille doit être supérieur ou égal à 3 caractères';
                        }
                        else {

                            return 'Last Name must be greater than or equal to 3 characters';
                        }   
                    }
                },
                address: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'adresse est requise';
                        }
                        else {

                            return 'Address is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'adresse doit être supérieure ou égale à 5 caractères';
                        }
                        else {

                            return 'Address must be greater than or equal to 5 characters';
                        }   
                    }
                },
                country: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le pays est requis';
                        }
                        else {

                            return 'Country is required';
                        }   
                    },
                },
                state: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'état est requis';
                        }
                        else {

                            return 'State is required';
                        }   
                    },
                },
                city: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La ville est obligatoire';
                        }
                        else {

                            return 'City is required';
                        }   
                    },
                },          
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
        @elseif(Auth::check() && Auth::user()->isCook())

            $('#checkOutForm').validate({

                submitHandler: function (form) { 

                    form.submit();
                }
            });

        @endif
    });

</script>

@endpush
