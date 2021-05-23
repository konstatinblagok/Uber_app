@extends('layouts.app')
@section('content')
<!-- Start All Pages -->
<div class="all-page-title page-breadcrumb">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-12">
                <h1>{{$meal->type->name}}</h1>
            </div>
        </div>
    </div>
</div>
<!-- End All Pages -->

<!-- Start blog details -->
<div class="blog-box menu-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>$meal->type->title</h2>
                    <p>$meal->type->cost</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-12">
                <div class="blog-inner-details-page">
                    <div class="blog-inner-box">
                        <div class="side-blog-img">
                            <img class="w-100 img-fluid" src="{{asset($meal->cover())}}" alt="">
                            <div class="date-blog-up">{{$meal->pickup_time->format('M d')}}</div>
                        </div>
                        <div class="inner-blog-detail details-page">
                            <h3>$meal->title</h3>
                            <ul>
                                <li><i class="zmdi zmdi-account"></i>Cooked By : <span>{{$meal->cook->name}}</span></li>
                                <li>|</li>
                                <li><i class="zmdi zmdi-time"></i>Pickup Time : <span>{{$meal->pickup_time->format('h:i A')}}</span></li>
                            </ul>
                            <blockquote>
                                <p>$meal->type->description</p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 col-12 blog-sidebar">
                <div class="right-side-blog">
                    <h3>Buy</h3>
                    <form>
                        <div class="row blog-search-form">
                            <div class="col-7">
                                <input name="search" placeholder="# of portions" type="text">
                            </div>
                            <div class="col-5 form-group">
                                <input class="form-control btn btn-outline-primary" type="submit" value="Checkout" />
                            </div>
                        </div>
                    </form>
                </div>
                    <h3>Recent Meals</h3>
                    <div class="post-box-blog">
                        <div class="recent-post-box">
                            @foreach($recent_meals as $recent_meal)
                            <div class="recent-box-blog">
                                <div class="recent-img">
                                    <img class="img-fluid" src="{{$meal->cover()}}" alt="">
                                </div>
                                <div class="recent-info">
                                    <ul>
                                        <li><i class="zmdi zmdi-account"></i>Cooked By : <span>{{$meal->cook->name}}</span></li>
                                        <li>|</li>
                                        <li><i class="zmdi zmdi-time"></i>Pickup Time : <span>{{$meal->pickup_time->format('M d h:i A')}}</span></li>
                                    </ul>
                                    <h4>$meal->title</h4>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <h3>All Food Tags</h3>
                    <div class="blog-tag-box">
                        <ul class="list-inline tag-list">
                            @foreach($food_types as $food_type)
                            <li class="list-inline-item">
                                <a href="{{route('show-menu')}}?type={{$food_type->id}}">{{$food_type->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!--Show Media-->
        <div class="row">
            <div class="col-sm-12">
                <x-site.meal-gallery meal-id="{{$meal->id}}" />
            </div>
        </div>
        <!-- End Show Media-->

        <!--Show Comments-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <x-site.meal-comments />
                </div>
            </div>
        </div>
        <!-- End Show Comments-->
    </div>
</div>
<!-- End details -->
@endsection
