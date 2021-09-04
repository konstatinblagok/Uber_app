@extends('layouts.app')
@section('content')

<style>

    .error {
  
      color: red;
    }
    .select2-container .select2-search--inline .select2-search__field {

        box-sizing: border-box;
        border: none;
        line-height: 1.5;
        font-size: 100%;
        margin-left: 5px;
        padding: 0;
        max-width: 100%;
        resize: none;
        height: 18px;
        vertical-align: bottom;
        font-family: sans-serif;
        overflow: hidden;
        word-break: keep-all;
    }
  
  </style>

<main>
    <div class="section" id="contactus">
        <div id="contactword">
            <p>Register</p>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-8 col-xl-8 offset-md-3 offset-lg-3 offset-xs-2 offset-xl-2">

                <div class="section" id="location">
                    <div class="location_hours">
                        <h3 class="subhead" id="hours">Cook or Customer</h3>
                        <h5>Register as cook to sell your meal and Register as customer to buy meal.</h5>
                        <div class="row">
                            <form id="userRegisterForm" action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">Name <small class="text-danger">*</small></label> 
                                            <input type="text" name="name" placeholder="Enter Name" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">Email <small class="text-danger">*</small></label> 
                                            <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control">
                                            <div class="emailDiv">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="countryCode" class="col-12 col-form-label">Country Code <small class="text-danger">*</small></label> 
                                            <select name="countryCode" id="countryCode" class="form-control">
                                                @if(count($contries) > 0)
                                                    @foreach ($contries as $country)
                                                        <option value="{{ $country->phone_code }}">{{ $country->phone_code }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="phone" class="col-12 col-form-label">Phone Number <small class="text-danger">*</small></label> 
                                            <input type="phone" id="phone" name="phone" placeholder="Enter Phone" class="form-control">
                                            <div class="phoneDiv">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">Password <small class="text-danger">*</small></label> 
                                            <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password" class="col-12 col-form-label">Confirm Password <small class="text-danger">*</small></label> 
                                            <input type="password" name="password_confirmation" placeholder="Enter Confirm Password" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email" class="col-12 col-form-label">Register as <small class="text-danger">*</small></label> 
                                            <select name="userType" id="userType" class="form-control">
                                                <option value="">Select...</option>
                                                <option value="2">Cook</option>
                                                <option value="3">Customer</option>
                                            </select>
                                        </div>
                                        <div id="foodTypeDiv" style="display:none;" class="form-group col-md-12">
                                            <label>Food to cook <small class="text-danger">*</small></label>
                                            <br>
                                            <select class="form-control select2 select2-multiple foodTypeMultiSelect" name="foodType[]" multiple="multiple" data-placeholder="Select Food to Cook">
                                                @if(count($foodTypes) > 0)
                                                    @foreach ($foodTypes as $foodType)
                                                        <option value="{{ $foodType->id }}">{{ $foodType->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <a href="{{ route('login') }}">Login</a>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="form-control btn btn-chezdon registerBtn">Register</button>
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

    $('.foodTypeMultiSelect').select2();

    $('#userType').change(function() {

        if($(this).val() == 2) {

            $('#foodTypeDiv').show();
        }
        else {

            $('#foodTypeDiv').hide();
        }
    });

      //Form Validation
      $('#userRegisterForm').validate({

            ignore: [],
            rules: {

                name: {

                    required: true,
                    minlength: 3
                },
                email: {

                    required: true,
                    email: true,
                },
                countryCode: {

                    required: true,
                },
                phone: {

                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 15,
                },
                password:{
                    
                    required: true,
                    minlength: 6
                },
                password_confirmation: {

                    required: true,
                    minlength : 6,
                    equalTo : "#password"
                },
                userType: {

                    required: true,
                }
            },
            submitHandler: function (form) { 

                $('.registerBtn').attr('disabled', 'disabled');

                if($('#userType').val() == 2) {

                    if($('.foodTypeMultiSelect').val().length == 0) {

                        alert('Please select one or more food types you want to cook!');

                        return false;

                        $('.registerBtn').removeAttr('disabled');
                    }
                }
                
                var email = $('#email').val();
                
                $.ajax({

                    url: "{{ route('auth.validation.email') }}",
                    method: "POST",
                    data: {

                        "_token": "{{ csrf_token() }}",
                        'email': email,
                    },
                    dataType: 'json',
                    success: function(data) {

                        if(data.success) {

                            $('.emailDiv').append('<label class="emailErrorLabel error">Email already exists!</label>');
                            
                            $('.registerBtn').removeAttr('disabled');
                        }
                        else {

                            $('.emailErrorLabel').remove();

                            var phone = $('#phone').val();
                            var countryCode = $('#countryCode').val();
                            
                            $.ajax({

                                url: "{{ route('auth.validation.phone') }}",
                                method: "POST",
                                data: {

                                    "_token": "{{ csrf_token() }}",
                                    'phone': phone,
                                    'countryCode': countryCode,
                                },
                                dataType: 'json',
                                success: function(data) {

                                    if(data.success) {

                                        $('.phoneDiv').append('<label class="phoneErrorLabel error">Phone already exists!</label>');
                                        
                                        $('.registerBtn').removeAttr('disabled');
                                    }
                                    else {

                                        $('.phoneErrorLabel').remove();
                                        form.submit();
                                    }
                                },
                                error: function(data) {

                                    console.log(data);

                                    $('.registerBtn').removeAttr('disabled');
                                }
                            });
                        }
                    },
                    error: function(data) {

                        console.log(data);
                        
                        $('.registerBtn').removeAttr('disabled');
                    }
                });
            }
      });
  });

</script>
  
@endpush