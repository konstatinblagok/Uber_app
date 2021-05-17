@extends('layouts.dashboard')
@section('dashboard-content')
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Your today's Food Selections</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container">

            <div class="row">
                <div class="col-md-offset-0 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2">
                                    <a href="{{route('view-food-selection-form')}}"
                                        class="form-control btn btn-dark waves-effect waves-light m-t-10">
                                        <i class="mdi mdi-plus"></i> Add
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if(count($todays_meals) < 1)
                                <div class="col-md-12 text-center m-t-30 m-b-30">
                                    No Foods have been added yet
                                </div>
                                @endif

                                @foreach($todays_meals as $meal)
                                <div class="col-md-4 single-food-selection m-t-20">
                                    <div>
                                        <img class="food-selection-img" src="/site/images/img-05.jpg">
                                        <div>
                                            <a class="pull-right" href="/food-selection/change/{{$meal->id}}">Edit</a>
                                        </div>
                                    </div>

                                    <div class="details">
                                        <div>
                                            <strong>Food Type:</strong> {{$meal->type->name}}
                                        </div>
                                        <div>
                                            <strong>Pickup Time:</strong>
                                            {{\Carbon\Carbon::parse($meal->pickup_time)->format('d/m/Y g:i A')}}
                                        </div>
                                        <div>
                                            <strong>Added/updated On:</strong>
                                            {{\Carbon\Carbon::parse($meal->updated_at)->format('d/m/Y g:i A')}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- End Menu -->
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
