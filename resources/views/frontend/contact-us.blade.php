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
            <p>@lang('lang.Contact Us')</p>
        </div>
    </div>
    <div class="section" id="location">
        <div class="location_hours">
            <h3 class="subhead" id="hours">@lang('lang.Location & Hours')</h3>
            <h5>@lang('lang.We\'d love to hear from you!')</h5>
            <form id="contactUsForm" action="{{ route('contact.us.store') }}" method="post">
                <div class="form">
                    @csrf
                    <h5>@lang('lang.Enter Your Name')</h5>
                    <input type="text" name="name" rows="10" placeholder="@lang('lang.Name')" required>
                    <h5>@lang('lang.Enter Your Email')</h5>
                    <input type="text" name="email" placeholder="@lang('lang.Email')" required>
                    <h5>@lang('lang.Enter Your Subject')</h5>
                    <input type="text" name="subject" placeholder="@lang('lang.Subject')" required>
                    <h5>@lang('lang.Enter Your Message')</h5>
                    <textarea name="message" id="explain" cols="30" rows="8" placeholder="@lang('lang.Message')" required></textarea>
                </div>
                <button class="submit">@lang('lang.Submit')</button>
            </form>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2585.4755323656295!2d6.105526115118839!3d49.60763905561309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479549323b05bdf5%3A0x4c3643052dc73d8d!2s14%20Rue%20d&#39;Oradour%2C%202266%20Luxembourg!5e0!3m2!1sen!2sin!4v1624387751620!5m2!1sen!2sin" width="100%" height="650" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</main>

@endsection

@push('scripts')
    
<script>

    $(document).ready(function () {

        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        //Form Validation
        $('#contactUsForm').validate({

            rules: {

                name: {

                    required: true,
                },
                email: {

                    required: true,
                    email: true,
                },
                subject: {

                    required: true,
                },
                message: {

                    required: true,
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
                },
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

                            return 'L\'e-mail doit être une adresse e-mail valide';
                        }
                        else {

                            return 'Email should be a valid email address';
                        }   
                    }
                },
                subject: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le sujet est requis';
                        }
                        else {

                            return 'Subject is required';
                        }   
                    },
                },
                message: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le message est requis';
                        }
                        else {

                            return 'Message is required';
                        }   
                    },
                }
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
    });

</script>

@endpush