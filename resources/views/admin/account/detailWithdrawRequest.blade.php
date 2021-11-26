@extends('layouts.admin.app')

@section('title')

    <title>Admin | Withdraw Request Details</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Withdraw Request Details</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.account.withdraw.request.all') }}">All Withdraw Requests</a></li>
                <li class="breadcrumb-item active">Withdraw Request Details</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                @if($withdraw->status == 'Pending' || $withdraw->status == 'Approved')

                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Update Request Details
                                </h3>
                            </div>
                            <div class="card-body">

                                <form id="withdrawRequestForm" action="{{ route('admin.account.withdraw.request.detail.update', ['id' => $withdraw->id]) }}" method="post">

                                    @csrf

                                    <div class="row">

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
        
                                            <label for="status">Status <small class="text-danger">*</small></label>
                                            <select class="form-control" name="withdrawStatus" id="withdrawStatus">
                                                <option value="Pending" {{ $withdraw->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Approved" {{ $withdraw->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="Transferred" {{ $withdraw->status == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                                                <option value="Rejected" {{ $withdraw->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
        
                                            <label for="status">Payment Method <small>(Required when request status is transferred)</small></label>
                                            <select class="form-control" name="paymentMethod" id="paymentMethod">
                                                <option value="">Select...</option>
                                                @forelse ($paymentMethods as $item)
                                                    <option value="{{ $item->name }}" {{ $withdraw->payment_method == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @empty
                                                    {{--  --}}
                                                @endforelse
                                            </select>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
        
                                            <label for="status">Transaction ID <small>(Required when request status is transferred)</small></label>
                                            <input type="text" name="transactionID" id="transactionID" class="form-control" placeholder="Enter Transaction ID" value="{{ isset($withdraw->transaction_id) ? $withdraw->transaction_id : '' }}">
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
        
                                            <label for="status">Transferred Date <small>(Required when request status is transferred)</small></label>
                                            <input type="date" name="transferDate" id="transferDate" class="form-control" value="{{ isset($withdraw->transfer_at) ? date('Y-m-d', strtotime($withdraw->transfer_at)) : '' }}">
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
        
                                            <button type="submit" class="form-control btn btn-primary">Update</button>
        
                                        </div>
        
                                    </div>

                                </form>
                            
                            </div>
                        
                        </div>
            
                    </div>

                @endif

                <div class="col-sm-12 col-md-12 {{ ($withdraw->status == 'Pending' || $withdraw->status == 'Approved') ? 'col-lg-8 col-xl-8' : 'col-lg-12 col-xl-12' }}">

                    <div class="row">

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Request Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">ID</span><p class="detailValue">{{ $withdraw->id }}</p>
        
                                        </div>
                                        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Withdraw Amount</span><p class="detailValue">{{ $withdraw->currency->symbol.' '.$withdraw->amount }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Request Status</span><p class="detailValue">{{ $withdraw->status }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payment Method</span><p class="detailValue">{{ isset($withdraw->payment_method) ? $withdraw->payment_method : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Transaction ID</span><p class="detailValue">{{ isset($withdraw->transaction_id) ? $withdraw->transaction_id : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Transferred Date</span><p class="detailValue">{{ isset($withdraw->transfer_at) ? date('d-m-Y', strtotime($withdraw->transfer_at)) : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Request Time</span><p class="detailValue">{{ isset($withdraw->created_at) ? date('d-m-Y H:i', strtotime($withdraw->created_at)) : '--' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Last Updated By</span><p class="detailValue">{{ isset($withdraw->lastUpdatedByUser) ? $withdraw->lastUpdatedByUser->name : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Last Updated At</span><p class="detailValue">{{ date('d-m-Y H:i', strtotime($withdraw->updated_at)) }}</p>
        
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
                                        Customer Account Details
                                    </h3>
                                </div>
                                <div class="card-body">
        
                                    <div class="row">
        
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">ID</span><p class="detailValue">{{ $withdraw->id }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Customer Name</span><p class="detailValue">{{ $withdraw->user->name }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Remaining Balance</span><p class="detailValue">{{ $withdraw->currency->symbol.' '.$withdraw->user->remaining_amount }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        
                                            <span class="detailKey">Payment Method</span><p class="detailValue">{{ isset($withdraw->user->latestBillingInfo) ? $withdraw->user->latestBillingInfo->paymentMethod->name : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 {{ isset($withdraw->user->latestBillingInfo) && ($withdraw->user->latestBillingInfo->payment_method_id == 1) ? '' : 'd-none' }}">
        
                                            <span class="detailKey">PayPal Email</span><p class="detailValue">{{ isset($withdraw->user->latestBillingInfo) && isset($withdraw->user->latestBillingInfo->paypal_email) ? $withdraw->user->latestBillingInfo->paypal_email : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 {{ isset($withdraw->user->latestBillingInfo) && ($withdraw->user->latestBillingInfo->payment_method_id == 2) ? '' : 'd-none' }}">
        
                                            <span class="detailKey">Card Number</span><p class="detailValue">{{ isset($withdraw->user->latestBillingInfo) && isset($withdraw->user->latestBillingInfo->card_number) ? $withdraw->user->latestBillingInfo->card_number : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 {{ isset($withdraw->user->latestBillingInfo) && ($withdraw->user->latestBillingInfo->payment_method_id == 2) ? '' : 'd-none' }}">
        
                                            <span class="detailKey">Card CVV</span><p class="detailValue">{{ isset($withdraw->user->latestBillingInfo) && isset($withdraw->user->latestBillingInfo->card_cvv) ? $withdraw->user->latestBillingInfo->card_cvv : '---' }}</p>
        
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 {{ isset($withdraw->user->latestBillingInfo) && ($withdraw->user->latestBillingInfo->payment_method_id == 2) ? '' : 'd-none' }}">
        
                                            <span class="detailKey">Card Expiry Date</span><p class="detailValue">{{ isset($withdraw->user->latestBillingInfo) && isset($withdraw->user->latestBillingInfo->card_expiry_date) ? $withdraw->user->latestBillingInfo->card_expiry_date : '---' }}</p>
        
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
        $('#withdrawRequestForm').validate({

            rules: {

                withdrawStatus: {

                    required: true,
                },
                paymentMethod: {

                    required: function(el) {

                        return $(el).closest('form').find('#withdrawStatus').val() == 'Transferred';
                    }
                },
                transactionID: {

                    required: function(el) {

                        return $(el).closest('form').find('#withdrawStatus').val() == 'Transferred';
                    }
                },
                transferDate: {

                    required: function(el) {

                        return $(el).closest('form').find('#withdrawStatus').val() == 'Transferred';
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