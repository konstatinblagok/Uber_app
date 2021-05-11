@extends('app')

@section('content')
<div class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">
        @include('partials.top-menu')
        @include('partials.side-menu')

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

            @yield('dashboard-content')

            </div> <!-- content -->

            <footer class="footer">
                © 2016 WebAdmin - All Rights Reserved.
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->




</div>

@endsection
