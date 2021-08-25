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
                                <h3>Withdrawal History</h3>
                                <hr>
                            </div>
                            <div class="col-md-3">
                              <a href="{{ route('cook.account.withdraw.amount') }}" class="btn btn-chezdon">Withdraw Money</a>
                              <hr>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="overflow-x: scroll;">

                                @php
                                
                                  $userWithdrawCount = 1;

                                @endphp

                              <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Transfer Date</th>
                                    <th scope="col">Withdarw Request Date/Time</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if(count($withdraw) > 0)
                                    @foreach ($withdraw as $draw)
                                        <tr>
                                            <th scope="row">{{$userWithdrawCount++}}</th>
                                            <td>{{ $draw->currency->symbol.''.$draw->amount }}</td>
                                            <td>{{ $draw->status }}</td>
                                            <td>{{ $draw->payment_method != null ? $draw->payment_method : '---' }}</td>
                                            <td>{{ $draw->transaction_id != null ? $draw->transaction_id : '---' }}</td>
                                            <td>{{ $draw->transfer_at != null ? date('d-m-Y', strtotime($draw->transfer_at)) : '---' }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($draw->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                  @endif
                                </tbody>
                              </table>
                              {{ $withdraw->links('includes.site.components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection