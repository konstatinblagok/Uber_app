@extends('layouts.app')
@section('content')

<main>
    <div class="section" id="our_vision">
        <div id="contactword">
            <p>Our Vision</p>
        </div>
    </div>
    <div class="section" id="working">
        <div class="secondcoloumn "  id="woman_para">
            <p>Our Vision is aimed to make it possible for all people from Luxembourg to either become a chef preparing delicious dishes in the comfort of their own home and get paid for it or simply if you don't have time or desire to cook every day and are looking to order a fresh, homemade dish for a more affordable price than restaurant's. You can choose any dish by category: meat - fish- pasta - vegetarian - vegan- dessert. Easy, affordable and fun!
            </p>
        </div>
        <div class="woman_image " id="vision">
            <img src="{{ asset('public/site-asset/images/woman.png') }}" alt="Woman Working">
        </div>
    </div> 
    <div class="backg" id="plates"></div>  
</main>

@endsection
