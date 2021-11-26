@extends('layouts.admin.app')

@section('title')

    <title>Admin | Order Details</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Order Details</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.order.all') }}">All Orders</a></li>
                <li class="breadcrumb-item active">Order Details</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Update Order Details
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="orderForm" action="{{ route('admin.order.save.view.edit', ['id' => $order->id]) }}" method="post">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="status">Status <small class="text-danger">*</small></label>
                                        <select class="form-control" name="orderStatus" id="orderStatus">
                                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Approved" {{ $order->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancel" {{ $order->status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="status">Status Remarks</label>
                                        <textarea class="form-control" name="statusRemarks" id="statusRemarks" cols="20" rows="4" placeholder="Status Remarks...">{{ $order->status_remarks }}</textarea>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="status">Delivered Date <small>(Required when order status is delivered)</small></label>
                                        <input type="date" name="deliveredAtDate" id="deliveredAtDate" class="form-control" value="{{ isset($order->delivered_at) ? date('Y-m-d', strtotime($order->delivered_at)) : '' }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="status">Delivered Time <small>(Required when order status is delivered)</small></label>
                                        <input type="time" name="deliveredAtTime" id="deliveredAtTime" class="form-control" value="{{ isset($order->delivered_at) ? date('H:i', strtotime($order->delivered_at)) : '' }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <button type="submit" class="form-control btn btn-primary">Update</button>
    
                                    </div>
    
                                </div>

                            </form>
                        
                        </div>
                    
                    </div>
        
                </div>

                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">

                    <div class="row">

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Order Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">ID</span><p class="detailValue">{{ $order->id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">No. of Portions</span><p class="detailValue">{{ $order->quantity }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Meal Price (Each Portion)</span><p class="detailValue">{{ $order->currency->symbol.' '.$order->meal_price }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Service Charges (Each Portion)</span><p class="detailValue">{{ $order->currency->symbol.' '.$order->delivery_cost }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Total Net Amount</span><p class="detailValue">{{ $order->currency->symbol.' '.$order->net_total_amount }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Status</span><p class="detailValue">{{ $order->status }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Delivery Time</span><p class="detailValue">{{ date('d-m-Y H:i', strtotime($order->delivery_time)) }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Delivered At</span><p class="detailValue">{{ isset($order->delivered_at) ? date('d-m-Y H:i', strtotime($order->delivered_at)) : '--' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Order Place Time</span><p class="detailValue">{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Last Updated At</span><p class="detailValue">{{ date('d-m-Y H:i', strtotime($order->updated_at)) }}</p>
        
                                        </div>
        
                                    </div>
                                
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Payment Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Transaction ID</span><p class="detailValue">{{ $order->payment->payment_transaction_id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Method</span><p class="detailValue">{{ $order->payment->payment_method }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Status</span><p class="detailValue">{{ $order->payment->payment_status }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Reciever Merchant ID</span><p class="detailValue">{{ $order->payment->payee_merchant_id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payer ID</span><p class="detailValue">{{ $order->payment->payer_id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payer Email</span><p class="detailValue">{{ $order->payment->payer_email }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payer First Name</span><p class="detailValue">{{ $order->payment->payer_first_name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payer Last Name</span><p class="detailValue">{{ $order->payment->payer_last_name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Total Amount</span><p class="detailValue">{{ $order->payment->total_amount.' '.$order->payment->currency }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payment Time</span><p class="detailValue">{{ date('d-m-Y H:i', strtotime($order->payment->created_at)) }}</p>
        
                                        </div>
        
                                    </div>
                                
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Billing Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">First Name</span><p class="detailValue">{{ $order->billingInfo->first_name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Last Name</span><p class="detailValue">{{ $order->billingInfo->last_name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        
                                            <span class="detailKey">Address</span><p class="detailValue">{{ $order->billingInfo->address }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        
                                            <span class="detailKey">Appartment, Suite, Unit</span><p class="detailValue">{{ isset($order->billingInfo->apartment_suite_unit) ? $order->billingInfo->apartment_suite_unit : '--' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">City</span><p class="detailValue">{{ $order->billingInfo->city->name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Zip Code</span><p class="detailValue">{{ $order->billingInfo->zip_code }}</p>
        
                                        </div>
        
                                    </div>
                                
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Meal & Cook Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">ID</span><p class="detailValue">{{ $order->meal_id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Title</span><p class="detailValue">{{ $order->meal->title }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Category</span><p class="detailValue">{{ $order->meal->foodMenuCategory->name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Type</span><p class="detailValue">{{ $order->meal->foodType->name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        
                                            <span class="detailKey">Description</span><p class="detailValue">{{ $order->meal->description }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Cook ID</span><p class="detailValue">{{ $order->meal->user_id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Cook Name</span><p class="detailValue">{{ $order->meal->user->name }}</p>
        
                                        </div>
        
                                    </div>
                                
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>

                    </div>
        
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
  
<script>

    $(document).ready(function () {

        //Form Validation
        $('#orderForm').validate({

            rules: {

                orderStatus: {

                    required: true,
                },
                deliveredAtDate: {

                    required: function(el) {

                        return $(el).closest('form').find('#orderStatus').val() == 'Delivered';
                    }
                },
                deliveredAtTime: {

                    required: function (el) {

                        return $(el).closest('form').find('#orderStatus').val() == 'Delivered';
                    }
                },
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
    });

</script>

@endpush