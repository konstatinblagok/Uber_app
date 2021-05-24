<!-- Start Gallery -->
<div class="container meal-gallery">
    <div class="row">
        <div class="col-lg-12">
            <div class="heading-title text-center">
                <h2>Meal Gallery</h2>
            </div>
        </div>
    </div>
    <div class="tz-gallery">
        <div class="row">
            @foreach($medias as $media)
            <div class="col-sm-12 col-md-4 col-lg-4">
                <a class="lightbox" href="{{$media->path}}">
                    <img class="meal-gallery-img img-fluid" src="{{$media->path}}" alt="Media Gallery Image">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- End Gallery -->
