
$(document).ready(function () {

    /**
     * Generate reservation form
     */
    function reserveForm (cabin) {
        $('.reservation-form').slideDown ("slow", function () {

            // Initiate daterange
            $('.input-daterange').datepicker({
                format: 'dd-mm-yyyy',
                startDate: '+1d',
                language: 'nb'
            });

            // Set cabin
            $('input[name="cabin"]').attr('value', cabin.id);

        });
    }

    /**
     * Show report modal
     */
    $('table.reservation-table > tbody').on('click', 'button', function (event) {

        var reservationId = $(event.target).attr('data-reservation');
        var cabinId       = $(event.target).attr('data-cabin');

        $('.reservation-report').attr('data-reservation', reservationId);
        $('.report-inventory').children('tr').remove();

        $.getJSON('cabins/'+ cabinId +'/inventory', function (inventories) {
            $(inventories).each(function (index, inventory) {
                $('.report-inventory').append(
                    '<tr data-inventory-status-id="'+inventory.id+'">' +
                        '<td>'+inventory.name+'</td>' +
                        '<td class="comment">' +
                            '<input type="text" class="form-control input-xs">'+
                        '</td>' +
                        '<td class="broken"><input type="checkbox"></td>' +
                    '</tr>'
                );

            if (index === inventories.length -1)
                $('.reservation-report').modal('show');
            });
        });
    });

    /**
     * Save report
     */
    $('button.save-report').click(function () {

        var reservationId = $('.reservation-report').attr('data-reservation');
        var report = [];

        $('.report-inventory > tr').each (function (index, row) {
            report.push({
                statusId: parseInt($(row).attr('data-inventory-status-id')),
                comment : $(row).find('.comment > input').val(),
                broken  : $(row).find('.broken > input').is(':checked')
            });
        });

        $.ajax ({
            type: 'post',
            url : 'reservations/'+reservationId+'/report',
            data: JSON.stringify(report),
            contentType: "application/json",
        })
        .fail(function(xhr) {
            swal("Feil!", xhr.responseJSON.message, "error")
        })
        .success(function (data) {
            swal("Lagret!", "Rapporten din er motatt. Takk!", "success");
            $('.reservation-report').modal('hide');
        });
    });

    /**
     * View previous reservations
     */
    $('a#reservation-previous').click(previousReservations);

    function previousReservations () {
        var reservationTable = $('table.reservation-table > tbody');
        $('.reservation-form').slideUp('slow');
        $(reservationTable).children('tr').remove();

        $.getJSON('reservations', function (reservations) {

            if (reservations.length === 0)
                swal('Feil!', 'Du har ingen tidligere reservasjoner', "error");
            else
                $(reservations).each(function (index, reservation) {
                    $(reservationTable).append(
                        '<tr>'  +
                            '<td>'+ reservation.name +'</td>' +
                            '<td>'+ reservation.from +'</td>' +
                            '<td>'+ reservation.to +'</td>' +
                            '<td class="report">' +
                                '<button type="button" ' +
                                        'class="btn btn-xs btn-danger" '+
                                        'data-reservation="'+ reservation.id+ '" '+
                                        'data-cabin="'+ reservation.cabin_id+'">' +
                                    'Avlegg' +
                                '</button>' +
                            '</td>' +
                        '</tr>'
                    );

                    if (index == reservations.length - 1)
                        $('.reservation-previous').slideDown("slow");
                });
        });
    }

    /**
     * Post reservation form
     */
    $('input[name="reserve"]').click(reserveCabin);

    function reserveCabin (id) {

        // Build parameters
        var params = {
            cabinId : $('input[name="cabin"]').val(),
            beds    : $('input[name="beds"]').val(),
            from    : $('input[name="from"]').val(),
            to      : $('input[name="to"]').val()
        }

        // Post to server
        $.ajax ({
            type: 'post',
            url : 'reserve/' + params.cabinId,
            data: params
        })
        .fail(function(xhr) {
            swal("Feil!", xhr.responseJSON.message, "error")
        })
        .success(function (data) {
            swal("Reservert!", "Koien er herved reservert", "success");
            $('.reservation-form').slideUp('slow');
            $('input[name="cabin"]').val('');
            $('input[name="beds"]').val('');
            $('input[name="from"]').val('');
            $('input[name="to"]').val('');
        });

    }


    /**
     * Display map with markers
     */
    var map = new GMaps({
      div: '#map-canvas',
      lat: 63.13,
      lng: 10.43,
      zoom: 7,
      streetViewControl: false
    });



    // console.log(map, marker);

    $.getJSON('cabins', function (cabins) {
        $(cabins).each(function (index, cabin) {

            var marker = new MarkerWithLabel({
               position: new google.maps.LatLng(cabin.latitude, cabin.longitude),
               draggable: false,
               raiseOnDrag: false,
               map: map.map,
               labelContent: cabin.name,
               labelAnchor: new google.maps.Point(22, 0),
               labelClass: 'label'
             });

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

                        // Hide reservation form if open
                        $('.reservation-previous').slideUp('slow');
                        $('.reservation-form').slideUp("slow", function () {

                            //Open the new reservation form //
                            reserveForm(cabin);
                        });

                    });
                }
            });

        });
    });
})
