@extends('layouts.admin.app')

@section('title')

    <title>Admin | Contact Messages</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>App Settings</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">App Settings</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Settings List & Details
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="settingForm" action="{{ route('admin.setting.save') }}" method="post">

                                @csrf

                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="adminEmail">Admin Email <small>(Where cook approval emails arrived)</small> </label>
                                        <input type="email" name="adminEmail" id="adminEmail" class="form-control" placeholder="Enter Admin Email" value="{{ $emailValue }}">
                                    </div>
    
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="cookMinAmount">Cook Minimum Withdraw Amount <small>(€)</small> </label>
                                        <input type="number" name="cookMinAmount" class="form-control" id="cookMinAmount" placeholder="Enter Cook Minimum Withdraw Amount" value="{{ $minimumWithdrawAmountValue }}" min="1">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="deliveryStartTime">Delivery Service Charges (Each Portion)</label>
                                        <input type="text" class="form-control" name="deliveryServiceCharges" id="deliveryServiceCharges" placeholder="Enter Delivery Service Charges" value="{{ $deliveryServiceChargesValue }}">
                                    </div>
    
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="deliveryStartTime">Delivery Start Time </label>
                                        <input type="time" class="form-control" name="deliveryStartTime" id="deliveryStartTime" placeholder="Enter Delivery Start Time" value="{{ $deliveryStartTimeValue }}">
                                    </div>
    
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="deliveryEndTime">Delivery End Time </label>
                                        <input type="time" class="form-control" name="deliveryEndTime" id="deliveryEndTime" placeholder="Enter Delivery End Time" value="{{ $deliveryEndTimeValue }}">
                                    </div>
    
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="pickupStartTime">Meal Pickup Start Time </label>
                                        <input type="time" class="form-control" name="pickupStartTime" id="pickupStartTime" placeholder="Enter Meal Pickup Start Time" value="{{ $mealPickupStartTimeValue }}">
                                    </div>
    
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <label for="pickupEndTime">Meal Pickup End Time </label>
                                        <input type="time" class="form-control" name="pickupEndTime" id="pickupEndTime" placeholder="Enter Meal Pickup End Time" value="{{ $mealPickupEndTimeValue }}">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <label for="pickupEndTime">PayPal Client ID </label>
                                        <input type="text" class="form-control" name="paypalClientID" id="paypalClientID" placeholder="Enter PayPal Client ID" value="{{ $paypalClientID }}">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <label for="pickupEndTime">PayPal Secret </label>
                                        <input type="text" class="form-control" name="paypalSecret" id="paypalSecret" placeholder="Enter PayPal Secret" value="{{ $paypalSecret }}">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <label for="pickupEndTime">PayPal Environment </label>
                                        <select name="paypalEnv" id="paypalEnv" class="form-control">
                                            <option value="live" {{ $paypalEnv == 'live' ? 'selected' : ''}}>Live</option>
                                            <option value="sandbox" {{ $paypalEnv == 'sandbox' ? 'selected' : ''}}>Sandbox</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                        <button type="submit" class="form-control btn btn-primary">Update Settings</button>
                                    </div>
    
                                </div>

                            </form>
                        
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
  
<script>

    $(document).ready(function() {

        //Form Validation
        $('#settingForm').validate({

            rules: {

                adminEmail: {

                    required: true,
                    email: true,
                },
                cookMinAmount: {

                    required: true,
                    digits: true,
                },
                deliveryStartTime: {

                    required: true,
                },
                deliveryEndTime: {

                    required: true,
                },
                pickupStartTime: {

                    required: true,
                },
                pickupEndTime: {

                    required: true,
                },
                paypalClientID: {

                    required: true,
                },
                paypalSecret: {

                    required: true,
                },
                paypalEnv: {

                    required: true,
                },
            },
            submitHandler: function (form) { 

                if(confirm("Are you sure you want to update app settings!")) {

                    form.submit();
                }
            }
        });
    });

</script>

@endpush
