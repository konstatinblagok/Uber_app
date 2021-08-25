@extends('layouts.app')
@section('content')

<style>

  .error {

    color: red;
  }

  thead tr th {

    color : #936f3b;
  }

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.cook.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>Meal Management</h3>
                                <hr>
                            </div>
                            <div class="col-md-3">
                              <a href="{{ route('cook.meal.create') }}" class="btn btn-chezdon"><i class="fas fa-plus"></i>&nbsp;Add Meal</a>
                              <hr>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="overflow-x: scroll;">

                                @php
                                
                                  $userMealCount = 1;

                                @endphp

                              <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Meal Type</th>
                                    <th scope="col">No. of Portion</th>
                                    <th scope="col">Pickup Date</th>
                                    <th scope="col">Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if(count($userMeal) > 0)
                                    @foreach ($userMeal as $meal)
                                        <tr>
                                            <th scope="row">{{$userMealCount++}}</th>
                                            <td>{{ $meal->title }}</td>
                                            <td>{{ $meal->foodType->name }}</td>
                                            <td>{{ $meal->portions }}</td>
                                            <td>{{ date('d-m-Y', strtotime($meal->delivery_date)) }}</td>
                                            <td><a class="action" href="{{ route('cook.meal.edit', ['id' => $meal->id]) }}" title="Edit"><i class="fas fa-edit" style="padding-left: 9%;"></i></a></td>
                                        </tr>
                                    @endforeach
                                  @endif
                                </tbody>
                              </table>
                              {{ $userMeal->links('includes.site.components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection