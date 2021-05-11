<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <div class="user-details">
            <div class="text-center">
                <img src="{{ asset(Auth::user()->picture_url)}}" alt="" class="img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->getFullName() }}
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
                </div>

                <p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>
            </div>
        </div>
        <!--- Divider -->


        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span>
                            Dashboard <span class="badge badge-primary pull-right">1</span>
                        </span>
                    </a>
                </li>
                @if(Auth::user()->isEmployee())
                <li>
                    <a href="{{ route('work-history') }}">
                        <i class="mdi mdi-history"></i>
                        <span> Work History </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-documents') }}">
                        <i class="mdi mdi-file-document"></i>
                        <span> Upload Documents </span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->isAdmin())
                <li>
                    <a href="{{ route('employees.view') }}">
                        <i class="mdi mdi-account"></i>
                        <span> Employees </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-invoice') }}">
                        <i class="mdi mdi-receipt"></i>
                        <span> Invoice </span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
