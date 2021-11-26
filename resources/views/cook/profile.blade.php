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
                                <h3>@lang('lang.Profile Setting')</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <form id="profileForm" action="{{ route('cook.profile.save') }}" method="post">
                                @csrf

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="form-group col-md-5">
                                            <label for="name" class="col-12 col-form-label">@lang('lang.Name') <small class="text-danger">*</small></label> 
                                            <input id="name" name="name" placeholder="@lang('lang.Name')" class="form-control" type="text" value="{{ isset($user->name) ? $user->name : '' }}">
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="email" class="col-12 col-form-label">@lang('lang.Email')</label> 
                                            <input id="email" name="email" placeholder="@lang('lang.Email')" class="form-control" value="{{ isset($user->email) ? $user->email : '' }}" type="text" disabled readonly>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="countryCode" class="col-12 col-form-label">@lang('lang.Country Code') <small class="text-danger">*</small></label> 
                                            <select name="countryCode" id="countryCode" class="form-control">
                                                @if(count($contries) > 0)
                                                    @foreach ($contries as $country)
                                                        <option value="{{ $country->phone_code }}" {{ $user->country_code == $country->phone_code ? 'selected' : '' }}>{{ $country->phone_code }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="phone" class="col-12 col-form-label">@lang('lang.Phone Number') <small class="text-danger">*</small></label> 
                                            <input type="phone" id="phone" name="phone" placeholder="@lang('lang.Phone Number')" class="form-control" value="{{ isset($user->phone) ? $user->phone : '' }}">
                                            <div class="phoneDiv">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="currentPassword" class="col-12 col-form-label">@lang('lang.Current Password') </label> 
                                            <input id="currentPassword" name="currentPassword" placeholder="@lang('lang.Current Password')" class="form-control" type="password">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="newPassword" class="col-12 col-form-label">@lang('lang.New Password') </label> 
                                            <input id="newPassword" name="newPassword" placeholder="@lang('lang.New Password')" class="form-control" type="password">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="confirmNewPassword" class="col-12 col-form-label">@lang('lang.Confirm New Password') </label> 
                                            <input id="confirmNewPassword" name="confirmNewPassword" placeholder="@lang('lang.Confirm New Password')" class="form-control" type="password">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-chezdon form-control">@lang('lang.Update')</button>
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
        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

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
                    minlength: 6,
                    maxlength: 15,
                }
            },
            messages: {

                name: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom est requis';
                        }
                        else {

                            return 'Name is required';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nom doit être supérieur ou égal à 3 caractères';
                        }
                        else {

                            return 'Name must be greater than or equal to 3 characters';
                        }   
                    }
                },
                phone: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de téléphone est requis';
                        }
                        else {

                            return 'Phone number is required';
                        }   
                    },
                    digits: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le champ du numéro de téléphone n\'accepte que les chiffres';
                        }
                        else {

                            return 'Phone number field accept only digits';
                        }   
                    },
                    minlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de téléphone doit être supérieur ou égal à 6 chiffres';
                        }
                        else {

                            return 'Phone number must be greater than or equal to 6 digits';
                        }   
                    },
                    maxlength: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le numéro de téléphone doit être inférieur ou égal à 15 chiffres';
                        }
                        else {

                            return 'Phone number must be less than or equal to 15 digits';
                        }   
                    }
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

                                            if(CurrentLanguage == 'fr') {

                                                alert('Le mot de passe et le mot de passe de confirmation ne sont pas identiques !');
                                            }
                                            else {

                                                alert('Password and confirm password are not the same!');
                                            } 
                                        }
                                    }
                                    else {

                                        if(CurrentLanguage == 'fr') {

                                            alert('La longueur du mot de passe doit être égale ou supérieure à 6 caractères !');
                                        }
                                        else {

                                            alert('Password length must be equal or greater than 6 characters!');
                                        }
                                    }
                                }
                                else {

                                    if(CurrentLanguage == 'fr') {

                                        alert('Veuillez saisir votre mot de passe actuel !');
                                    }
                                    else {

                                        alert('Please enter your current password!');
                                    }
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