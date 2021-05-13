<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="/" class="logo logo-admin">
                <span>{{ explode(' ',trim(config('app.name')))[0] }}</span>
                {{ explode(' ',trim(config('app.name')))[1] }}
            </a>

            <a href="/" class="logo-sm"><span>{{ explode(' ',trim(config('app.name')))[0][0] }}</span></a>
            <!--<a href="/" class="logo"><img src="assets/images/logo_white_2.png" height="28"></a>-->
            <!--<a href="/" class="logo-sm"><img src="assets/images/logo_sm.png" height="36"></a>-->
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="mdi mdi-fullscreen"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{asset(Auth::user()->picture_url)}}" alt="user-img" class="img-circle">
                            <span class="profile-username">
                                {{ Auth::user()->name }} <br/>
                                <small>{{ Auth::user()->getUserType->name }}</small>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/home"> Profile</a></li>
                            <li><a href="/change-password">Change Password </a></li>
                            <li class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{!! route('logout') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->
