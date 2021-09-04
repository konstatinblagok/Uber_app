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
                                <h3>Profile</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <form id="profileForm" action="{{ route('cook.profile.save') }}" method="post">
                                @csrf

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="form-group col-md-5">
                                            <label for="name" class="col-12 col-form-label">Name <small class="text-danger">*</small></label> 
                                            <input id="name" name="name" placeholder="Name" class="form-control" type="text" value="{{ isset($user->name) ? $user->name : '' }}">
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="email" class="col-12 col-form-label">Email</label> 
                                            <input id="email" name="email" placeholder="Email" class="form-control" value="{{ isset($user->email) ? $user->email : '' }}" type="text" disabled readonly>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="countryCode" class="col-12 col-form-label">Country Code <small class="text-danger">*</small></label> 
                                            <select name="countryCode" id="countryCode" class="form-control">
                                                @if(count($contries) > 0)
                                                    @foreach ($contries as $country)
                                                        <option value="{{ $country->phone_code }}" {{ $user->country_code == $country->phone_code ? 'selected' : '' }}>{{ $country->phone_code }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="phone" class="col-12 col-form-label">Phone Number <small class="text-danger">*</small></label> 
                                            <input type="phone" id="phone" name="phone" placeholder="Enter Phone" class="form-control" value="{{ isset($user->phone) ? $user->phone : '' }}">
                                            <div class="phoneDiv">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="currentPassword" class="col-12 col-form-label">Current Password </label> 
                                            <input id="currentPassword" name="currentPassword" placeholder="Current Password" class="form-control" type="password">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="newPassword" class="col-12 col-form-label">New Password </label> 
                                            <input id="newPassword" name="newPassword" placeholder="New Password" class="form-control" type="password">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="confirmNewPassword" class="col-12 col-form-label">Confirm New Password </label> 
                                            <input id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" class="form-control" type="password">
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

@endsection

@push('scripts')
  
    <script>

    $(document).ready(function () {

        var userID = {!! $user->id !!};

        //Form Validation
        $('#profileForm').validate({

            rules: {

                name: {

                    required: true,
                    minlength: 3
                },
                phone: {

                    required: true,
                    digits: true,
                }
            },
            submitHandler: function (form) { 

                var phone = $('#phone').val();
                var countryCode = $('#countryCode').val();
                            
                $.ajax({

                    url: "{{ route('auth.validation.phone') }}",
                    method: "POST",
                    data: {

                        "_token": "{{ csrf_token() }}",
                        'phone': phone,
                        'requestSource': 'profile',
                        'userID': userID,
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
                            
                            if($('#newPassword').val() != '') {

                                if($('#currentPassword').val() != '') {

                                    if($('#newPassword').val().length >= 6) {

                                        if($('#newPassword').val() == $('#confirmNewPassword').val()) {

                                            form.submit();
                                        }
                                        else {

                                            alert('Password and confirm password are not the same!');
                                        }
                                    }
                                    else {

                                        alert('Password length must be equal or greater than 6 characters!');
                                    }
                                }
                                else {

                                    alert('Please enter your current password!');
                                }
                            }
                            else {

                                form.submit();
                            }
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