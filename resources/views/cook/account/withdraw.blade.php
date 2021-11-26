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
                            <div class="col-md-6">
                                <h3>@lang('lang.Withdraw Amount')</h3>
                                <hr>
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3 form-group">
                                <a href="{{ route('cook.account.index') }}" type="button" class="btn btn-chezdon form-control">@lang('lang.Back to list')</a>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <div class="form-group row">
                                        <div class="card">
                                            <div class="card-body">
                                              <p>@lang('lang.Total Remaining Balance') : {{ getDeliveryChargesCurrency() }}{{ Auth::user()->remaining_amount }}</p>
                                              <p>@lang('lang.Minimum Balance Withdrawal') :  {{ getDeliveryChargesCurrency() }}{{ getMinimumWithdrawalAmount() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mt-2">

                            <form id="balanceWithdrawForm" action="{{ route('cook.account.withdraw') }}" method="POST">

                                @csrf

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label for="amount" class="col-4 col-form-label">@lang('lang.Withdraw Amount') <small class="text-danger">*</small></label> 
                                            <input id="amount" name="amount" placeholder="@lang('lang.Amount')" class="form-control" required="required" type="number" min="{{ getMinimumWithdrawalAmount() }}">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="currency" class="col-4 col-form-label">@lang('lang.Currency') <small class="text-danger">*</small></label> 
                                            <select name="currency" id="currency" class="form-control" required="required">
                                                @if(count($currencies) > 0)
                                                    @foreach ($currencies as $currency)

                                                        <option value="{{ $currency->id }}">{{ $currency->name }}({{ $currency->symbol }})</option>

                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <button type="submit" class="btn btn-chezdon form-control">@lang('lang.Withdraw')</button>
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

@endsection

@push('scripts')

    <script>

        $(document).ready(function() {

            var number = document.getElementById('amount');

            number.onkeydown = function(e) {
                if(!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58) 
                || e.keyCode == 8)) {
                    return false;
                }
            }
        });

    </script>

@endpush

@push('scripts')
  
<script>

    $(document).ready(function () {

        var minimumWithdrawAmountLimit = {!! getMinimumWithdrawalAmount() !!};
        var maximumWithdrawAmountLimit = {!! Auth::user()->remaining_amount !!};
        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        //Form Validation
        $('#balanceWithdrawForm').validate({

            rules: {

                amount: {

                    required: true,
                    min: minimumWithdrawAmountLimit,
                    max: maximumWithdrawAmountLimit,
                },
                currency: {

                    required: true,
                },
            },
            messages: {

                amount: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le montant du retrait est requis';
                        }
                        else {

                            return 'Withdraw amount is required';
                        }   
                    },
                    min: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom doit être supérieur ou égal à '+minimumWithdrawAmountLimit;
                        }
                        else {

                            return 'Withdraw amount must be greater than or equal to '+minimumWithdrawAmountLimit;
                        }   
                    },
                    max: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom doit être supérieur ou égal à '+maximumWithdrawAmountLimit;
                        }
                        else {

                            return 'Withdraw amount must be greater than or equal to '+maximumWithdrawAmountLimit;
                        }   
                    }
                },
                currency: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La devise est requise';
                        }
                        else {

                            return 'Currency is required';
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