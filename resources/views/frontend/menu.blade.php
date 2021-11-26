@extends('layouts.app')
@section('content')

<style>

    .soldOutHeading{

        font-size: 16px;
        position: absolute;
        z-index: 100;
        background: transparent;
    }

    a.soldOutLink {

        color: #989a9a;
    }

    .chezdon-color {

        color:#936f3b;
    }

    p {

        margin-bottom: 0.50rem;
    }

    .user-rating {
        direction: rtl;
        font-size: 20px;
        unicode-bidi: bidi-override;
        padding: 10px 30px;
        display: inline-block;
    }

    .user-rating input {
        opacity: 0;
        position: relative;
        left: -15px;
        z-index: 2;
        cursor: pointer;
    }

    .user-rating span.star:before {
        color: #777777;
        content:"ï€†";
        /*padding-right: 5px;*/
    }

    .user-rating span.star {
        display: inline-block;
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        position: relative;
        z-index: 1;
    }

    .user-rating span {
        margin-left: -15px;
    }

    .user-rating span.star:before {
        color: #777777;
        content:"\f006";
        /*padding-right: 5px;*/
    }

    .user-rating input:hover + span.star:before, .user-rating input:hover + span.star ~ span.star:before, .user-rating input:checked + span.star:before, .user-rating input:checked + span.star ~ span.star:before {
        color: #ffd100;
        content:"\f005";
    }

    .selected-rating{
        color: #ffd100;
        font-weight: bold;
        font-size: 3em;
    }
    option.orange {
    color: orange;
    }

</style>

@php
    
    $mealTitleCharactersLimit = 22;

@endphp

<main>
    <div class="section" id="menu">
        <div id="menuword">
            <a href="{{ route('show.menu') }}" style="color: #94703A;">@lang('lang.Menu')</a>
        </div>
    </div>
    <div class="menusection mt-5">

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <form action="{{route('show.menu')}}" method="GET">

                        <div class="row">

                            <div class="col-md-2 form-group">
                                <label for="mealCategory">@lang('lang.Category')</label>
                                <select name="mealCategory" id="mealCategory" class="form-control">
                                    <option value="">@lang('lang.Select')...</option>
                                    @if(count($mealCategories) > 0)
                                        @foreach ($mealCategories as $mealCategory)
                                            <option value="{{ $mealCategory->id }}" {{ \Request::get('mealCategory') == $mealCategory->id ? 'selected' : '' }}>{{ $mealCategory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="col-md-2 form-group">
                                <label for="mealType">@lang('lang.Meal Type')</label>
                                <select name="mealType" id="mealType" class="form-control">
                                    <option value="">@lang('lang.Select')...</option>
                                    @if(count($mealType) > 0)
                                        @foreach ($mealType as $type)
                                            <option value="{{ $type->id }}" {{ \Request::get('mealType') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="deliveryDate">@lang('lang.Delivery Date')</label>
                                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" value="{{ \Request::get('deliveryDate') ? \Request::get('deliveryDate') : ''}}">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="minRating">@lang('lang.Rating')</label>
                                <select name="minRating" id="minRating" class="form-control" size="4">
                                    <option class="orange" value="5" {{ \Request::get('minRating') ? (\Request::get('minRating') == '5' ? 'selected' : '') : ''}}>&starf; &starf; &starf; &starf; &star; <span style="color:black;"> & Up</span> </option>
                                    <option class="orange" value="4" {{ \Request::get('minRating') ? (\Request::get('minRating') == '4' ? 'selected' : '') : ''}}>&starf; &starf; &starf; &star; &star; <span style="color:black;"> & Up</span> </option>
                                    <option class="orange" value="3" {{ \Request::get('minRating') ? (\Request::get('minRating') == '3' ? 'selected' : '') : ''}}>&starf; &starf; &star; &star; &star; <span style="color:black;"> & Up</span> </option>
                                </select>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-chezdon form-control">@lang('lang.Filter')</button>
                            </div>

                        </div>

                    </form>

                </div>

                @if(count($menu) > 0)
        
                    @foreach ($menu as $mnMeal)

                        <div class="col-md-4">

                            <a href="{{ route('show.meal.detail', ['id' => $mnMeal->id]) }}" class="{{ getMealAvailablePortion($mnMeal->id) <= 0 ? 'soldOutLink' : '' }}">
                                <div class="card mb-3">

                                    @php

                                        $url = '';
                                        $type = '';

                                        if(count($mnMeal->mealMedia) > 0) {

                                            if(isset($mnMeal->mealMedia[0]) && $mnMeal->mealMedia[0]->cookFoodMedia != null) {

                                                $type = $mnMeal->mealMedia[0]->cookFoodMedia->type;
                                                $url = $mnMeal->mealMedia[0]->cookFoodMedia->path.'/'.$mnMeal->mealMedia[0]->cookFoodMedia->name;
                                            }
                                        }
                                        else {

                                            $type = 'image';
                                            $url = 'public/site-asset/images/noImageFound.png';
                                        }

                                    @endphp

                                    @if($type == 'image')

                                        <img src="{{ asset($url) }}" class="card-img" style="height:15rem; object-fit: cover;" alt="...">
                                    
                                    @elseif($type == 'video')

                                        <iframe src="{{ asset($url) }}" sandbox style="height:15rem; object-fit: cover;"></iframe>

                                    @endif
                                        
                                    <div class="card-body">
                                        <h5 class="chezdon-color card-title">{{ \Str::limit($mnMeal->title, $mealTitleCharactersLimit, $end='...') }}</h5>
                                        <p>Category : <span class="chezdon-color">{{ $mnMeal->foodMenuCategory->name }}</span></p>
                                        <p>Food Type : <span class="chezdon-color">{{ $mnMeal->foodType->name }}</span></p>
                                        <p>Price : <span class="chezdon-color">{{ $mnMeal->currency->symbol }}{{ $mnMeal->price }}</span></p>
                                        <p>Available Portions : <span class="chezdon-color">

                                            @if(getMealAvailablePortion($mnMeal->id) <= 0)
                                            
                                                {{ 'Sold out! Someone was hungrier than you.' }}

                                            @elseif($mnMeal->mail_to_cook == 1)

                                                {{ 'Reservation Closed!' }}

                                            @else

                                                {{ getMealAvailablePortion($mnMeal->id) }}

                                            @endif

                                            
                                        </span></p>
                                        <p>Delivery Date : <span class="chezdon-color">{{ $mnMeal->delivery_date }}</span></p>
                                    </div>
                                </div>
                            </a>

                        </div>

                    @endforeach

                    {{ $menu->appends(\Request::only(['mealCategory', 'mealType', 'minPrice', 'maxPrice']))->links('includes.site.components.pagination') }}

                @else 
                
                    <h3 style="text-align: center;margin: 30px 0px;">No record found!</h3>

                @endif

            </div>

        </div>

    </div>
</main>

@endsection
