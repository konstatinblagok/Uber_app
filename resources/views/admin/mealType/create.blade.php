@extends('layouts.admin.app')

@section('title')

    <title>Admin | Food Type Management</title>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h1>Food Type Management</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.meal.type.all') }}">All Types</a></li>
                <li class="breadcrumb-item active">Add New Type</li>
            </ol>
            </div>
        </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Add New Type
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="typeForm" action="{{ route('admin.meal.type.save') }}" method="post">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="name">Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                                        
                                        <div class="nameDiv">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="status">Status <small class="text-danger">*</small></label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <button type="submit" class="form-control btn btn-primary">Create</button>
    
                                    </div>
    
                                </div>

                            </form>
                        
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
        $('#typeForm').validate({

            rules: {

                name: {

                    required: true,
                },
                status: {

                    required: true,
                },
            },
            submitHandler: function (form) { 
                
                var name = $('#name').val();
                
                $.ajax({

                    url: "{{ route('admin.meal.type.name.validation') }}",
                    method: "POST",
                    data: {

                        "_token": "{{ csrf_token() }}",
                        'name': name,
                    },
                    dataType: 'json',
                    success: function(data) {

                        if(data.success) {

                            $('.nameDiv').append('<label class="nameErrorLabel error">Name already exists!</label>');
                        }
                        else {

                            $('.nameErrorLabel').remove();
                            form.submit();
                        }
                    },
                    error: function(data) {

                        //
                    }
                });
            }
        });
    });

</script>

@endpush