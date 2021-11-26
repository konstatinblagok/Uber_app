<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('public/site-asset/images/favicon.ico') }}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>@isset($title) {{$title}} @else {{config('app.name')}} @endisset</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    @include('includes.site.styles')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    {{-- <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;"> --}}

@include('includes.site.nav')

@include('includes.site.alerts')

@if(Auth::check() && Auth::user()->emailNotVerified())

    @include('includes.site.emailVerificationNotification')

@endif

@yield('content')

@include('includes.site.footer')

<a href="#" id="back-to-top" title="Back to top" style="display: none;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>

@include('includes.site.scripts')

<script>

    $('#langChanger').change(function() {

        languageSet($(this).val());
    });

    function languageSet(selectValue) {

        $.ajax({

            url: "{{ route('change.lang') }}",
            method: 'GET',
            data: {

                'lang': selectValue,
            },
            success: function(data) {

                window.location.reload();
            },
            error: function(data) {

                //
            }
        });
    }

</script>

@stack('scripts')

</body>
</html>
