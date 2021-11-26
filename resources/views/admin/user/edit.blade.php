@extends('layouts.admin.app')

@section('title')

    <title>Admin | User Management</title>

@endsection

@section('content')

    <style>

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {

        color: #fff !important;
        background: #037bfe !important;
        border: 1px solid #037bfe !important;
    }

    .select2-container--bootstrap4 .select2-dropdown .select2-results__option[aria-selected="true"]{

        background-color: #818992 !important;
    }

    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>User Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.user.all') }}">All Users</a></li>
                <li class="breadcrumb-item active">Edit User</li>
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
                                Edit User
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="userForm" action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="post">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="status">Role <small class="text-danger">*</small></label>
                                        <select class="form-control" name="userType" id="userType">
                                            <option value="">Select Role...</option>
                                            @forelse ($roles as $item)
                                                <option value="{{ $item->id }}" {{ $user->user_role_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="name">Full Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ $user->name }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="email">Email <small class="text-danger">*</small></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ $user->email }}">
                                        
                                        <div class="emailDiv">
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 form-group">
    
                                        <label for="emailVerification">Email Verified <small class="text-danger">*</small></label>
                                        <select class="form-control" name="emailVerification" id="emailVerification">
                                            <option value="No" {{ !isset($user->email_verified_at) ? 'selected' : '' }}>No</option>
                                            <option value="Yes" {{ isset($user->email_verified_at) ? 'selected' : '' }}>Yes</option>
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 form-group">
    
                                        <label for="countryCode">Country Code <small class="text-danger">*</small></label>
                                        <select class="form-control" name="countryCode" id="countryCode">
                                            @forelse ($contries as $item)
                                                <option value="{{ $item->phone_code }}" {{ $user->country_code == $item->phone_code ? 'selected' : '' }}>{{ $item->phone_code }}</option>
                                            @empty
                                                <option value="">Select Country Code...</option>
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="phone">Phone <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" value="{{ $user->phone }}">
                                        
                                        <div class="phoneDiv">
                                        </div>
                                        
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 form-group">
    
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="status">Status</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="status" name="status" value="approved" {{ $user->is_approved == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">Approved</label>
                                        </div>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group" id="foodTypeDiv" style="display:none;">
                                        <label>Food To Cook <small class="text-danger">*</small></label>
                                        <select name="foodType[]" id="foodType"class="form-control select2bs4" style="width: 100%;" multiple>
                                            @forelse ($foodType as $type)
                                                <option value="{{ $type->id }}" {{ in_array($type->id, $cookFoodType) ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
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

        var userID = {!! $user->id !!};

        if($('#userType').val() == 2) {

            $('#foodTypeDiv').show();
        }

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#userType').change(function() {

            if($(this).val() == 2) {

                $('#foodTypeDiv').show();
            }
            else {

                $('#foodTypeDiv').hide();
            }
        });

        //Form Validation
        $('#userForm').validate({

            // ignore: [],
            rules: {

                userType: {

                    required: true,
                },
                'foodType[]': {

                    required: function(element) {

                        return $('#userType').val() == 2;
                    }
                },
                name: {

                    required: true,
                    minlength: 3
                },
                email: {

                    required: true,
                    email: true,
                },
                emailVerification: {

                    required: true,
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
                    
                    minlength: 6
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