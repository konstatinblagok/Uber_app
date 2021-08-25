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
            <p>Forgot Password</p>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-8 col-xl-8 offset-md-3 offset-lg-3 offset-xs-2 offset-xl-2">

                <div class="section" id="location">
                    <div class="location_hours">
                        <h3 class="subhead" id="hours">Cook or Customer</h3>
                        <h5>Please enter your email to receive password reset instructions.</h5>
                        <div class="row">
                            <form id="userPasswordEmailForm" action="{{ route('auth.password.send.reset.link') }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-4 col-form-label">Email</label> 
                                            <input id="email" name="email" placeholder="Enter Your Email" class="form-control" type="email" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('login') }}">Login</a>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('register') }}">Register</a>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="form-control btn btn-chezdon">Send Password Reset Link</button>
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

        //Form Validation
        $('#userPasswordEmailForm').validate({

            rules: {

                email: {

                    required: true,
                    email: true,
                },
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
    });

</script>
  
@endpush