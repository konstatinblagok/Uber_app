@extends('layouts.app')

@section('content')
<div class="contact-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
            <div class="heading-title text-center mt-5 mb-0">
                <h2>{{ __('Register') }}</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset-3 col-md-6">
            @if(session()->has('message'))
            <div class="alert alert-success">
                @if(session()->get('is_cook_registration'))
                <span>
                    Your Account has been created and is submitted to the admin for the activation.
                    Once activated, you will be able to login from <a href="/login">here</a>.
                </span>
                @else
                <span>
                    Your Account has been created. You can login from <a href="/login">here</a> to
                    use the services.
                </span>
                @endif
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="mb-5" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="profile-container" class="row">
                                <image id="profileImage" class="offset-4" src="/site/images/default-user.jpg" />
                            </div>
                            <input id="imageUpload" type="file" name="profile_photo"
                                   placeholder="Photo" required="" capture>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name"
                                   autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                   required autocomplete="new-password" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input id="phone" type="number" placeholder="Contact #"
                                   value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" required autocomplete="phone">

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                        <textarea id="address" placeholder="Address"
                                  class="form-control @error('address') is-invalid @enderror"
                                  name="address" required autocomplete="address">{{ old('address') }}</textarea>

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                        <textarea id="biography" placeholder="About Yourself"
                                  class="form-control @error('biography') is-invalid @enderror"
                                  name="biography" autocomplete="biography">{{ old('biography') }}</textarea>

                            @error('biography')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="userTypeSwitch" class="form-check-label">
                                Registring as:
                            </label>
                            <span class="ml-4">
                                <input type="checkbox" id="userTypeSwitch" name="isCustomer"
                                       class="form-check-input"
                                       data-toggle="toggle" data-style="android" data-size="xs"
                                       data-on="Customer" data-off="Cook"
                                       data-onstyle="outline-primary" data-offstyle="outline-primary"
                                       {{ old('isCustomer') == 'on' ? 'checked' : '' }}
                                />
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-check">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox" required>
                                <label for="checkbox-signup">
                                    I accept
                                    <a href="#" data-toggle="modal" data-target="#terms-conditions-modal">
                                        Terms and Conditions
                                    </a>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="submit-button text-center">
                            <button type="submit" id="submit" class="btn btn-common">{{ __('Register') }}</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>

                            @if (Route::has('login'))
                            <a class="btn btn-link" href="{{ route('login') }}">{{ __('Already Have an account?') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('includes.site.modals.terms-conditions-modal')
@endsection
