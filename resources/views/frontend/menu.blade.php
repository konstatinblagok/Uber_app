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

</style>

@php
    
    $mealTitleCharactersLimit = 22;

@endphp

<main>
    <div class="section" id="menu">
        <div id="menuword">
            <p>Menu</p>
        </div>
    </div>
    <div class="menusection mt-5">

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <form action="{{route('show.menu')}}" method="GET">

                        <div class="row">

                            <div class="col-md-2 form-group">
                                <label for="mealCategory">Category</label>
                                <select name="mealCategory" id="mealCategory" class="form-control">
                                    <option value="">Select...</option>
                                    @if(count($mealCategories) > 0)
                                        @foreach ($mealCategories as $mealCategory)
                                            <option value="{{ $mealCategory->id }}" {{ \Request::get('mealCategory') == $mealCategory->id ? 'selected' : '' }}>{{ $mealCategory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="col-md-2 form-group">
                                <label for="mealType">Meal Type</label>
                                <select name="mealType" id="mealType" class="form-control">
                                    <option value="">Select...</option>
                                    @if(count($mealType) > 0)
                                        @foreach ($mealType as $type)
                                            <option value="{{ $type->id }}" {{ \Request::get('mealType') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="deliveryDate">Delivery Date</label>
                                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" value="{{ \Request::get('deliveryDate') ? \Request::get('deliveryDate') : ''}}">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="minRating">Min Rating</label>
                                <input type="number" class="form-control" id="minRating" name="minRating" min="0" value="{{ \Request::get('minRating') ? \Request::get('minRating') : '' }}" max="5">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="maxRating">Max Rating</label>
                                <input type="number" class="form-control" id="maxRating" name="maxRating" min="0" value="{{ \Request::get('maxRating') ? \Request::get('maxRating') : '' }}" max="5">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-chezdon form-control">Filter</button>
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
                                            $url = 'public/site-asset/images/beans.png';
                                        }

                                    @endphp

                                    @if($type == 'image')

                                        <img src="{{ asset($url) }}" class="card-img" alt="..." height="230">
                                    
                                    @elseif($type == 'video')

                                        <iframe src="{{ asset($url) }}" height="230" sandbox></iframe>

                                    @endif
                                        
                                    <div class="card-body">
                                        <h5 class="chezdon-color card-title">{{ \Str::limit($mnMeal->title, $mealTitleCharactersLimit, $end='...') }}</h5>
                                        <p>Category : <span class="chezdon-color">{{ $mnMeal->foodType->foodMenuCategory->name }}</span></p>
                                        <p>Food Type : <span class="chezdon-color">{{ $mnMeal->foodType->name }}</span></p>
                                        <p>Price : <span class="chezdon-color">{{ $mnMeal->currency->symbol }}{{ $mnMeal->price }}</span></p>
                                        <p>Available Portions : <span class="chezdon-color">{{ getMealAvailablePortion($mnMeal->id) > 0 ? getMealAvailablePortion($mnMeal->id) : 'Sold out! Someone was hungrier than you.' }}</span></p>
                                        <p>Delivery Date : <span class="chezdon-color">{{ $mnMeal->delivery_date }}</span></p>
                                    </div>
                                </div>
                            </a>

                            {{-- <a href="{{ route('show.meal.detail', ['id' => $mnMeal->id]) }}" class="{{ getMealAvailablePortion($mnMeal->id) <= 0 ? 'soldOutLink' : '' }}">
                                <div class="item" id="box1">
                                    <h5 class="chezdon-color">{{ $mnMeal->title }}</h5>
                                    <p>{{ $mnMeal->description }}</p>
                                    <p>Category : <span class="chezdon-color">{{ $mnMeal->foodType->foodMenuCategory->name }}</span></p>
                                    <p>Food Type : <span class="chezdon-color">{{ $mnMeal->foodType->name }}</span></p>
                                    <p>Price : <span class="chezdon-color">{{ $mnMeal->currency->symbol }}{{ $mnMeal->price }}</span></p>
                                    <p>Available Portions : <span class="chezdon-color">{{ getMealAvailablePortion($mnMeal->id) > 0 ? getMealAvailablePortion($mnMeal->id) : 'Sold out! Someone was hungrier than you.' }}</span></p>
                                    <p>Delivery Date : <span class="chezdon-color">{{ $mnMeal->delivery_date }}</span></p>
                                    <p>Cook : {{ $mnMeal->user->name }}</p>
                                    <hr>
                                </div>
                            </a> --}}

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
