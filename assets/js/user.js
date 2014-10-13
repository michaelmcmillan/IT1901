
$(document).ready(function () {
    var map = new GMaps({
      div: '#map-canvas',
      lat: 63.13,
      lng: 10.43,
      zoom: 8,
      streetViewControl: false
    });

    map.addMarker({
        lat: 63.13,
        lng: 10.43,
        title: 'Lima',
        animation: google.maps.Animation.DROP,
        click: function (e) {
            alert('You clicked in this marker');
        }
    });
})
