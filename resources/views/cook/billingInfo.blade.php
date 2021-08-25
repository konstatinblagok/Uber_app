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
                                <h3>Billing Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                          <form id="billingInfoForm" action="{{ route('cook.billing.info.save') }}" method="post">
                              @csrf
                            <div class="col-md-12">
                              <div class="row">
                                <div class="form-group col-md-6">
                                  <label for="firstName" class="col-4 col-form-label">First Name <small class="text-danger">*</small></label> 
                                  <input id="firstName" name="firstName" placeholder="First Name" class="form-control" type="text" value="{{ isset($billingInfo->first_name) ? $billingInfo->first_name : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="lastName" class="col-4 col-form-label">Last Name <small class="text-danger">*</small></label> 
                                  <input id="lastName" name="lastName" placeholder="Last Name" class="form-control" value="{{ isset($billingInfo->last_name) ? $billingInfo->last_name : '' }}" type="text">
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="address" class="col-4 col-form-label">Address <small class="text-danger">*</small></label> 
                                  <input id="address" name="address" placeholder="Street Address, P.O box" class="form-control" type="text" value="{{ isset($billingInfo->address) ? $billingInfo->address : '' }}">
                                  <input id="apartmentSuiteUnit" name="apartmentSuiteUnit" placeholder="Apartment, Suite, Unit (Optional)" class="form-control" type="text" value="{{ isset($billingInfo->apartment_suite_unit) ? $billingInfo->apartment_suite_unit : '' }}">
                                </div>
                                <input type="hidden" id="getToken" value="{{ csrf_token() }}">
                                <div class="form-group col-md-6">
                                  <label for="country" class="col-4 col-form-label">Country <small class="text-danger">*</small></label> 
                                  <select name="country" id="country" class="form-control">
                                    <option value="">Choose your Country...</option>
                                    @if(count($countries) > 0)
                                      @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{ isset($billingInfo->city) && isset($billingInfo->city->state) && isset($billingInfo->city->state->country) && $billingInfo->city->state->country->id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="state" class="col-4 col-form-label">State/Province <small class="text-danger">*</small></label> 
                                  <select name="state" id="state" class="form-control">
                                    <option value="">Choose your State/Province...</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="city" class="col-4 col-form-label">City <small class="text-danger">*</small></label> 
                                  <select name="city" id="city" class="form-control">
                                    <option value="">Choose your City...</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="zipCode" class="col-4 col-form-label">Zip/Postal Code</label> 
                                  <input id="zipCode" name="zipCode" placeholder="Zip/Postal Code" class="form-control" type="text" value="{{ isset($billingInfo->zip_code) ? $billingInfo->zip_code : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="">Payment Method</label>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethodType" id="paypalMethod" value="1" @if (isset($billingInfo->payment_method_id) && $billingInfo->payment_method_id == "1") checked @endif>
                                    <label class="form-check-label" for="paypalMethod">
                                      PayPal
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethodType" value="2" id="creditCardMethod" @if (isset($billingInfo->payment_method_id) && $billingInfo->payment_method_id == "2") checked @endif>
                                    <label class="form-check-label" for="creditCardMethod">
                                      Credit Card
                                    </label>
                                  </div>
                                </div>
                                <div class="form-group col-md-12 paypalMethodDiv">
                                  <label for="paypalEmail" class="col-4 col-form-label">Paypal Email <small class="text-danger">*</small></label> 
                                  <input id="paypalEmail" name="paypalEmail" placeholder="PayPal Email" class="form-control" type="email" value="{{ isset($billingInfo->paypal_email) ? $billingInfo->paypal_email : '' }}">
                                </div>
                                <div class="form-group col-md-12 creditCardMethodDiv" style="display: none;">
                                  <label for="creditCardNumber" class="col-4 col-form-label">Card Number <small class="text-danger">*</small></label> 
                                  <input id="creditCardNumber" name="creditCardNumber" placeholder="Card Number" class="form-control" type="text" minlength="19" maxlength="19" value="{{ isset($billingInfo->card_number) ? $billingInfo->card_number : '' }}">
                                </div>
                                <div class="form-group col-md-6 creditCardMethodDiv" style="display: none;">
                                  <label for="creditCardExpiryDate" class="col-4 col-form-label">Expiry Date <small class="text-danger">*</small></label> 
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
                                  <button type="submit" class="btn btn-chezdon form-control">Save</button>
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
          submitHandler: function (form) { 

              form.submit();
          }
      });
  });

</script>

@endpush