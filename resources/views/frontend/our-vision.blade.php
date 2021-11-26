@extends('layouts.app')
@section('content')

<style>

    @media only screen and (min-width: 1070px) and (max-width: 1200px) {
        .woman_image img {
            height: 90%;
            width: 37vw !important;
        }
    }

    @media only screen and (min-width: 1200px) and (max-width: 1500px) {
        .woman_image img {
            height: 90%;
            width: 32vw !important;
        }
    }

    @media only screen and (min-width: 1500px) and (max-width: 1800px) {
        .woman_image img {
            height: 75%;
            width: 25vw !important;
        }
    }

    @media only screen and (min-width: 1800px) and (max-width: 2100px) {
        .woman_image img {
            height: 65%;
            width: 19vw !important;
        }
    }

    @media only screen and (min-width: 2100px) and (max-width: 2400px) {
        .woman_image img {
            height: 55%;
            width: 15vw !important;
        }
    }

    @media only screen and (min-width: 2400px) and (max-width: 2700px) {
        .woman_image img {
            height: 48%;
            width: 12vw !important;
        }
    }

    @media only screen and (min-width: 2700px) and (max-width: 3100px) {
        .woman_image img {
            height: 54%;
            width: 9vw !important;
        }
    }

    @media only screen and (min-width: 3100px) and (max-width: 3400px) {
        .woman_image img {
            height: 56%;
            width: 7vw !important;
        }
    }

</style>

<main>
    <div class="section" id="our_vision">
        <div id="contactword">
            <p>@lang('lang.Our Vision')</p>
        </div>
    </div>
    <div class="section" id="working">
        <div class="secondcoloumn "  id="woman_para">
            <p>@lang('lang.Our Vision is aimed to make it possible for all people from Luxembourg to either become a chef preparing delicious dishes in the comfort of their own home and get paid for it or simply if you don\'t have time or desire to cook every day and are looking to order a fresh, homemade dish for a more affordable price than restaurant\'s'). @lang('lang.You can choose any dish by category: meat - fish- pasta - vegetarian - vegan- dessert'). @lang('lang.Easy, affordable and fun!')
            </p>
        </div>
        <div class="woman_image " id="vision">
            <img src="{{ asset('public/site-asset/images/woman.png') }}" alt="Woman Working">
        </div>
    </div> 
    <div class="backg" id="plates"></div>  
</main>

@endsection
