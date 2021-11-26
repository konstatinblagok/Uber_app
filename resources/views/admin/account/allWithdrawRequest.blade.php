@extends('layouts.admin.app')

@section('title')

    <title>Admin | Account Management</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Account Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account Management</li>
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
                                Withdraw Request List (Total Request : <span id="countTotal">0</span>)
                            </h3>
                        </div>

                        <table id="withdraw" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Remaining Balance</th>
                                    <th>Withdraw Amount</th>
                                    <th>Request Status</th>
                                    <th>Payment Method</th>
                                    <th>Transaction ID</th>
                                    <th>Transferred Date</th>
                                    <th>Last Updated By</th>
                                    <th>Request Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

<script type="text/javascript">

    $(function () {
        
        var table = $('#withdraw').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "searching": true,
            ajax: "{{ route('admin.account.withdraw.request.all') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_name', name: 'user_name'},
                {data: 'remaining_balance', name: 'remaining_balance'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'withdraw_status', name: 'withdraw_status'},
                {data: 'payment_method', name: 'payment_method'},
                {data: 'transaction_id', name: 'transaction_id'},
                {data: 'transfer_date', name: 'transfer_date'},
                {data: 'last_updated_by', name: 'last_updated_by'},
                {data: 'request_time', name: 'request_time'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [
                {
                    targets: 2,
                    render: function ( data, type, row ) {
                        return data.length > 30 ? data.substr( 0, 30 ) +'…' : data;
                    }
                }
            ],
            drawCallback: function (response) {

                $('#countTotal').empty();
                $('#countTotal').append(response['json'].recordsTotal);
            }
        });
        
    });

</script>

@endpush
