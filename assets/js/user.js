var map;

function initialize() {

  var mapOptions = {
    center: { lat: 63.13, lng: 10.43},
    zoom: 8
  };

  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

}

google.maps.event.addDomListener(window, 'load', initialize);
