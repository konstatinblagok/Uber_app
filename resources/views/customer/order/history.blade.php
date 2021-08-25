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
            
            @include('includes.site.customer.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>Order History</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="overflow-x: scroll;">

                                @php
                                
                                  $userOrderCount = 1;

                                @endphp

                              <table class="table">
                                  <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Meal Type</th>
                                        <th scope="col">Meal Title</th>
                                        <th scope="col">No. of Portions</th>
                                        <th scope="col">Delivery Time</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Actions</th>
                                      </tr>
                                  </thead>
                                <tbody>
                                    @if(count($orderList) > 0)
                                        @foreach ($orderList as $order)
                                            <tr>
                                                <th scope="row">{{$userOrderCount++}}</th>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->meal->foodType->name }}</td>
                                                <td>{{ $order->meal->title }}</td>
                                                <td>{{ $order->quantity }}</td>
                                                <td>{{ date('d-m-Y H:i:s', strtotime($order->delivery_time)) }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->review != null ? $order->review->rating : 'Not Rated Yet!'}}</td>
                                                <td>
                                                    <a class="btn btn-secondary" href="{{ route('customer.order.detail', ['id' => $order->id]) }}" title="View Details">Details</a>

                                                    @if($order->review == null && $order->status == 'Delivered')
                                                        <a class="btn btn-chezdon" href="{{ route('customer.order.review', ['id' => $order->id]) }}" title="Review">Give Review</a>
                                                    @endif
                                                </td>    
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                              </table>
                              {{ $orderList->links('includes.site.components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection