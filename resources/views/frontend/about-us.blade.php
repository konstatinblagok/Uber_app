@extends('layouts.app')
@section('content')

<style>

    a.submit {

        background-color: white;
        color: #343434;
        font-weight: 100;
        border: 1px solid #936F3B;
        padding: 13px 99px;
        font-family: 'FuturaLight';
        border-radius: initial;
        width: 90%;
    }
    a.submit:hover {

        background-color: #936f3b;
        color: #fff;
    }

    @media only screen and (max-width: 350px) {
        a.submit {
            padding: 13px 15px !important;
        }
    }

    @media only screen and (max-width: 550px) {
        a.submit {
            padding: 13px 23px !important;
        }
    }

    @media only screen and (max-width: 750px) {
        a.submit {
            padding: 13px 32px !important;
        }
    }

    @media only screen and (max-width: 950px) {
        a.submit {
            padding: 13px 43px !important;
        }
    }

</style>

<main>
    <div class="section" id="aboutus">
        <div id="aboutword">
           <p>@lang('lang.About Chez Don')</p>
        </div>
    </div>
    <div class="concepts">
        <p id="Our_concept">@lang('lang.Our Concept')</p>
    </div>
    <div class="section" id="working">
        <div class="secondcoloumn" id="woman_para">
            <p>@lang('lang.We started our business in 2021 with one goal in mind: providing an enjoyable dining experience at home in the city of Luxembourg and creating an opportunity for all the people, who love cooking at home, to get paid'). @lang('lang.Whether you don\'t have enough time or desire to cook after a long day at work, at Chez Don you can simply order a fresh and home-made dish from our approved cooks for a price cheaper than at any restaurant'). @lang('lang.We take extra care of the quality of all food products which our cooks use, as well as the hygiene of their kitchen'). @lang('lang.In addition, Chez Don is also responsible for the delivery and packaging'). @lang('lang.Thanks to our experience and dedication, we’ve managed to become masters of the craft'). @lang('lang.Providing dishes that are fresh, hearty and simply unforgettable').
            </p>
        </div>
        <div class="woman_image">
            <img src="{{ asset('public/site-asset/images/woman.png') }}" alt="Woman Working">
        </div>
    </div>
    <div class="section" id="working">
        <div class="cup_pic mt-5">
            <img src="{{ asset('public/site-asset/images/phone.png') }}" alt="cup">
        </div>
        <div class="secondcoloumn" id="woman_para">
            <h3 style="color:#292929;font-weight:200;">@lang('lang.For cooks'):</h3>
            <p>@lang('lang.You enjoy cooking at home and wish more people could taste your creations')? @lang('lang.With Chez Don you have this opportunity! Just sign up on the platform to become a cook, prepare dishes which others can enjoy, get reviews and rankings and get paid for it'). </p>
            <a class="submit btn btn-chezdon" href="{{ route('how.it.works') }}">@lang('lang.How it works') ></a>
        </div>
    </div>
    <div class="section" id="working">
        <div class="secondcoloumn" id="woman_para">
            <h3 style="color:#292929;font-weight:200;">@lang('lang.For customers'):</h3>
            <p>@lang('lang.Ordering food home has never been more convenient and cheaper! To save you the trouble of cooking with a busy schedule on a hectic day, we offer you freshly prepared, home-made food to your liking'). @lang('lang.You can choose from any meal type: meat/ fish/ pasta/ vegetarian or vegan friendly options and even desserts'). @lang('lang.And all this for a much cheaper price than at any restaurant')!</p>
            <a class="submit btn btn-chezdon" href="{{ route('how.it.works') }}">@lang('lang.How it works') ></a>
        </div>
        <div class="cup_pic mt-5">
            <img src="{{ asset('public/site-asset/images/brown_bag.webp') }}" alt="bag">
        </div>
    </div>
    {{-- <h3 class="subhead" id="press">@lang('lang.From the Press')</h3> 
    <div class="forms_press">
        <p class="bullets" >1</p>
        <span class="url">GoGreenMag.com</span>
    </div>
    <p class="subhead" id="points">@lang('lang.Fresh & Tasty Chez Don. On time delivery and better prices than at the restaurant').</p>
    <div class="forms_press">
        <p class="bullets">2</p>
        <span class="url">Emma Brown, Blogger - Oh My Goodness</span>
    </div>
    <p class="subhead" id="points">@lang('lang.I was excited to try something new, not made in a restaurant, but in a private clean kitchen').</p>
    <div class="forms_press">
        <p class="bullets">3</p>
        <span class="url">The Food Reporter</span>
    </div>
    <p class="subhead" id="points">@lang('lang.Revolutionary idea, homemade food at your doorstep'). @lang('lang.Brilliant Idea').</p>--}}
    <div class="backg" id="potatoes"></div>
</main>

@endsection
