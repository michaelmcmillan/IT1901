
$(document).ready(function () {
    /**
     * Generate status form
     */
    function statusForm (cabin) {

        $.getJSON('cabins/'+ cabin.id +'/status')
        .success(function(inventories) {
            $('.status-form').slideDown ("slow", function () {

                $('h3#cabin').text('Status for ' + cabin.name);
                $('.report-inventory').children('tr').remove();

                $(inventories).each(function (index, inventory) {

                    if (inventory.broken == '1')  broken = 'checked';
                    else                   broken = '';

                    $('.report-inventory').attr('data-reservation', inventory.reservation_id);

                    $('.report-inventory').append(
                        '<tr data-inventory-status-id="'+inventory.id+'">'+
                            '<td>'+inventory.name+'</td>' +
                            '<td class="comment">' +
                                '<input type="text" class="form-control input-xs" value="'+inventory.comment+'">'+
                            '</td>' +
                            '<td class="broken"><input type="checkbox" '+broken+'></td>' +
                        '</tr>'
                    );
                });
            });
        })
        .fail(function(xhr) {
            swal("Feil!", xhr.responseJSON.message, "error")
        });
    }

    /**
     * Update report
     */
    $('button.save-report').click(function () {

        var reservationId = $('.report-inventory').attr('data-reservation');
        var report = [];

        $('.report-inventory > tr').each (function (index, row) {
            report.push({
                statusId: parseInt($(row).attr('data-inventory-status-id')),
                broken  : $(row).find('.broken > input').is(':checked'),
                comment : $(row).find('.comment > input').val()
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
            swal("Oppdatert!", "Inventaret for koien er oppdatert", "success")
        });


    });


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
    $('a#reservation-statistics').click(reservationStatistics);

    function reservationStatistics () {
        alert(1);
        /*var reservationTable = $('table.reservation-table > tbody');
        $('.reservation-form').slideUp('slow');
        $(reservationTable).children('tr').remove();
        */
        $.getJSON('reservations', function (reservations) {

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
                    statusForm(cabin);
                }
            });
        });
    });
})
