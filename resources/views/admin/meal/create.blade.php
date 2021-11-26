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
                <li class="breadcrumb-item"><a href="{{ route('admin.meal.all') }}">All Meals</a></li>
                <li class="breadcrumb-item active">Add New Meal</li>
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
                                Add New Meal
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="mealForm" action="{{ route('admin.meal.save') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="cook">Cook <small class="text-danger">*</small></label>
                                        <select class="form-control select2bs4" name="cook" id="cook">
                                            <option value="">Select Cook...</option>
                                            @forelse ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->name.' ('.$item->email.')' }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="category">Food Category</label> <small class="text-danger">*</small></label>
                                        <select class="form-control" name="category" id="category">
                                            <option value="">Select Category...</option>
                                            @forelse ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="type">Food Type</label> <small class="text-danger">*</small></label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">Select Type...</option>
                                            @forelse ($types as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="pickupDate">Pickup Date <small class="text-danger">*</small></label>
                                        <input type="date" class="form-control" name="pickupDate" id="pickupDate">
                                        <span>The time of pickup is always between {{ foodPickUpStartTime() }} to {{ foodPickUpEndTime() }}!</span>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="portions">Total Portions <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="portions" id="portions" placeholder="Enter No. of Portions">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="price">Price <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price (One Portion)" min="1">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="currency">Currency</label> <small class="text-danger">*</small></label>
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="">Select Currency...</option>
                                            @forelse ($currencies as $item)
                                                <option value="{{ $item->id }}">{{ $item->name.'('.$item->symbol.')' }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="title">Title <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="description">Description <small class="text-danger">*</small></label>
                                        <textarea name="description" id="description" rows="6" class="form-control" placeholder="Enter Description"></textarea>
                                    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group main-section">
                                        <label for="file-1" class="col-12 col-form-label">Media <small class="text-danger">*</small></label> 
                                        <div class="file-loading">
                                            <input id="file-1" name="mealMedia[]" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2" required>
                                        </div>
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

        $("#file-1").fileinput({
            theme: 'fa',
            uploadUrl: '#',
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'mp4'],
            overwriteInitial: false,
            maxFileSize: 100000,
            maxFilesNum: 10,
            slugCallback: function (filename) {

                return filename.replace('(', '_').replace(']', '_');
            }
        });

    </script>

@endpush

@push('scripts')
  
<script>

    $(document).ready(function () {

        $('#category').change(function () {

            if($(this).val() == 3) {

                $("#type option").each(function() {
                    
                    if($(this).text().toLowerCase() == 'dessert' || $(this).text().toLowerCase() == 'desert') {

                        $(this).attr('selected','selected');   
                    }
                });

                $('#type option').not(':selected').attr('disabled', 'disabled');
            }
            else {

                $('#type option').not(':selected').removeAttr('disabled');
            }
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        //Form Validation
        $('#mealForm').validate({

            ignore: [],

            rules: {

                cook: {

                    required: true,
                },
                category: {

                    required: true,
                },
                type: {

                    required: true,
                },
                price: {

                    required: true,
                    min: 1,
                },
                currency: {

                    required: true,
                },
                portions: {

                    required: true,
                },
                pickupDate:{
                  
                    required: true,
                },
                title: {

                    required: true,
                },
                description: {

                    required: true,
                },
                mealMedia: {

                    required: true,
                }
            },
            submitHandler: function (form) { 

                form.submit();
            }
        });
    });

</script>

@endpush