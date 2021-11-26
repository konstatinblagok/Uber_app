@extends('layouts.app')
@section('content')

<style>

    .error {

        color: red;
    }

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.cook.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>@lang('lang.Billing Information')</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                          <form id="billingInfoForm" action="{{ route('cook.billing.info.save') }}" method="post">
                              @csrf
                            <div class="col-md-12">
                              <div class="row">
                                <div class="form-group col-md-6">
                                  <label for="firstName" class="col-4 col-form-label">@lang('lang.First Name') <small class="text-danger">*</small></label> 
                                  <input id="firstName" name="firstName" placeholder="@lang('lang.First Name')" class="form-control" type="text" value="{{ isset($billingInfo->first_name) ? $billingInfo->first_name : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="lastName" class="col-4 col-form-label">@lang('lang.Last Name') <small class="text-danger">*</small></label> 
                                  <input id="lastName" name="lastName" placeholder="@lang('lang.Last Name')" class="form-control" value="{{ isset($billingInfo->last_name) ? $billingInfo->last_name : '' }}" type="text">
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="address" class="col-4 col-form-label">@lang('lang.Address') <small class="text-danger">*</small></label> 
                                  <input id="address" name="address" placeholder="@lang('lang.Street Address'), @lang('lang.P.O box')" class="form-control" type="text" value="{{ isset($billingInfo->address) ? $billingInfo->address : '' }}">
                                  <input id="apartmentSuiteUnit" name="apartmentSuiteUnit" placeholder="@lang('lang.Apartment'), @lang('lang.Suite'), @lang('lang.Unit (Optional)')" class="form-control" type="text" value="{{ isset($billingInfo->apartment_suite_unit) ? $billingInfo->apartment_suite_unit : '' }}">
                                </div>
                                <input type="hidden" id="getToken" value="{{ csrf_token() }}">
                                <div class="form-group col-md-6">
                                  <label for="country" class="col-4 col-form-label">@lang('lang.Country') <small class="text-danger">*</small></label> 
                                  <select name="country" id="country" class="form-control">
                                    <option value="">@lang('lang.Choose your Country')...</option>
                                    @if(count($countries) > 0)
                                      @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{ isset($billingInfo->city) && isset($billingInfo->city->state) && isset($billingInfo->city->state->country) && $billingInfo->city->state->country->id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="state" class="col-4 col-form-label">@lang('lang.State')/@lang('lang.Province') <small class="text-danger">*</small></label> 
                                  <select name="state" id="state" class="form-control">
                                    <option value="">@lang('lang.Choose your State')/@lang('lang.Province')...</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="city" class="col-4 col-form-label">@lang('lang.City') <small class="text-danger">*</small></label> 
                                  <select name="city" id="city" class="form-control">
                                    <option value="">@lang('lang.Choose your City')...</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="zipCode" class="col-4 col-form-label">@lang('lang.Zip')/@lang('lang.Postal Code')</label> 
                                  <input id="zipCode" name="zipCode" placeholder="@lang('lang.Zip')/@lang('lang.Postal Code')" class="form-control" type="text" value="{{ isset($billingInfo->zip_code) ? $billingInfo->zip_code : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="">@lang('lang.Payment Method')</label>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethodType" id="paypalMethod" value="1" @if (isset($billingInfo->payment_method_id) && $billingInfo->payment_method_id == "1") checked @endif>
                                    <label class="form-check-label" for="paypalMethod">
                                      PayPal
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethodType" value="2" id="creditCardMethod" @if (isset($billingInfo->payment_method_id) && $billingInfo->payment_method_id == "2") checked @endif>
                                    <label class="form-check-label" for="creditCardMethod">
                                      @lang('lang.Credit Card')
                                    </label>
                                  </div>
                                </div>
                                <div class="form-group col-md-12 paypalMethodDiv">
                                  <label for="paypalEmail" class="col-4 col-form-label">@lang('lang.PayPal Email') <small class="text-danger">*</small></label> 
                                  <input id="paypalEmail" name="paypalEmail" placeholder="@lang('lang.PayPal Email')" class="form-control" type="email" value="{{ isset($billingInfo->paypal_email) ? $billingInfo->paypal_email : '' }}">
                                </div>
                                <div class="form-group col-md-12 creditCardMethodDiv" style="display: none;">
                                  <label for="creditCardNumber" class="col-4 col-form-label">@lang('lang.Card Number') <small class="text-danger">*</small></label> 
                                  <input id="creditCardNumber" name="creditCardNumber" placeholder="@lang('lang.Card Number')" class="form-control" type="text" minlength="19" maxlength="19" value="{{ isset($billingInfo->card_number) ? $billingInfo->card_number : '' }}">
                                </div>
                                <div class="form-group col-md-6 creditCardMethodDiv" style="display: none;">
                                  <label for="creditCardExpiryDate" class="col-4 col-form-label">@lang('lang.Expiry Date') <small class="text-danger">*</small></label> 
                                  <div class="row">
                                      <div class="col-lg-3 ">
                                        <select name="creditCardMonth" id="creditCardMonth" class="form-control">
                                          <option value="">MM</option>
                                          <option value="01" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '01' ? 'selected' : '' }}>01</option>
                                          <option value="02" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '02' ? 'selected' : '' }}>02</option>
                                          <option value="03" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '03' ? 'selected' : '' }}>03</option>
                                          <option value="04" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '04' ? 'selected' : '' }}>04</option>
                                          <option value="05" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '05' ? 'selected' : '' }}>05</option>
                                          <option value="06" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '06' ? 'selected' : '' }}>06</option>
                                          <option value="07" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '07' ? 'selected' : '' }}>07</option>
                                          <option value="08" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '08' ? 'selected' : '' }}>08</option>
                                          <option value="09" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '09' ? 'selected' : '' }}>09</option>
                                          <option value="10" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '10' ? 'selected' : '' }}>10</option>
                                          <option value="11" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '11' ? 'selected' : '' }}>11</option>
                                          <option value="12" {{ isset($billingInfo->card_expiry_date) && substr($billingInfo->card_expiry_date, 0, 2) == '12' ? 'selected' : '' }}>12</option>
                                        </select>
                                      </div>
                                      <div class="col-lg-1">
                                        <label for="">/</label>
                                      </div>
                                      <div class="col-lg-3">
                                        <input id="creditCardYear" name="creditCardYear" placeholder="YY" class="form-control" type="number" autocomplete="off" minlength="2" min="21" max="40" maxlength="2" value="{{ isset($billingInfo->card_expiry_date) ? substr($billingInfo->card_expiry_date, -2) : '' }}">
                                      </div>
                                  </div>
                                </div>
                                <div class="form-group col-md-6 creditCardMethodDiv" style="display: none;">
                                  <label for="creditCardCVV" class="col-4 col-form-label">CVV<small class="text-danger">*</small></label> 
                                  <input id="creditCardCVV" name="creditCardCVV" placeholder="CVV" class="form-control" type="number" autocomplete="off" minlength="3" maxlength="4" value="{{ isset($billingInfo->card_cvv) ? $billingInfo->card_cvv : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                  <button type="submit" class="btn btn-chezdon form-control">Update</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('includes.site.jsRoutes')

