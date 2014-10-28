
$(document).ready(function () {
    /**
     * Generate reservation form
     */
    function reserveForm (cabin) {
        $('.reservation-form').slideDown ("slow", function () {



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
                            '<td>'+ reservation.to +'</td>' +
                            '<td>'+ reservation.from +'</td>' +
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
     * Display map with markers
     */
    var map = new GMaps({
      div: '#map-canvas',
      lat: 63.13,
      lng: 10.43,
      zoom: 7,
      streetViewControl: false
    });

    $.getJSON('cabins', function (cabins) {
        $(cabins).each(function (index, cabin) {

            map.addMarker({
                lat: cabin.latitude,
                lng: cabin.longitude,
                title: cabin.name,
                animation: google.maps.Animation.DROP,
                click: function (e) {
                    
                }
            });
        });
    });
})
