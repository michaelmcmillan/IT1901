
$(document).ready(function () {

    var map = new GMaps({
      div: '#map-canvas',
      lat: 63.13,
      lng: 10.43,
      zoom: 7,
      streetViewControl: false
    });

    function reserveForm (cabin) {
        $('.reservation-form').slideDown ("fast", function () {

            // Initiate daterange
            $('.input-daterange').datepicker({
                format: 'dd/mm/yyyy',
                startDate: '+1d',
                language: 'nb'
            });

            // Set cabin
            $('input[name="cabin"]').attr('value', cabin.id);

        });
    }

    $('input[name="reserve"]').click(reserveCabin);
    function reserveCabin (id) {

        var ok = $('input[name="cabin"]').attr('value');
        alert(ok);
    }

    $.getJSON('cabins', function (cabins) {
        $(cabins).each(function (index, cabin) {

            map.addMarker({
                lat: cabin.latitude,
                lng: cabin.longitude,
                title: cabin.name,
                animation: google.maps.Animation.DROP,
                click: function (e) {
                    swal({
                        title: 'Reserver ' + cabin.name,
                        text: 'Ønsker du å lage en reservasjon?',
                        type: 'info',
                        showCancelButton: true,
                        cancelButtonText: 'Nei, takk',
                        confirmButtonColor: "#18BC9C",
                        confirmButtonText: "Ja, takk!",
                        closeOnConfirm: true
                    }, function () {
                        reserveForm(cabin);
                    });
                }
            });
        });
    });


})
