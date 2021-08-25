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

</style>

<main>
    <div class="container mt-4 mb-5">
        <div class="row">
            
            @include('includes.site.customer.dashboardSideBar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Order Review</h3>
                                <hr>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-2 form-group">
                                <a href="{{ route('customer.order.history') }}" type="button" class="btn btn-chezdon form-control">Back to list</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <p>Order ID : <span> {{ $order->id}} </span></p>
                                <input type="hidden" name="orderID" id="orderID" value="{{ $order->id }}">

                            </div>
                            <div class="col-md-12">

                                <form id="user-rating-form">
                                    <span>Rating : </span>
                                    <span class="user-rating">
                                        <input type="radio" name="rating" value="5"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="4"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="3"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="2"><span class="star"></span>
                                    
                                        <input type="radio" name="rating" value="1"><span class="star"></span>
                                    </span>
                                </form>

                            </div>
                            <div class="col-md-12">

                                <textarea class="form-control mt-2" name="ratingComment" id="ratingComment" cols="30" rows="10" placeholder="Comments..."></textarea>
                                
                            </div>
                            <div class="col-md-12">

                                <button type="button" class="btn btn-chezdon form-control mt-4" id="submitRating">Submit</button>
                                
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

        var ratingValue = 0;

        $('#user-rating-form').on('change','[name="rating"]', function() {

	        ratingValue = $('[name="rating"]:checked').val();
        });

        $('#submitRating').click(function() {

            if(ratingValue > 0 && ratingValue <= 5) {

                if($.trim($('#ratingComment').val()) != '') {

                    $.ajax({
                        url: "{{ route('customer.order.save.review') }}",
                        method: "POST",
                        data: {
                            'rating': ratingValue,
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
                    
                    alert('Please enter rating comments!');
                }
            }
            else {

                alert('Please select stars for rating!');
            }
        });
    </script>

@endpush