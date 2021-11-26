<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/admin/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition login-page">

    <div class="login-box">
        
        <div class="card card-outline card-primary">

            <div class="card-header text-center">
            <a href="{{ Request::root() }}" class="h1"><b>ChezDon</b></a>
            </div>

            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="adminLoginForm" action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-12">

                            @if(Session::has('error'))
                                <div class="alert {{ Session::get('alert-class', 'alert-danger') }} fadedAlert" role="alert">
                                    <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('error') }}
                                    <script>
                                        setTimeout(function () {
                                            $('div.fadedAlert').toggle(1000);
                                        }, 5000);
                                    </script>
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div class="alert {{ Session::get('alert-class', 'alert-success') }} fadedAlert" role="alert">
                                    <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('success') }}
                                    <script>
                                        setTimeout(function () {
                                            $('div.fadedAlert').toggle(1000);
                                        }, 5000);
                                    </script>
                                </div>
                            @endif
                            
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                    
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>

            </div>

        </div>

    </div>

    <!-- jQuery -->
    <script src="{{ asset('public/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public/admin/dist/js/adminlte.min.js') }}"></script>

    <script>

    $(document).ready(function () {

        //Form Validation
        $('#adminLoginForm').validate({

            rules: {

                email: {

                    required: true,
                    email: true,
                },
                password:{
                    
                    required: true,
                    minlength: 6
                }
            },
            submitHandler: function (form) { 

                    form.submit();
            }
        });
    });

    </script>

</body>
</html>
