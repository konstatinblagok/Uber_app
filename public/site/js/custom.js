(function($) {
    "use strict";

	/* ..............................................
	Loader
    ................................................. */

	$(window).on('load', function() {
		$('.preloader').fadeOut();
		$('#preloader').delay(550).fadeOut('slow');
		$('body').delay(450).css({'overflow':'visible'});
	});

	/* ..............................................
    Fixed Menu
    ................................................. */

	$(window).on('scroll', function () {
		if ($(window).scrollTop() > 50) {
			$('.top-header').addClass('fixed-menu');
		} else {
			$('.top-header').removeClass('fixed-menu');
		}
	});

	/* ..............................................
    Gallery
    ................................................. */

	$('#slides').superslides({
		inherit_width_from: '.cover-slides',
		inherit_height_from: '.cover-slides',
		play: 5000,
		animation: 'fade',
	});

	$( ".cover-slides ul li" ).append( "<div class='overlay-background'></div>" );

	/* ..............................................
    Map Full
    ................................................. */

	$(document).ready(function(){
		$(window).on('scroll', function () {
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
	});

	/* ..............................................
    Special Menu
    ................................................. */

	var Container = $('.container');
	Container.imagesLoaded(function () {
		var portfolio = $('.special-menu');
		portfolio.on('click', 'button', function () {
			$(this).addClass('active').siblings().removeClass('active');
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({
				filter: filterValue
			});
		});
		var $grid = $('.special-list').isotope({
			itemSelector: '.special-grid'
		});
	});

	/* ..............................................
    BaguetteBox
    ................................................. */

	baguetteBox.run('.tz-gallery', {
		animation: 'fadeIn',
		noScrollbars: true
	});



	/* ..............................................
    Datepicker
    ................................................. */

	// $('.datepicker').pickadate();

	// $('.time').pickatime();


	// Image Preview

    $("#profileImage").click(function(e) {
        $("#imageUpload").click();
    });

    function fasterPreview( uploader ) {
        if ( uploader.files && uploader.files[0] ){
            $('#profileImage').attr('src',
                window.URL.createObjectURL(uploader.files[0]) );
        }
    }

    $("#imageUpload").change(function(){
        fasterPreview( this );
    });

    $('#pickupTime').timepicker({
        showMeridian: true,
        minuteStep: 15,
        showInputs: true,
    }).on('changeTime.timepicker', function(evt) {
        const pickupTimeEl = $('#pickupTime');
        const hrs = evt.time.hours;
        let curMins = evt.time.minutes;
        let meridian = evt.time.meridian;

        //Check Logic: 10:15 = 10h*60m + 15m = 615 min
        curMins += hrs*60; //convert hours into minutes
        const minAllowedMins = 270; // 0430 PM
        const maxAllowedMins = 330; // 0530 PM

        if (meridian == 'AM' || curMins < minAllowedMins || curMins > maxAllowedMins ){
            toastr.clear();
            toastr.warning('Pickup Time should be between 04:30 PM to 05:30 PM');

            if(curMins < minAllowedMins){
                pickupTimeEl.timepicker('setTime', '04:30 PM');
            }else if(curMins > maxAllowedMins){
                pickupTimeEl.timepicker('setTime', '05:30 PM');
            } else {
                pickupTimeEl.timepicker('setTime', `${hrs}:${curMins} PM`);
            }
        }
    });
}(jQuery));
