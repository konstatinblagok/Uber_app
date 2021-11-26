@extends('layouts.admin.app')

@section('title')

    <title>Admin | Meal Type Management</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Meal Type Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Meal Type Management</li>
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
                                Meal Type List (Total Types : <span id="countTotal">0</span>)
                            </h3>
                            <a href="{{ route('admin.meal.type.create') }}" type="button" class="btn btn-primary float-right">Add New Type</a>
                        </div>

                        <table id="mealType" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
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
        
        var table = $('#mealType').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            "searching": true,
            ajax: "{{ route('admin.meal.type.all') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'status_string', name: 'status_string'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            drawCallback: function (response) {

                $('#countTotal').empty();
                $('#countTotal').append(response['json'].recordsTotal);
            }
        });
        
    });

</script>

@endpush
