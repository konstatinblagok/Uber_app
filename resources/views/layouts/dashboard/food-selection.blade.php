@extends('layouts.dashboard')
@section('dashboard-content')
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Select your Food for today</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container">

            <div class="row">
                <div class="col-md-offset-2 col-sm-8">
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                                @endforeach
                            </div>
                            @endif

                            @if (\Session::has('message'))
                            <div class="alert alert-info"> {{ \Session::get('message') }}</div>
                            @endif

                            <form class="form-horizontal m-t-30" role="form" method="POST" action="{{route('add-food-selection')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Food</label>
                                    <div class="col-md-9">
                                        <select id="foods-list" name="food"
                                                class="form-control @error('food') is-invalid @enderror"
                                                required autofocus>
                                            <option value="" selected>Select food</option>
                                            @foreach($foods as $food)
                                            <option value="{{$food->id}}"
                                                {{isset($todays_meal) && $todays_meal->todays_food==$food->id ?'selected': '' }}>{{$food->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('fst_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pickup Date</label>
                                    <div class="col-md-9">
                                        <div class="m-t-5">
                                            {{\Carbon\Carbon::parse(isset($todays_meal)?$todays_meal->pickup_time:now())->format('d/m/Y')}}</div>
                                    </div>
                                    @error('lst_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pickup Time</label>
                                    <div class="col-md-9">
                                        <!--                                        <input id="pickupTime" data-provide="datetimepicker"-->
                                        <!--                                               class="form-control @error('pickup_time') is-invalid @enderror"-->
                                        <!--                                               name="pickup_time" value=""-->
                                        <!--                                               min="{{\Carbon\Carbon::now()}}"-->
                                        <!--                                               required autocomplete="pickup_time">-->
                                        <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="pickupTime" name="pickup_time"
                                                   type="text" class="form-control input-small @error('pickup_time') is-invalid @enderror"
                                                   required autocomplete="pickup_time"
                                                   value="{{date('H:i', strtotime(isset($todays_meal)?$todays_meal->pickup_time:now()))}}">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>

                                    </div>
                                    @error('lst_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-6">
                                        <button type="submit"
                                                class="form-control btn btn-dark waves-effect waves-light m-t-10">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>

                            @if(isset($todays_meal))
                            <div class="form-group text-center m-t-30">
                                <h3>Attach Media Files</h3>

                                @include('includes.dashboard.media-selection')

                            </div>
                            @endif
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
