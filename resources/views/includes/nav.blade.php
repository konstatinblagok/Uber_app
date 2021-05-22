<!-- Start header -->
<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img class="logo-img" src="/site/images/logo.png" alt="log image" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbars-rs-food">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item {{ request()->is('vision') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Our Vision</a>
                    </li>
                    <li class="nav-item {{ request()->is('order') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Order Online</a>
                    </li>
                    <li class="nav-item {{ request()->is('menu') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('show-menu')}}">Menu</a>
                    </li>
                    <li class="nav-item {{ request()->is('contact-us') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item {{ request()->is('gallery') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Shared Gallery</a>
                    </li>
                    <li class="nav-item {{ (request()->is('members')) ? 'active' : '' }}">
                        <a class="nav-link" href="#">Members</a>
                    </li>
<!--                    <li class="nav-item dropdown">-->
<!--                        <a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Blog</a>-->
<!--                        <div class="dropdown-menu" aria-labelledby="dropdown-a">-->
<!--                            <a class="dropdown-item" href="blog.html">blog</a>-->
<!--                            <a class="dropdown-item" href="blog-details.html">blog Single</a>-->
<!--                        </div>-->
<!--                    </li>-->
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown-auth" data-toggle="dropdown">Signup to cook</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-auth">
                            @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                            @if (Route::has('login'))
                            <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                        </div>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- End header -->
