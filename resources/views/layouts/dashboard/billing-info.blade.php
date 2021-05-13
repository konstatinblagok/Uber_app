@extends('layouts.dashboard')
@section('dashboard-content')
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Billing Information</h4>
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

                            <form class="form-horizontal m-t-30" role="form" method="POST" action="{{route('update-billing')}}">
                                @csrf
                                <input type="hidden" name="info_id" value="{{!isset($billing_info)?:$billing_info->id}}">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Full Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name"
                                               value="{{!isset($billing_info)?:$billing_info->name}}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               required autocomplete="name">
                                    </div>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">City</label>
                                    <div class="col-md-9">
                                        <input type="text" name="city"
                                               value="{{!isset($billing_info)?:$billing_info->city}}"
                                               class="form-control @error('city') is-invalid @enderror"
                                               required autocomplete="city">
                                    </div>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">State</label>
                                    <div class="col-md-9">
                                        <input type="text" name="state"
                                               value="{{!isset($billing_info)?:$billing_info->state}}"
                                               class="form-control @error('state') is-invalid @enderror"
                                               required autocomplete="state">
                                    </div>
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Zip Code</label>
                                    <div class="col-md-9">
                                        <input type="text" name="zip_code"
                                               value="{{!isset($billing_info)?:$billing_info->zip_code}}"
                                               class="form-control @error('zip_code') is-invalid @enderror"
                                               required autocomplete="zip_code">
                                    </div>
                                    @error('zip_code')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact #</label>
                                    <div class="col-md-9">
                                        <input type="text" name="phone"
                                               value="{{!isset($billing_info)?:$billing_info->phone}}"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               required autocomplete="phone">
                                    </div>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">
                                        <textarea name="address"
                                                  class="form-control @error('address') is-invalid @enderror"
                                                  required autocomplete="address">{{!isset($billing_info)?:$billing_info->address}}</textarea>
                                    </div>
                                    @error('address')
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
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col -->
            </div> <!-- End row -->

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
