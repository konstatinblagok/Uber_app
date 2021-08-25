$(document).ready(function() {

    if (typeof requestStateID !== 'undefined') {

        $.ajax({

            url: config.routes.getStateAjax,
            method: "POST",
            data: {

                "_token": $('#getToken').val(),
                'countryID': $('#country').val(),
            },
            dataType: 'json',
            success: function(data) {

                $('#state option[value != ""]').remove();

                $.each(data.states, function(key, val) {

                    if (val.id == requestStateID) {

                        $('#state').append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                    } else {

                        $('#state').append('<option value="' + val.id + '">' + val.name + '</option>');
                    }
                });
            },
            error: function(data) {

                console.log(data);
            }
        });

        $.ajax({

            url: config.routes.getCityAjax,
            method: "POST",
            data: {

                "_token": $('#getToken').val(),
                'stateID': requestStateID,
            },
            dataType: 'json',
            success: function(data) {

                $('#city option[value != ""]').remove();

                $.each(data.cities, function(key, val) {

                    if (val.id == requestCityID) {

                        $('#city').append('<option value="' + val.id + '" selected="selected">' + val.name + '</option>');
                    } else {

                        $('#city').append('<option value="' + val.id + '">' + val.name + '</option>');
                    }
                });
            },
            error: function(data) {

                console.log(data);
            }
        });
    }

    $('#country').change(function() {

        $.ajax({

            url: config.routes.getStateAjax,
            method: "POST",
            data: {

                "_token": $('#getToken').val(),
                'countryID': $(this).val(),
            },
            dataType: 'json',
            success: function(data) {

                $('#state option[value != ""]').remove();

                $.each(data.states, function(key, val) {

                    $('#state').append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            },
            error: function(data) {

                console.log(data);
            }
        });
    });

    $('#state').change(function() {

        $.ajax({

            url: config.routes.getCityAjax,
            method: "POST",
            data: {

                "_token": $('#getToken').val(),
                'stateID': $(this).val(),
            },
            dataType: 'json',
            success: function(data) {

                $('#city option[value != ""]').remove();

                $.each(data.cities, function(key, val) {

                    $('#city').append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            },
            error: function(data) {

                console.log(data);
            }
        });
    });
});