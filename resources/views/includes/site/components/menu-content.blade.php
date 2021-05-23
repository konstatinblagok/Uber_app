<div class="menu-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>Special Menu</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                </div>
            </div>
        </div>

        @if($show_filters)
        <form action="{{route('show-menu')}}" method="get">
            <div class="row">
                <div class="offset-3 col-3">
                   <div class="form-group">
                       <select name="type[]" class="selectpicker form-control" multiple data-live-search="true"
                               title="Select your food..." data-style="btn-outline-primary">
                           @foreach($food_types as $type)
                           <option value="{{$type->id}}"
                                   {{in_array($type->id, (array) request()->query('type') ?? []) ? 'selected': ''}}>
                               {{$type->name}}
                           </option>
                           @endforeach
                       </select>
                   </div>
                </div>
                <div class="m-l-10 col-3">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="pickupTime" name="time"
                               type="text" class="form-control input-small"
                               required autocomplete="pickup_time"
                               data-default-time="{{request()->query('time') ? request()->query('time') : '0530'}}"
                               aria-describedby="timpicker-addon">
                        <div class="input-group-append">
                            <span class="input-group-text input-group-addon" id="timpicker-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="m-l-10 col-2">
                    <div class="form-group">
                        <input class="form-control btn btn-outline-primary" type="submit" value="Get" />
                    </div>
                </div>
            </div>
        </form>
        @endif
        <div class="row inner-menu-box mt-4">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link {{request()->query('type') == 'all' ? 'active' : ''}}" href="{{route('show-menu')}}?type=all">All</a>
                    @foreach($food_types->take(4) as $type)
                    <a class="nav-link {{request()->query('type') == $type->id ? 'active' : ''}}" href="{{route('show-menu')}}?type={{$type->id}}">{{$type->name}}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-all-meals" role="tabpanel" aria-labelledby="v-pills-all-meals-tab">
                        <div class="row">
                            @foreach($meals as $meal)
                            <div class="col-lg-4 col-md-6 special-grid drinks">
                                <a href="{{route('show-menu-details', $meal->id)}}">
                                    <div class="gallery-single fix">
                                        <img src="{{asset($meal->cover())}}" class="img-fluid menu-content-img " alt="Image">
                                        <div class="why-text">
                                            <h4>{{$meal->type->name}}</h4>
                                            <p>$meal->description</p>
                                            <h5>$meal->cost</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach

                        </div>
                        <div class="row meal_navigations">
                            <div class="col-12 d-flex justify-content-center">
                            @if(request()->is('menu'))
                                {!! $meals->onEachSide(5)->links("pagination::bootstrap-4") !!}
                            @else
                                <a href="{{route('show-menu')}}" class="btn btn-outline-primary">Show More</a>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
