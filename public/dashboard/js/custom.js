$(function() {
    $('#pickupTime').timepicker({
        showMeridian: true,
        minuteStep: 15,
        defaultTime: "0500 PM",
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
});
