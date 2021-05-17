@extends('layouts.dashboard')
@section('dashboard-content')
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Withdraw</h4>
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

                            <form class="form-horizontal m-t-30" role="form" method="POST" action="{{route('withdraw')}}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Available Balance</label>
                                    <div class="col-md-9">
                                        <div class="col-md-offset-1 col-md-6 m-t-5">
                                            $89
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Withdraw Amount</label>
                                    <div class="col-md-offset-1 col-md-6">
                                        <div class="form-group ">
                                            <input id="" name="withdraw_amt" type="number"
                                                   class="form-control input-small @error('withdraw_amt') is-invalid @enderror"
                                                   required autocomplete="withdraw_amt"
                                                    min="0"
                                                    max="89">
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
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
