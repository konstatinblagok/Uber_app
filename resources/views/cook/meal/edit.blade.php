@extends('layouts.app')
@section('content')

<style>

    .error {

        color: red;
    }

    .main-section{

        margin:0 auto;
        padding: 20px;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 20px #c1c1c1;
    }
    .kv-file-upload {

        display: none !important;
    }
    .fileinput-upload{

        display: none !important;
    }

    input[type="file"] {

        color: white !important;
    }

    .btn-file {

        background : #936f3b !important;
    }
    .btn-file span {

        color : white !important;
    }

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.cook.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Edit Meal</h3>
                                <hr>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-2 form-group">
                                <a href="{{ route('cook.meal.index') }}" type="button" class="btn btn-chezdon form-control">Back to list</a>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="padding:15px;margin-top:-40px;">
                            <form id="cookMealForm" action="{{ route('cook.meal.update', ['id' => $meal->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                              <div class="col-md-12">
                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label for="category" class="col-12 col-form-label">Category <small class="text-danger">*</small></label> 
                                        <select name="category" id="category" class="form-control">
                                          <option value="">Select Category...</option>
                                          @if(count($categories) > 0)
                                            @foreach ($categories as $category)
                                              <option value="{{$category->id}}" {{ $meal->food_category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="foodType" class="col-12 col-form-label">Food <small class="text-danger">*</small></label> 
                                        <select name="foodType" id="foodType" class="form-control">
                                          <option value="">Select Food...</option>
                                          @if(count($foodType) > 0)
                                            @foreach ($foodType as $food)
                                              <option value="{{$food->id}}" {{ $meal->food_type_id == $food->id ? 'selected' : '' }}>{{$food->name}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="portion" class="col-12 col-form-label">Total Portion <small class="text-danger">*</small></label> 
                                        <input id="portion" name="portion" placeholder="No of Portions" class="form-control" type="number" min="1" value="{{ $meal->portions }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">Price <small class="text-danger">*</small></label> 
                                        <input id="price" name="price" placeholder="Price (One Portion)" class="form-control" type="number" value="{{ $meal->price }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">Currency <small class="text-danger">*</small></label> 
                                        <select name="currency" id="currency" class="form-control">
                                            <option value="">Select Currency...</option>
                                            @if(count($currencies) > 0)
                                              @foreach ($currencies as $currency)
                                                <option value="{{$currency->id}}" {{ $meal->currency_id == $currency->id ? 'selected' : ''}}>{{$currency->name.'('.$currency->symbol.')'}}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="deliveryDate" class="col-12 col-form-label">Pickup Date <small class="text-danger">*</small></label> 
                                        <input id="deliveryDate" name="deliveryDate" class="form-control" type="date" value="{{ $meal->delivery_date }}">
                                        <span>The time of pickup is always between {{ foodPickUpStartTime() }} to {{ foodPickUpEndTime() }}!</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title" class="col-12 col-form-label">Title <small class="text-danger">*</small></label> 
                                        <input id="title" name="title" placeholder="Title" class="form-control" type="text" value="{{ $meal->title}}">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description" class="col-12 col-form-label">Description <small class="text-danger">*</small></label> 
                                        <textarea id="description" placeholder="Description" name="description" class="form-control" rows="4">{{ $meal->description}}</textarea>
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
                                                                <a href="{{ route('cook.meal.remove.media', ['id' => $media->cook_food_media_id]) }}" type="button" class="btn btn-chezdon form-control">Delete</a>
                                                            
                                                            @elseif($media->cookFoodMedia->type == 'video')    

                                                                <iframe src="{{ asset($media->cookFoodMedia->path.'/'.$media->cookFoodMedia->name) }}" width="254" height="220" alt="" sandbox></iframe>
                                                                <a href="{{ route('cook.meal.remove.media', ['id' => $media->cook_food_media_id]) }}" type="button" class="btn btn-chezdon form-control">Delete</a>

                                                            @endif

                                                        </div>

                                                    @endif
                            
                                                @endforeach

                                            </div>

                                        @endif

                                    </div>

                                    <div class="form-group col-md-12 main-section">
                                        <label for="file-1" class="col-12 col-form-label">Media</label> 
                                        <div class="file-loading">
                                            <input id="file-1" name="mealMedia[]" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                                        </div>
                                    </div>

                                  <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-chezdon form-control">Update</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
    
    <script>

        $("#file-1").fileinput({
            theme: 'fa',
            uploadUrl: '#',
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'bmp', 'gif', 'mp4', 'mkv', 'mov', 'avi', 'flv'],
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

        var foodTypeObject = {!! json_encode($foodType) !!};

        $('#foodType').change(function () {

            $.each(foodTypeObject, function(key, value) {

                if($('#foodType').val() == value.id) {

                    $('#price').val(value.price + '' + value.currency.symbol);
                }
            });
        });

    </script>

@endpush

@push('scripts')
  
<script>

    $(document).ready(function () {

        var mealMediaLength = {!! count($meal->mealMedia) !!};
        
        //Form Validation
        $('#cookMealForm').validate({

            ignore: [],

            rules: {

                category: {

                    required: true,
                },
                foodType: {

                    required: true,
                },
                price: {

                    required: true,
                    min: 1,
                },
                currency: {

                    required: true,
                },
                portion: {

                    required: true,
                },
                deliveryDate:{
                  
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