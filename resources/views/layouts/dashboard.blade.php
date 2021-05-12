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
    <!-- Dropzone css -->
    <link href="{{ asset('dashboard/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
          crossorigin="anonymous"/>
    <link href="{{ asset('dashboard/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet" type="text/css">

    <!--Plugins-->
    <link href="{{ asset('dashboard/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
<!--    <link href="{{ asset('dashboard/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">-->
    <link href="{{ asset('dashboard/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<!--    <link href="{{ asset('dashboard/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>-->
    <!-- DataTables -->
    <link href="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard/plugins/datatables/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<!--    <link href="{{ asset('dashboard/plugins/datatables/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>-->
<!--    <link href="{{ asset('dashboard/plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>-->
    <link href="{{ asset('dashboard/plugins/datatables/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard/plugins/datatables/scroller.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--Morris Chart CSS -->
<!--    <link rel="stylesheet" href="{{ asset('dashboard/plugins/morris/morris.css') }}">-->
    <!--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('dashboard/css/custom.css') }}" rel="stylesheet">

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
<script src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous"></script>
<script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
<!--<script src="{{ asset('dashboard/js/modernizr.min.js') }}"></script>-->
<!--<script src="{{ asset('dashboard/js/detect.js') }}"></script>-->
<script src="{{ asset('dashboard/js/fastclick.js') }}"></script>
<script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script>
<!--<script src="{{ asset('dashboard/plugins/raphael/raphael-min.js') }}"></script>-->


<!--<script src="{{ asset('dashboard/js/jquery.slimscroll.js') }}"></script>-->
<!--<script src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>-->
<!--<script src="{{ asset('dashboard/js/wow.min.js') }}"></script>-->
<script src="{{ asset('dashboard/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('dashboard/js/waves.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery.scrollTo.min.js') }}"></script>

<!-- Plugins js -->
<script src="{{ asset('dashboard/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"
        type="text/javascript"></script>
<!--Morris Chart-->

<script src="{{ asset('dashboard/pages/dashborad.js') }}"></script>

<!-- Datatables-->
<script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/buttons.print.min.js') }}"></script>
<!--<script src="{{ asset('dashboard/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>-->
<script src="{{ asset('dashboard/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<!--<script src="{{ asset('dashboard/plugins/datatables/dataTables.responsive.min.js') }}"></script>-->
<!--<script src="{{ asset('dashboard/plugins/datatables/responsive.bootstrap.min.js') }}"></script>-->
<script src="{{ asset('dashboard/plugins/datatables/dataTables.scroller.min.js') }}"></script>
<!-- Dropzone js -->
<script src="{{ asset('dashboard/plugins/dropzone/dist/dropzone.js') }}"></script>
<!-- Bootstrap File Style -->
<script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

<!-- Datatable init js -->
<script src="{{ asset('dashboard/pages/datatables.init.js') }}"></script>
<!-- Plugins Init js -->
<script src="{{ asset('dashboard/pages/form-advanced.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('dashboard/js/main.js') }}"></script>
<script src="{{ asset('dashboard/js/app.js') }}" defer></script>
<script src="{{ asset('dashboard/js/custom.js') }}" defer></script>
</body>
</html>

