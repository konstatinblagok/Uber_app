@extends('layouts.app')
@section('content')

<main>
    <div class="backg" id="image1">
        <!-- slider -->
        <div class="container">

            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>

                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="{{ asset('site-asset/images/white.jpg') }}" class="d-block w-100" alt="white">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Homemade Food Delivered to Your Doorstep</h5>
                            <div class="slider-btn">
                                <button class="btn btn-1">Get it</button>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('site-asset/images/grey.jpg') }}" class="d-block w-100" alt="grey">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 id="grey">Get in YOUR KITCHEN and get Paid</h5>
                            <div class="slider-btn">
                                <button class="btn btn-2">Sign up to cook</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <h2><b>Welcome to Chez Don !<b></h2>
    <h3 class="subhead">Local fresh cuisine for everyone & everywhere</h3>
    <div class="section" id="1">
        <div id="box2">
            <img src="{{ asset('site-asset/images/i2.png') }}" alt="couple cooking" id="i2">
            <img src="{{ asset('site-asset/images/i4.png') }}" alt="meat" id="i4">
            <p>Cook at home and get paid for it</p>
            <a href="aboutus" id="readmore">Read more Here ></a>
        </div>
        <div id="box1">
            <p>The first platform in Luxembourg to get fresh, home-made food delivered to your home for a very affordable price.</p>
            <a href="aboutus" id="readmore">Read more Here ></a>
            <img src="{{ asset('site-asset/images/i3.png') }}" alt="salad" id="i3">
            <img src="{{ asset('site-asset/images/i5.png') }}" alt="dish" id="i5">
        </div>
    </div>
    <div class="section" id="menuicon">
        <div id="menubutton">
            <a href="#">Menu</a>
        </div>
    </div>
    <div class="backg" id="foot">
    </div>
</main>

@endsection
