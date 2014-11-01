var map;
  var service;
  var infowindow;

  function initialize() {

    if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(success);
    } 
    else {
      error('Geo Location is not supported');
    }
  }

  function success(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
  
    var location = new google.maps.LatLng(lat,lng);

    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: location,
        zoom: 13
      });
    map.setOptions({'scrollwheel': false});
    var request = {
      location: location,
      radius: '500',
      query: 'movie theatre'
    };
    service = new google.maps.places.PlacesService(map);
    service.textSearch(request, callback);
  }

  function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      for (var j=0; j<results.length; j++){
        createMarker(results[j]);
      }
    }
  }

  function createMarker(place){
    infowindow=new google.maps.InfoWindow({
      disableAutoPan: true,
      map: map,
      position: place.geometry.location,
    })
    var marker=new google.maps.Marker({
      map: map,
      position: place.geometry.location
    });
      var request={placeId: place.place_id};
      service.getDetails(request, callback2);
      marker.setTitle(place.name);
      infowindow.close();
      google.maps.event.addListener(marker, 'click', function() {
        var printString="";
        infowindow.open(map, this);
        if (place.name!=null){
          printString=printString+place.name+"<br />";
        }
        if (place.formatted_address!=null){
          printString=printString+place.formatted_address+"<br />";
        }
        if (place.website!=null){
          printString=printString+place.website+"<br />";
        }
        if (place.rating!=null){
          printString=printString+place.rating+"<br />";
        }
        if (place.formatted_phone_number!=null){
          printString=printString+place.formatted_phone_number;
        }
        infowindow.setContent(printString);
      });
  }

  function callback2(place, status){
    if (status == google.maps.places.PlacesServiceStatus.OK){
      createMarker(place);
    }
  }