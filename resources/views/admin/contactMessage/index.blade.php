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
            <h1>Contact Messages</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact Messages</li>
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
                                Message List (Total Messages : <span id="countTotal">0</span>)
                            </h3>
                        </div>

                        <table id="messages" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
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
        
        var table = $('#messages').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            "searching": true,
            ajax: "{{ route('admin.contact.message.all') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'subject', name: 'subject'},
                {data: 'message', name: 'message'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs: [{
                targets: 4,
                render: function ( data, type, row ) {
                    return data.length > 50 ? data.substr( 0, 50 ) +'…' : data;
                }
            }],
            drawCallback: function (response) {

                $('#countTotal').empty();
                $('#countTotal').append(response['json'].recordsTotal);
            }
        });
        
    });

</script>

@endpush
