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
        width: 60%;
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
    <div class="tagline how">
        <p id="How_work">@lang('lang.How it works') ?</p>
    </div>
    <div class="coloumns">
        <div class="firstcoloumn backg">
        </div>
        <div class="secondcoloumn">
            <h2>@lang('lang.A must read for the Cooks')</h2>
            <p>@lang('lang.Chez Don is an online platform, where private cooks prepare dishes at home which our clients can order'). @lang('lang.The delivery, packaging and videos will be provided by Chez Don').
            <br>@lang('lang.Everyone who is passionate about cooking in Luxembourg city can apply on the platform to become a cook of Chez Don').</p>
            <p>@lang('lang.The dishes which are prepared by the cooks need to be ready by the time between 16:30 - 17:30'). @lang('lang.Chez Don will pick them up from the cooks\' home and deliver them to the customers\' home').</p>
            <p>@lang('lang.Our Prices for different dishes are set by our cooks').
            {{-- <br>@lang('lang.Meat'). = 6 €
            <br>@lang('lang.Fish') = 7 €
            <br>@lang('lang.Vegetarian') / @lang('lang.Vegan') = 5 €
            <br> @lang('lang.Pasta') = 4 €
            <br> @lang('lang.Dessert') = 1 €</p> --}}
            <br> @lang('lang.Every Cook has a rating between 1-5 stars').
            {{-- <br> 5 @lang('lang.stars') = +4 €
            <br>4 @lang('lang.stars') = +3 €
            <br> 3 @lang('lang.stars') = +2 €
            <br> 2 @lang('lang.stars and less') = @lang('lang.you are no longer cook of Chez Don').</p>
            <p>@lang('lang.A successful cook with a 5 star rating will earn per portion'):</p>
            <p> @lang('lang.Meat'). = 10 €
            <br>@lang('lang.Fish') = 11€
            <br>@lang('lang.Vegetarian') / @lang('lang.Vegan') = 9 €
            <br>@lang('lang.Pasta') = 8 €
            <br>@lang('lang.Dessert') = 5 €</p> --}}
            <br> @lang('lang.To earn more money is easy'). @lang('lang.Our customer will normally choose the cook with the highest rating'). @lang('lang.If your food tastes delicious, the customer gives you a 5 stars review and the other customers get aware of your dishes').</p>
            <div class="signUpButton">
                <a class="submit btn btn-chezdon" href="{{ route('register') }}">@lang('Sign up') ></a>
            </div>
        </div>
    </div>
    <div class="coldevider"></div>
    <div class="coloumns">
        <div class="secondcoloumn" id="center_text">
            <h2>@lang('lang.A must read for the Clients')</h2>
            <p>@lang('lang.The cooks of Chez Don are chosen carefully'). @lang('lang.The kitchen of each cook is cleaner than in any restaurant'). @lang('lang.The delivery to the clients\' doorstep is possible every day between 18:00 - 22:00').
                <br>@lang('lang.With the video of each dish you can make sure that every meal is prepared in accordance with all the hygiene standards'). @lang('lang.To take this responsibility for the hygiene standards for our cooks and the delivery, Chez Don asks 5€/portion').
                <br>@lang('lang.The desserts are free of charges with a minimum consumption of 12€')</p>
        </div>
        <div class="firstcoloumn backg" id="oil"></div>
    </div>
    </main>

@endsection