@endsection

@push('scripts')

    <script>

        var requestStateID = {!! isset($billingInfo->city) && isset($billingInfo->city->state) ? $billingInfo->city->state->id : 0 !!};
        var requestCityID = {!! isset($billingInfo->city) ? $billingInfo->city_id : 0 !!};

    </script>
  
    <script src="{{ asset('public/site-asset/js/validation/getCity.js') }}"></script>

@endpush

@push('scripts')
  
    <script>

        $('#creditCardNumber').on('keypress change', function () {

            $(this).val(function (index, value) {

                if(value.length <= 16) {

                    return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
                }
                else {

                  return value;
                }
            });
        });

    </script>

@endpush

@push('scripts')

    <script>

        $(document).ready(function() {

            var checkedValue = $('input[name="paymentMethodType"]:checked').val();

            if (checkedValue == '1') {

                $('.paypalMethodDiv').show();
                $('.creditCardMethodDiv').hide();
            }
            else if (checkedValue == '2') {

                $('.paypalMethodDiv').hide();
                $('.creditCardMethodDiv').show();
            }

            $('input[type=radio][name=paymentMethodType]').change(function() {
                
                if ($(this).val() == '1') {

                    $('.paypalMethodDiv').show();
                    $('.creditCardMethodDiv').hide();
                }
                else if ($(this).val() == '2') {

                    $('.paypalMethodDiv').hide();
                    $('.creditCardMethodDiv').show();
                }
            });
        });

    </script>

@endpush

@push('scripts')
  
<script>

    $(document).ready(function () {

        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        //Form Validation
        $('#billingInfoForm').validate({

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
                paymentMethodType: {

                    required: true,
                },
                paypalEmail: {

                    required: "#paypalMethod:checked",
                    email: true,
                },
                creditCardNumber: {

                    required: "#creditCardMethod:checked",
                    minlength: 19,
                    maxlength: 19,
                },
                creditCardMonth: {

                    required: "#creditCardMethod:checked"
                },
                creditCardYear: {

                    required: "#creditCardMethod:checked"
                },
                creditCardCVV: {

                    required: "#creditCardMethod:checked",
                    minlength: 3,
                    maxlength: 4,
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
                paymentMethodType: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le mode de paiement est requis';
                        }
                        else {

                            return 'Payment method is required';
                        }   
                    }
                },
                paypalEmail: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'e-mail PayPal est requis';
                        }
                        else {

                            return 'PayPal email is required';
                        }   
                    },
                    email: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'e-mail PayPal doit être une adresse e-mail valide';
                        }
                        else {

                            return 'PayPal email should be a valid email address';
                        }   
                    }
                },
                creditCardNumber: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de carte de crédit est requis';
                        }
                        else {

                            return 'Credit Card number is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de carte de crédit doit être égal à 16 chiffres';
                        }
                        else {

                            return 'Credit Card number must be equal to 16 digits';
                        }   
                    },
                    maxlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de carte de crédit doit être égal à 16 chiffres';
                        }
                        else {

                            return 'Credit Card number must be equal to 16 digits';
                        }   
                    }
                },
                creditCardMonth: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le mois d\'expiration de la carte de crédit est requis';
                        }
                        else {

                            return 'Credit Card expiry month is required';
                        }   
                    }
                },
                creditCardYear: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'année d\'expiration de la carte de crédit est requise';
                        }
                        else {

                            return 'Credit Card expiry year is required';
                        }   
                    }
                },
                creditCardCVV: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Carte de crédit CVV est requis';
                        }
                        else {

                            return 'Credit Card CVV is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le CVV de la carte de crédit doit être supérieur ou égal à 3 caractères';
                        }
                        else {

                            return 'Credit Card CVV must be greater than or equal to 3 characters';
                        }   
                    },
                    maxlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le CVV de la carte de crédit doit être inférieur ou égal à 4 caractères';
                        }
                        else {

                            return 'Credit Card CVV must be less than or equal to 4 characters';
                        }   
                    }
                }
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
    });

</script>

@endpush