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
                <li class="breadcrumb-item active">Edit Meal</li>
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
                                Edit Meal
                            </h3>
                        </div>
                        <div class="card-body">

                            <form id="mealForm" action="{{ route('admin.meal.update', ['id' => $meal->id]) }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="cook">Cook <small class="text-danger">*</small></label>
                                        <select class="form-control select2bs4" name="cook" id="cook">
                                            <option value="">Select Cook...</option>
                                            @forelse ($users as $item)
                                                <option value="{{ $item->id }}" {{ $meal->user_id == $item->id ? 'selected' : '' }}>{{ $item->name.' ('.$item->email.')' }}</option>
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
                                                <option value="{{ $item->id }}" {{ $meal->food_category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                                <option value="{{ $item->id }}" {{ $meal->food_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 form-group">
    
                                        <label for="pickupDate">Pickup Date <small class="text-danger">*</small></label>
                                        <input type="date" class="form-control" name="pickupDate" id="pickupDate" value="{{ $meal->delivery_date }}">
                                        <span>The time of pickup is always between {{ foodPickUpStartTime() }} to {{ foodPickUpEndTime() }}!</span>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="portions">Total Portions <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="portions" id="portions" placeholder="Enter No. of Portions" value="{{ $meal->portions }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="price">Price <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price (One Portion)" min="1" value="{{ $meal->price }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 form-group">
    
                                        <label for="currency">Currency</label> <small class="text-danger">*</small></label>
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="">Select Currency...</option>
                                            @forelse ($currencies as $item)
                                                <option value="{{ $item->id }}" {{ $meal->currency_id == $item->id ? 'selected' : '' }}>{{ $item->name.'('.$item->symbol.')' }}</option>
                                            @empty
                                                {{--  --}}
                                            @endforelse
                                        </select>
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="title">Title <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{ $meal->title }}">
    
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <label for="description">Description <small class="text-danger">*</small></label>
                                        <textarea name="description" id="description" rows="6" class="form-control" placeholder="Enter Description">{{ $meal->description }}</textarea>
                                    
                                    </div>

                                    <div class="col-md-12 card">

                                        <p class="card-heading p-2">Meal Existing Media</p>

                                        @if(count($meal->mealMedia) > 0)

                                            <div class="row">

                                                @foreach($meal->mealMedia as $media)

                                                    @if($media->cookFoodMedia != null)

                                                        <div class="col-md-4 form-group">

                                                            @if($media->cookFoodMedia->type == 'image')
                        
                                                                <img src="{{ asset($media->cookFoodMedia->path.'/'.$media->cookFoodMedia->name) }}" width="254" height="220" alt="">
                                                                
                                                                @if($meal->expired == 0)
                                                                    <a href="{{ route('admin.meal.remove.media', ['id' => $media->cook_food_media_id]) }}" type="button" class="btn btn-danger">Delete</a>
                                                                @endif

                                                            @elseif($media->cookFoodMedia->type == 'video')    

                                                                <iframe src="{{ asset($media->cookFoodMedia->path.'/'.$media->cookFoodMedia->name) }}" width="254" height="220" alt="" sandbox></iframe>
                                                                
                                                                @if($meal->expired == 0)
                                                                    <a href="{{ route('admin.meal.remove.media', ['id' => $media->cook_food_media_id]) }}" type="button" class="btn btn-danger">Delete</a>
                                                                @endif

                                                            @endif

                                                        </div>

                                                    @endif
                            
                                                @endforeach

                                            </div>

                                        @endif

                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group main-section">
                                        <label for="file-1" class="col-12 col-form-label">Media <small class="text-danger">*</small></label> 
                                        <div class="file-loading">
                                            <input id="file-1" name="mealMedia[]" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                                        </div>
                                    </div>

                                    @if($meal->expired == 0)

                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
    
                                        <button type="submit" class="form-control btn btn-primary">Update</button>
    
                                    </div>

                                    @endif
    
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

        var mealMediaLength = {!! count($meal->mealMedia) !!};

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
            },
            submitHandler: function (form) { 

                if(mealMediaLength > 0) {

                    form.submit();
                }
                else {

                    if(document.getElementById("file-1").files.length == 0) {

                        alert('Please upload meal media!');
                    }
                    else {

                        form.submit();
                    }
                }
            }
        });
    });

</script>

@endpush