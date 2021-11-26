@extends('layouts.app')
@section('content')

<style>

    .error {

        color: red;
    }

    thead tr th {

        color : #936f3b;
    }

    .user-rating {
        direction: rtl;
        font-size: 20px;
        unicode-bidi: bidi-override;
        padding: 10px 30px;
        display: inline-block;
    }

    .user-rating input {
        opacity: 0;
        position: relative;
        left: -15px;
        z-index: 2;
        cursor: pointer;
    }

    .user-rating span.star:before {
        color: #777777;
        content:"ï€†";
        /*padding-right: 5px;*/
    }

    .user-rating span.star {
        display: inline-block;
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        position: relative;
        z-index: 1;
    }

    .user-rating span {
        margin-left: -15px;
    }

    .user-rating span.star:before {
        color: #777777;
        content:"\f006";
        /*padding-right: 5px;*/
    }

    .user-rating input:hover + span.star:before, .user-rating input:hover + span.star ~ span.star:before, .user-rating input:checked + span.star:before, .user-rating input:checked + span.star ~ span.star:before {
        color: #ffd100;
        content:"\f005";
    }

    .selected-rating{
        color: #ffd100;
        font-weight: bold;
        font-size: 3em;
    }
    option.orange {
    color: orange;
    }

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.customer.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>@lang('lang.Order Review')</h3>
                                <hr>
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3 form-group">
                                <a href="{{ route('customer.order.history') }}" type="button" class="btn btn-chezdon form-control">@lang('lang.Back to list')</a>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <p>@lang('lang.Order ID') : <span> {{ $order->id}} </span></p>
                                <input type="hidden" name="orderID" id="orderID" value="{{ $order->id }}">

                            </div>
                            <div class="col-md-12 form-group">

                                {{-- <form id="user-rating-form">
                                    <span>Rating : </span>
                                    <span class="user-rating">
                                        <input type="radio" name="rating" value="5"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="4"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="3"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="2"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="1"><span class="star"></span>
                                    </span>
                                </form> --}}

                                <label for="rating">@lang('lang.Rating')</label>
                                <select name="rating" id="rating" class="form-control" size="4">
                                    <option value="">Select Rating...</option>
                                    <option class="orange" value="5">&starf; &starf; &starf; &starf; &star; <span style="color:black;"> & Up</span> </option>
                                    <option class="orange" value="4">&starf; &starf; &starf; &star; &star; <span style="color:black;"> & Up</span> </option>
                                    <option class="orange" value="3">&starf; &starf; &star; &star; &star; <span style="color:black;"> & Up</span> </option>
                                </select>

                            </div>
                            <div class="col-md-12 form-group">

                                <textarea class="form-control mt-2" name="ratingComment" id="ratingComment" cols="30" rows="10" placeholder="@lang('lang.Comments')..."></textarea>
                                
                            </div>
                            <div class="col-md-12">

                                <button type="button" class="btn btn-chezdon form-control mt-4" id="submitRating">@lang('lang.Submit')</button>
                                
                            </div>
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

        var CurrentLanguage = '';

        $(document).ready(function() {

            CurrentLanguage = "{!! \Session::get('locale'); !!}";
        });

        $('#submitRating').click(function() {

            if($('#rating').val() > 0 && $('#rating').val() <= 5) {

                if($.trim($('#ratingComment').val()) != '') {

                    $.ajax({
                        url: "{{ route('customer.order.save.review') }}",
                        method: "POST",
                        data: {
                            'rating': $('#rating').val(),
                            'comment': $('#ratingComment').val(),
                            '_token': '{{csrf_token()}}',
                            'orderID': $('#orderID').val(),
                        },
                        dataType: 'json',
                        success: function(data) {
                            
                            if(data.status == true) {

                                alert(data.message);
                                window.location.replace(data.url);
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
                else {
                    
                    if(CurrentLanguage == 'fr') {

                        alert('Veuillez saisir des commentaires d\'évaluation !');
                    }
                    else {

                        alert('Please enter rating comments!');
                    }
                }
            }
            else {

                if(CurrentLanguage == 'fr') {

                    alert('Veuillez sélectionner des étoiles pour l\'évaluation !');
                }
                else {

                    alert('Please select stars for rating!');
                }
            }
        });
    </script>

@endpush