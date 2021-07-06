{{-- Start header --}}
<header>
    <div class="top">
        <img src="{{ asset('site-asset/images/logo.webp') }}" alt="logo" class="logo">
        <a href="https://daleoswald7.wixsite.com/my-site-1" class="tagline">Chez Don</a>
        <div id="user">
            @if(Auth::check())
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <button class="login">
                    <i class="fas fa-user"></i>
                    <span>Logout</span>
                </button>
            </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
            <a href="{{ route('login') }}">
                <button class="login">
                    <i class="fas fa-user"></i>
                    <span>Log In</span>
                </button>
            </a>
            @endif
        </div>
    </div>
    <hr>
    <div>
        <nav class="navigation h-nav">
            <ul class="nav_links v-class ">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('about.us') }}">About</a></li>
                <li><a href="{{ route('how.it.works') }}">How it works ?</a></li>
                <li><a href="{{ route('our.vision') }}">Our Vision</a></li>
                <li><a href="{{ route('show.menu') }}">Menu</a></li>
                <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                @if(Auth::check())
                <li><a href="{{ route('user.show.profile') }}">My Profile</a></li>
                @endif
            </ul>
            <div class="burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </nav>
    </div>
</header>
{{-- End header --}}
