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
            
            @include('includes.site.customer.dashboardSideBar')

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
                            <form id="profileForm" action="{{ route('customer.profile.save') }}" method="post">
                                @csrf

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label for="name" class="col-4 col-form-label">Name <small class="text-danger">*</small></label> 
                                            <input id="name" name="name" placeholder="Name" class="form-control" type="text" value="{{ isset($user->name) ? $user->name : '' }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email" class="col-4 col-form-label">Email</label> 
                                            <input id="email" name="email" placeholder="Email" class="form-control" value="{{ isset($user->email) ? $user->email : '' }}" type="text" disabled readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="currentPassword" class="col-4 col-form-label">Current Password </label> 
                                            <input id="currentPassword" name="currentPassword" placeholder="Current Password" class="form-control" type="password">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="newPassword" class="col-4 col-form-label">New Password </label> 
                                            <input id="newPassword" name="newPassword" placeholder="New Password" class="form-control" type="password">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="confirmNewPassword" class="col-4 col-form-label">Confirm New Password </label> 
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

@include('includes.site.jsRoutes')

@endsection

@push('scripts')
  
    <script>

    $(document).ready(function () {

        //Form Validation
        $('#profileForm').validate({

            rules: {

                name: {

                    required: true,
                    minlength: 3
                }
            },
            submitHandler: function (form) { 

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
        });
    });

    </script>

@endpush