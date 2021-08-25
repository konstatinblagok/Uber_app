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
            <p>Login</p>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-8 col-xl-8 offset-md-3 offset-lg-3 offset-xs-2 offset-xl-2">

                <div class="section" id="location">
                    <div class="location_hours">
                        <h3 class="subhead" id="hours">Cook or Customer</h3>
                        <h5>Login as cook to sell your meal and login as customer to buy meal.</h5>
                        <div class="row">
                            <form id="userLoginForm" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-4 col-form-label">Email</label> 
                                            <input id="email" name="email" placeholder="Enter Your Email" class="form-control" type="email" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password" class="col-4 col-form-label">Password</label> 
                                            <input id="password" name="password" placeholder="Enter Your Password" class="form-control" type="password" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('auth.password.email') }}">Forgot Password?</a>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <a href="{{ route('register') }}">Register</a>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="form-control btn btn-chezdon">Login</button>
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
          submitHandler: function (form) { 

                form.submit();
          }
      });
  });

</script>
  
@endpush