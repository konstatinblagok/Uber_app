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
                                <h3>@lang('lang.Add Meal')</h3>
                                <hr>
                            </div>
                            <div class="col-md-5">

                            </div>
                            <div class="col-md-3 form-group">
                                <a href="{{ route('cook.meal.index') }}" type="button" class="btn btn-chezdon form-control">@lang('lang.Back to list')</a>
                                <hr>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="padding:15px;margin-top:-40px;">
                            <form id="cookMealForm" action="{{ route('cook.meal.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                              <div class="col-md-12">
                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label for="category" class="col-12 col-form-label">@lang('lang.Category') <small class="text-danger">*</small></label> 
                                        <select name="category" id="category" class="form-control">
                                          <option value="">@lang('lang.Select Category')...</option>
                                          @if(count($categories) > 0)
                                            @foreach ($categories as $category)
                                              <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="foodType" class="col-12 col-form-label">@lang('lang.Food') <small class="text-danger">*</small></label> 
                                        <select name="foodType" id="foodType" class="form-control">
                                          <option value="">@lang('lang.Select Food')...</option>
                                          @if(count($foodType) > 0)
                                            @foreach ($foodType as $food)
                                              <option value="{{$food->id}}">{{$food->name}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="portion" class="col-12 col-form-label">@lang('lang.Total Portion') <small class="text-danger">*</small></label> 
                                        <input id="portion" name="portion" placeholder="@lang('lang.No. of Portion')" class="form-control" type="number" min="1">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">@lang('lang.Price') <small class="text-danger">*</small></label> 
                                        <input id="price" name="price" placeholder="@lang('lang.Price (One Portion)')" class="form-control" type="number">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="price" class="col-12 col-form-label">@lang('lang.Currency') <small class="text-danger">*</small></label> 
                                        <select name="currency" id="currency" class="form-control">
                                            <option value="">@lang('lang.Select Currency')...</option>
                                            @if(count($currencies) > 0)
                                              @foreach ($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->name.'('.$currency->symbol.')'}}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="deliveryDate" class="col-12 col-form-label">@lang('lang.Pickup Date') <small class="text-danger">*</small></label> 
                                        <input id="deliveryDate" name="deliveryDate" class="form-control" type="date">
                                        <span>@lang('lang.The time of pickup is always between') {{ foodPickUpStartTime() }} @lang('lang.to') {{ foodPickUpEndTime() }}!</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title" class="col-12 col-form-label">@lang('lang.Title') <small class="text-danger">*</small></label> 
                                        <input id="title" name="title" placeholder="@lang('lang.Title')" class="form-control" type="text">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description" class="col-12 col-form-label">@lang('lang.Description') <small class="text-danger">*</small></label> 
                                        <textarea id="description" placeholder="@lang('lang.Description')" name="description" class="form-control" rows="4"></textarea>
                                    </div>

                                    <div class="form-group col-md-12 main-section">
                                        <label for="file-1" class="col-12 col-form-label">@lang('lang.Media') <small class="text-danger">*</small></label> 
                                        <div class="file-loading">
                                            <input id="file-1" name="mealMedia[]" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2" required>
                                        </div>
                                    </div>
                                    
                                  <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-chezdon form-control">@lang('lang.Add Meal')</button>
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

        var CurrentLanguage = "{!! \Session::get('locale'); !!}";

        console.log(CurrentLanguage);

        $('#category').change(function () {

            if($(this).val() == 3) {

                $("#foodType option").each(function() {
                    
                    if($(this).text().toLowerCase() == 'dessert' || $(this).text().toLowerCase() == 'desert') {

                        $(this).attr('selected','selected');   
                    }
                });

                $('#foodType option').not(':selected').attr('disabled', 'disabled');
            }
            else {

                $('#foodType option').not(':selected').removeAttr('disabled');
            }
        });

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
                    min: 1,
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
            messages: {

                category: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La catégorie est obligatoire';
                        }
                        else {

                            return 'Category is required';
                        }   
                    }
                },

                foodType: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le type d\'aliment est requis';
                        }
                        else {

                            return 'Food type is required';
                        }   
                    }
                },

                price: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le prix est requis';
                        }
                        else {

                            return 'Price is required';
                        }   
                    },

                    min: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le prix doit être supérieur ou égal à 1';
                        }
                        else {

                            return 'Price must be greater than or equal to 1';
                        }   
                    }
                },

                currency: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La devise est requise';
                        }
                        else {

                            return 'Currency is required';
                        }   
                    }
                },

                portion: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le nombre de portions est requis';
                        }
                        else {

                            return 'No. of Portion is required';
                        }   
                    },

                    min: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La portion doit être supérieure ou égale à 1';
                        }
                        else {

                            return 'Portion must be greater than or equal to 1';
                        }   
                    }
                },

                deliveryDate: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La date de ramassage est requise';
                        }
                        else {

                            return 'Pickup date is required';
                        }   
                    }
                },

                title: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Le titre est requis';
                        }
                        else {

                            return 'Title is required';
                        }   
                    }
                },

                description: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'La description est requise';
                        }
                        else {

                            return 'Description is required';
                        }   
                    }
                },

                mealMedia: {

                    required: function () {

                        if(CurrentLanguage == 'fr') {

                            return 'Un support de repas est requis';
                        }
                        else {

                            return 'Meal media is required';
                        }   
                    }
                },
            },  
            submitHandler: function (form) { 

                form.submit();
            }
      });
  });

</script>

@endpush