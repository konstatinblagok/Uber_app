@extends('layouts.app')
@section('content')

<style>

    .error {
  
      color: red;
    }
  
  </style>

<main>
    <div class="section" id="contactus">
        <div id="contactword">
            <p>@lang('lang.Reset Password')</p>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-8 col-xl-8 offset-md-3 offset-lg-3 offset-xs-2 offset-xl-2">

                <div class="section" id="location">
                    <div class="location_hours">
                        <h3 class="subhead" id="hours">@lang('lang.Cook or Customer')</h3>
                        <h5>@lang('lang.Reset your Password').</h5>
                        <div class="row">
                            <form id="userPasswordResetForm" action="{{ route('auth.password.reset.password') }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="token" value="{{$token}}">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">@lang('lang.Password')</label> 
                                            <input type="password" id="password" name="password" placeholder="@lang('lang.Password')" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password" class="col-12 col-form-label">@lang('lang.Confirm Password')</label> 
                                            <input type="password" name="password_confirmation" placeholder="@lang('lang.Confirm Password')" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="form-control btn btn-chezdon">@lang('lang.Reset Password')</button>
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

    $(document).ready(function () {

        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        //Form Validation
        $('#userPasswordResetForm').validate({

            rules: {

                token: {

                    required: true,
                },
                password:{
                    
                    required: true,
                    minlength: 6
                },
                password_confirmation: {

                    required: true,
                    equalTo : "#password"
                },
            },
            messages: {

                password: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Mot de passe requis';
                        }
                        else {

                            return 'Password is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le mot de passe doit contenir au moins 6 caractères';
                        }
                        else {

                            return 'Password must be at least 6 characters long';
                        }   
                    }
                },
                password_confirmation: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Confirmer le mot de passe est requis';
                        }
                        else {

                            return 'Confirm Password is required';
                        }   
                    },
                    equalTo: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le mot de passe et le mot de passe de confirmation ne sont pas identiques';
                        }
                        else {

                            return 'Password and confirm password are not the same';
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