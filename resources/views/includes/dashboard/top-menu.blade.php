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
                <form class="navbar-form pull-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control search-bar" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                </form>

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="dropdown hidden-xs">
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg">
                            <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success">3</span></li>
                            <li class="list-group">
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-heading">Your order is placed</div>
                                        <p class="m-0">
                                            <small>Dummy text of the printing and typesetting industry.</small>
                                        </p>
                                    </div>
                                </a>
                                <!-- list item-->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-body clearfix">
                                            <div class="media-heading">New Message received</div>
                                            <p class="m-0">
                                                <small>You have 87 unread messages</small>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- last list item -->
                                <a href="javascript:void(0);" class="list-group-item">
                                    <small class="text-primary">See all notifications</small>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="mdi mdi-fullscreen"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{asset(Auth::user()->picture_url)}}" alt="user-img" class="img-circle">
                            <span class="profile-username">
                                {{ Auth::user()->getFullName() }} <br/>
                                <small>{{ Auth::user()->getUserType() }}</small>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route ('profile')}}"> Profile</a></li>
                            <li><a href="{{ route('change-password') }}">Change Password </a></li>
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
