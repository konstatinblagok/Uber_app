@extends('layouts.admin.app')

@section('title')

    <title>Admin | Profile</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Admin Profile</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin Profile</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Profile
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="profileForm" action="{{ route('admin.profile.save') }}" method="post">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="name">Full Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ Auth::user()->name }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="email">Email <small class="text-danger">*</small></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ Auth::user()->email }}">
                                        
                                        <div class="emailDiv">
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="countryCode">Country Code <small class="text-danger">*</small></label>
                                        <select class="form-control" name="countryCode" id="countryCode">
                                            @forelse ($contries as $item)
                                                <option value="{{ $item->phone_code }}" {{ Auth::user()->country_code == $item->phone_code ? 'selected' : '' }}>{{ $item->phone_code }}</option>
                                            @empty
                                                <option value="">Select Country Code...</option>
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="phone">Phone <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" value="{{ Auth::user()->phone }}">
                                        
                                        <div class="phoneDiv">
                                        </div>
                                        
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Enter Confirm Password">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <button type="submit" class="form-control btn btn-primary">Update</button>
    
                                    </div>
    
                                </div>

                            </form>
                        
                        </div>
                    
                    </div>
        
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
  
<script>

    $(document).ready(function () {

        var userID = {!! Auth::user()->id !!};

        //Form Validation
        $('#profileForm').validate({

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
                    
                    minlength: 6,
                    required: function(el) {

                        return $.trim($('#confirmPassword').val()) != '';
                    },
                },
                confirmPassword:{
                    
                    minlength: 6,
                    required: function(el) {

                        return $.trim($('#password').val()) != '';
                    },
                    equalTo: '#password',
                },
            },
            submitHandler: function (form) { 
                
                var email = $('#email').val();
                
                $.ajax({

                    url: "{{ route('auth.validation.email') }}",
                    method: "POST",
                    data: {

                        "_token": "{{ csrf_token() }}",
                        'email': email,
                        'requestSource': 'adminEdit',
                        'userID': userID,
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
                                    'requestSource': 'adminEdit',
                                    'userID': userID,
                                },
                                dataType: 'json',
                                success: function(data) {

                                    if(data.success) {

                                        $('.phoneDiv').append('<label class="phoneErrorLabel error">Phone already exists!</label>');
                                    }
                                    else {

                                        $('.phoneErrorLabel').remove();
                                        form.submit();
                                    }
                                },
                                error: function(data) {

                                    //
                                }
                            });
                        }
                    },
                    error: function(data) {

                        //
                    }
                });
            }
        });
    });

</script>

@endpush