<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('public/site-asset/images/favicon.ico') }}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title')

    <!-- Site Metas -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    @include('includes.admin.styles')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
    
        {{-- Preloader --}}
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('public/site-asset/images/logo.webp') }}" alt="" height="60" width="60">
        </div>
    
        {{-- Navbar --}}
        @include('includes.admin.nav')
    
        @include('includes.admin.sidebar')
    
        {{-- Content Wrapper. Contains page content --}}
        <div class="content-wrapper">
            
            @include('includes.admin.alerts')
            
            @yield('content')

        </div>
      
        {{-- Footer --}}
        @include('includes.admin.footer')
    
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->
 
    @include('includes.admin.scripts')

    @stack('scripts')

</body>

</html>
