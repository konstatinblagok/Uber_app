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
                                <h3>Add new Meal</h3>
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
                            <form id="cookMealForm" action="{{ route('cook.meal.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                              <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="foodType" class="col-12 col-form-label">Food <small class="text-danger">*</small></label> 
                                        <select name="foodType" id="foodType" class="form-control">
                                          <option value="">Select Food...</option>
                                          @if(count($foodType) > 0)
                                            @foreach ($foodType as $food)
                                              <option value="{{$food->id}}">{{$food->name}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="portion" class="col-12 col-form-label">Total Portion <small class="text-danger">*</small></label> 
                                        <input id="portion" name="portion" placeholder="No of Portions" class="form-control" type="number" min="1">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">Price <small class="text-danger">*</small></label> 
                                        <input id="price" name="price" placeholder="Price (One Portion)" class="form-control" type="number">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">Currency <small class="text-danger">*</small></label> 
                                        <select name="currency" id="currency" class="form-control">
                                            <option value="">Select Currency...</option>
                                            @if(count($currencies) > 0)
                                              @foreach ($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name.'('.$currency->symbol.')'}}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="deliveryDate" class="col-12 col-form-label">Pickup Date <small class="text-danger">*</small></label> 
                                        <input id="deliveryDate" name="deliveryDate" class="form-control" type="date">
                                        <span>The time of pickup is always between {{ foodPickUpStartTime() }} to {{ foodPickUpEndTime() }}!</span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="title" class="col-12 col-form-label">Title <small class="text-danger">*</small></label> 
                                        <input id="title" name="title" placeholder="Title" class="form-control" type="text">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description" class="col-12 col-form-label">Description <small class="text-danger">*</small></label> 
                                        <textarea id="description" placeholder="Description" name="description" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-md-12 main-section">
                                        <label for="file-1" class="col-12 col-form-label">Media <small class="text-danger">*</small></label> 
                                        <div class="file-loading">
                                            <input id="file-1" name="mealMedia[]" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2" required>
                                        </div>
                                    </div>
                                  <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-chezdon form-control">Add</button>
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

        //Form Validation
        $('#cookMealForm').validate({

            ignore: [],

            rules: {

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