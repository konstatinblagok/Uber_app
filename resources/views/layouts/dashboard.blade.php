<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="{{ config('app.name', 'Laravel') }}" name="description"/>
    <meta content="ThemeDesign" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{ env('APP_URL') }}" target="_self">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @include('includes.dashboard.styles')

    <script type="text/javascript">
        const BASE_URL = "{{ env('APP_URL') }}";
    </script>
</head>
<body class="fixed-left">
<div id="app">
    <main class="py-4">

        <div class="fixed-left">

            <!-- Begin page -->
            <div id="wrapper">
                @include('includes.dashboard.top-menu')
                @include('includes.dashboard.side-menu')

                <!-- Start right Content here -->

                <div class="content-page">
                    <!-- Start content -->
                    <div class="content">

                        @yield('dashboard-content')

                    </div> <!-- content -->

                    <footer class="footer">
                        © {{Carbon\Carbon::now()->year}} {{config('app.name')}} - All Rights Reserved.
                    </footer>

                </div>
                <!-- End Right content here -->

            </div>
            <!-- END wrapper -->


        </div>

    </main>
</div>

<!-- Scripts -->
@include('includes.dashboard.scripts')
@yield('dashboard-scripts')

</body>
</html>

