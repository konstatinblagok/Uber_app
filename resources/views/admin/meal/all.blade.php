@extends('layouts.admin.app')

@section('title')

    <title>Admin | Meal Management</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Meal Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Meal Management</li>
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
                            <h3 class="card-title mt-2">
                                Meal List (Total Meals : <span id="countTotal">0</span>)
                            </h3>
                            <a href="{{ route('admin.meal.create') }}" type="button" class="btn btn-primary float-right">Add New Meal</a>
                        </div>

                        <table id="meals" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cook Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Meal Title</th>
                                    <th>Meal Description</th>
                                    <th>Price</th>
                                    <th>Total Portions</th>
                                    <th>Reserved Portions</th>
                                    <th>Pickup Date</th>
                                    <th>Status</th>
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
        
        var table = $('#meals').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "searching": true,
            ajax: "{{ route('admin.meal.all') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'cook_name', name: 'cook_name'},
                {data: 'category', name: 'category'},
                {data: 'type', name: 'type'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'portions', name: 'portions'},
                {data: 'reserved_portions', name: 'reserved_portions'},
                {data: 'delivery_date', name: 'delivery_date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [
                {
                    targets: 4,
                    render: function ( data, type, row ) {
                        return data.length > 25 ? data.substr( 0, 25 ) +'…' : data;
                    }
                },
                {
                    targets: 5,
                    render: function ( data, type, row ) {
                        return data.length > 35 ? data.substr( 0, 35 ) +'…' : data;
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
