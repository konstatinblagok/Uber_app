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
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/profile"> Profile</a></li>
                        <li><a href="/change-password')">Change Password </a></li>
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

                <a href="{{route('view-balance')}}" class="btn btn-dark waves-effect waves-light m-t-30">
                    <strong>Balance:</strong> $89
                </a>

            </div>
        </div>
        <!--- Divider -->


        <div id="sidebar-menu">
            <ul>
                @if(Auth::user()->isCook())
                <li class="active">
                    <a href="{{route('view-food-selection')}}" class="waves-effect">
                        <i class="mdi mdi-food"></i>
                        <span> Food Selection </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('view-billing')}}" class="waves-effect">
                        <i class="mdi mdi-receipt"></i>
                        <span> billing Info </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('view-balance')}}" class="waves-effect">
                        <i class="mdi mdi-checkbox-multiple-blank"></i>
                        <span> Withdraw Amount</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
