@extends('layouts.admin.app')

@section('title')

    <title>Admin | User Management</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>User Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">User Management</li>
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
                                User List (Total Users : <span id="countTotal">0</span>)
                            </h3>
                            <a href="{{ route('admin.user.create') }}" type="button" class="btn btn-primary float-right">Add New User</a>
                        </div>

                        <table id="users" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Email Verified</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Balance</th>
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
        
        var table = $('#users').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "searching": true,
            ajax: "{{ route('admin.user.all') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'email_verification', name: 'email_verification'},
                {data: 'user_phone', name: 'user_phone'},
                {data: 'user_status', name: 'user_status'},
                {data: 'balance', name: 'balance'},
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
