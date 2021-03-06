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
            <p>@lang('lang.Login')</p>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-8 col-xl-8 offset-md-3 offset-lg-3 offset-xs-2 offset-xl-2">

                <div class="section" id="location">
                    <div class="location_hours">
                        <h3 class="subhead" id="hours">@lang('lang.Cook or Customer')</h3>
                        <h5>@lang('lang.Login as cook to sell and buy meal and login as customer to buy meal').</h5>
                        <div class="row">
                            <form id="userLoginForm" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">@lang('lang.Email') <small class="text-danger">*</small></label> 
                                            <input id="email" name="email" placeholder="@lang('lang.Enter Your Email')" class="form-control" type="email" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password" class="col-12 col-form-label">@lang('lang.Password') <small class="text-danger">*</small></label> 
                                            <input id="password" name="password" placeholder="@lang('lang.Enter Your Password')" class="form-control" type="password" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('auth.password.email') }}">@lang('lang.Forgot Password')?</a>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('register') }}">@lang('lang.Register')</a>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="form-control btn btn-chezdon">@lang('lang.Login')</button>
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
        $('#userLoginForm').validate({

            rules: {

                email: {

                    required: true,
                    email: true,
                },
                password:{
                    
                    required: true,
                    minlength: 6
                }
            },
            messages: {

                email: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'e-mail est requis';
                        }
                        else {

                            return 'Email is required';
                        }   
                    },
                    email: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'L\'e-mail doit ??tre une adresse e-mail valide';
                        }
                        else {

                            return 'Email should be a valid email address';
                        }   
                    }
                },
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

                            return 'Le mot de passe doit contenir au moins 6 caract??res';
                        }
                        else {

                            return 'Password must be at least 6 characters long';
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