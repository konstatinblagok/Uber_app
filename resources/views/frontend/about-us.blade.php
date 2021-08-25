@extends('layouts.app')
@section('content')

<main>
    <div class="section" id="aboutus">
        <div id="aboutword">
           <p>About Chez Don</p>
        </div>
    </div>
    <div class="concepts">
        <p id="Our_concept">Our Concept</p>
    </div>
    <div class="section" id="working">
        <div class="secondcoloumn" id="woman_para">
            <p>We started our business in 2021 with one goal in mind: providing an enjoyable dining experience at home in the city of Luxembourg and creating an opportunity for all the people, who love cooking at home, to get paid. Whether you don't have enough time or desire to cook after a long day at work, at Chez Don you can simply order a fresh and home-made dish from our approved cooks for a price cheaper than at any restaurant. We take extra care of the quality and the cleanliness of our cooks and kitchen. In addition, Chez Don is also responsible for the delivery and packages. Thanks to our experience and dedication, we’ve managed to become masters of the craft. Providing dishes that are fresh, hearty and simply unforgettable.
            </p>
        </div>
        <div class="woman_image">
            <img src="{{ asset('public/site-asset/images/woman.png') }}" alt="Woman Working">
        </div>
    </div>
    <div class="section" id="working">
        <div class="cup_pic">
            <img src="{{ asset('public/site-asset/images/phone.png') }}" alt="cup">
        </div>
        <div class="secondcoloumn" id="woman_para">
            <h3>For cooks:</h3>
            <p>You enjoy cooking at home and wish more people could taste your creations? With Chez Don you have this opportunity! Just sign up on the platform to become a cook, prepare dishes which others can enjoy, get reviews and rankings and get paid for it. </p>
            <a class="submit" href="{{ route('how.it.works') }}">How it works ></a>
        </div>
    </div>
    <h3 class="subhead" id="press">From the Press</h3> 
    <div class="forms_press">
        <p class="bullets" >1</p>
        <span class="url">GoGreenMag.com</span>
    </div>
    <p class="subhead" id="points">Fresh & Tasty Chez Don. On time delivery and better prices than at the restaurant.</p>
    <div class="forms_press">
        <p class="bullets">2</p>
        <span class="url">Emma Brown, Blogger - Oh My Goodness</span>
    </div>
    <p class="subhead" id="points">I was excited to try something new, not made in a restaurant, but in a private clean kitchen.</p>
    <div class="forms_press">
        <p class="bullets">3</p>
        <span class="url">The Food Reporter</span>
    </div>
    <p class="subhead" id="points">Revolutionary idea, homemade food at your doorstep. Brilliant Idea.</p>
    <div class="backg" id="potatoes"></div>
</main>
@endsection
